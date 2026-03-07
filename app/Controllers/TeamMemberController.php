<?php

namespace App\Controllers;

use App\Repositories\TeamMemberRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class TeamMemberController extends BaseController
{
    protected TeamMemberRepository $repository;

    public function __construct()
    {
        $this->repository = new TeamMemberRepository();
    }

    public function index(): string
    {
        return view('team_members/index', [
            'title' => 'Listado de Miembros',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('team_members/create', ['title' => 'Crear Nuevo Miembro']);
    }

    public function store(): RedirectResponse
    {
        try {
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->save($data);
            return redirect()->to('team-members')->with('success', 'Miembro creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Miembro no encontrado');
        }
        return view('team_members/show', ['title' => 'Detalles del Miembro', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Miembro no encontrado');
        }
        return view('team_members/edit', ['title' => 'Editar Miembro', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Miembro no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("team-members/{$id}")->with('success', 'Miembro actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Miembro no encontrado');
            }
            $this->repository->delete($id);
            return redirect()->to('team-members')->with('success', 'Miembro eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
