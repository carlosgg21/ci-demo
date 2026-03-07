<?php

namespace App\Controllers;

use App\Repositories\MediaRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class MediaController extends BaseController
{
    protected MediaRepository $repository;

    public function __construct()
    {
        $this->repository = new MediaRepository();
    }

    public function index(): string
    {
        return view('media/index', [
            'title' => 'Listado de Medios',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('media/create', ['title' => 'Agregar Medio']);
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
            return redirect()->to('media')->with('success', 'Medio guardado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Medio no encontrado');
        }
        return view('media/show', ['title' => 'Detalles del Medio', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Medio no encontrado');
        }
        return view('media/edit', ['title' => 'Editar Medio', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Medio no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("media/{$id}")->with('success', 'Medio actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Medio no encontrado');
            }
            $this->repository->delete($id);
            return redirect()->to('media')->with('success', 'Medio eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
