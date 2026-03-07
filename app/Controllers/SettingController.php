<?php

namespace App\Controllers;

use App\Repositories\SettingRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class SettingController extends BaseController
{
    protected SettingRepository $repository;

    public function __construct()
    {
        $this->repository = new SettingRepository();
    }

    public function index(): string
    {
        return view('settings/index', [
            'title' => 'Listado de Configuraciones',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('settings/create', ['title' => 'Crear Nueva Configuración']);
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
            return redirect()->to('settings')->with('success', 'Configuración creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Configuración no encontrada');
        }
        return view('settings/show', ['title' => 'Detalles de Configuración', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Configuración no encontrada');
        }
        return view('settings/edit', ['title' => 'Editar Configuración', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Configuración no encontrada');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("settings/{$id}")->with('success', 'Configuración actualizada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Configuración no encontrada');
            }
            $this->repository->delete($id);
            return redirect()->to('settings')->with('success', 'Configuración eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
