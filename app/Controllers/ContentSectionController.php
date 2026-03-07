<?php

namespace App\Controllers;

use App\Repositories\ContentSectionRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class ContentSectionController extends BaseController
{
    protected ContentSectionRepository $repository;

    public function __construct()
    {
        $this->repository = new ContentSectionRepository();
    }

    public function index(): string
    {
        return view('content_sections/index', [
            'title' => 'Listado de Secciones de Contenido',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('content_sections/create', ['title' => 'Crear Nueva Sección']);
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
            return redirect()->to('content-sections')->with('success', 'Sección creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Sección no encontrada');
        }
        return view('content_sections/show', ['title' => 'Detalles de la Sección', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Sección no encontrada');
        }
        return view('content_sections/edit', ['title' => 'Editar Sección', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Sección no encontrada');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("content-sections/{$id}")->with('success', 'Sección actualizada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Sección no encontrada');
            }
            $this->repository->delete($id);
            return redirect()->to('content-sections')->with('success', 'Sección eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
