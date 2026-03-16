<?php

namespace App\Controllers;

use App\Repositories\LocaleRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class LocaleController extends BaseController
{
    protected LocaleRepository $repository;

    public function __construct()
    {
        $this->repository = new LocaleRepository();
    }

    public function index(): string
    {
        return view('locales/index', [
            'title'      => 'Listado de Idiomas',
            'pageTitle'  => 'Idiomas',
            'breadcrumb' => ['Configuración' => null, 'Idiomas' => null],
            'locales'    => $this->repository->getAll(),
            'stats'      => $this->repository->getStats(),
        ]);
    }

    public function store(): RedirectResponse
    {
        try {
            $data = [
                'company_id' => 1,
                'code'       => $this->request->getPost('code'),
                'name'       => $this->request->getPost('name'),
                'is_default' => (int) $this->request->getPost('is_default'),
                'is_active'  => (int) $this->request->getPost('is_active'),
            ];

            $this->repository->insert($data);

            return redirect()->to('locales')->with('success', 'Idioma creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }

            $data = [
                'code'       => $this->request->getPost('code'),
                'name'       => $this->request->getPost('name'),
                'is_default' => (int) $this->request->getPost('is_default'),
                'is_active'  => (int) $this->request->getPost('is_active'),
            ];

            $this->repository->update($id, $data);

            return redirect()->to('locales')->with('success', 'Idioma actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }

            $this->repository->delete($id);

            return redirect()->to('locales')->with('success', 'Idioma eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
