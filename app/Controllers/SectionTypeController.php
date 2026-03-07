<?php

namespace App\Controllers;

use App\Repositories\SectionTypeRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class SectionTypeController extends BaseController
{
    protected SectionTypeRepository $repository;

    public function __construct()
    {
        $this->repository = new SectionTypeRepository();
    }

    public function index(): string
    {
        return view('section_types/index', [
            'title' => 'Listado de Tipos de Sección',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('section_types/create', ['title' => 'Crear Nuevo Tipo']);
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
            return redirect()->to('section-types')->with('success', 'Tipo de sección creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Tipo de sección no encontrado');
        }
        return view('section_types/show', ['title' => 'Detalles del Tipo', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Tipo de sección no encontrado');
        }
        return view('section_types/edit', ['title' => 'Editar Tipo de Sección', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Tipo de sección no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("section-types/{$id}")->with('success', 'Tipo de sección actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Tipo de sección no encontrado');
            }
            $this->repository->delete($id);
            return redirect()->to('section-types')->with('success', 'Tipo de sección eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
