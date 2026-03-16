<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    protected UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function login(): string|RedirectResponse
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login', ['title' => 'Iniciar Sesión']);
    }

    public function doLogin(): RedirectResponse
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->repository->getModel()->findActiveByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Correo o contraseña incorrectos.')
                ->withInput();
        }

        session()->set([
            'user_id'    => $user->id,
            'user_name'  => $user->username,
            'user_email' => $user->email,
            'user_role'  => $user->role,
            'logged_in'  => true,
        ]);

        $redirect = session()->getFlashdata('redirect_url') ?? '/dashboard';
        return redirect()->to($redirect)->with('success', '¡Bienvenido, ' . esc($user->username) . '!');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function profile(): string|RedirectResponse
    {
        $userId = session()->get('user_id');
        $user   = $this->repository->getById($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        return view('auth/profile', ['title' => 'Mi Perfil', 'user' => $user]);
    }

    public function updateProfile(): RedirectResponse
    {
        $userId = session()->get('user_id');
        $user   = $this->repository->getById($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        $newPassword = $this->request->getPost('new_password');
        $confirmPass = $this->request->getPost('confirm_password');

        if ($newPassword) {
            $currentPass = $this->request->getPost('current_password');
            if (!password_verify($currentPass, $user->password)) {
                return redirect()->back()
                    ->with('error', 'La contraseña actual es incorrecta.')
                    ->withInput();
            }
            if ($newPassword !== $confirmPass) {
                return redirect()->back()
                    ->with('error', 'Las contraseñas nuevas no coinciden.')
                    ->withInput();
            }
            if (strlen($newPassword) < 6) {
                return redirect()->back()
                    ->with('error', 'La contraseña debe tener al menos 6 caracteres.')
                    ->withInput();
            }
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        try {
            // Skip unique validation for current user
            $model = $this->repository->getModel();
            $model->skipValidation(true);
            $model->update($userId, $data);

            session()->set('user_name', $data['username']);
            session()->set('user_email', $data['email']);

            return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
