<?php

namespace App\Controllers;

use App\Repositories\CompanyRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class CompanyController extends BaseController
{
    protected CompanyRepository $repository;

    public function __construct()
    {
        $this->repository = new CompanyRepository();
    }

    public function index(): string
    {
        return view('companies/index', [
            'title' => 'Listado de Compañías',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('companies/create', ['title' => 'Crear Nueva Compañía']);
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
            return redirect()->to('companies')->with('success', 'Compañía creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Compañía no encontrada');
        }
        return view('companies/show', ['title' => 'Detalles de la Compañía', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Compañía no encontrada');
        }
        return view('companies/edit', ['title' => 'Editar Compañía', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Compañía no encontrada');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("companies/{$id}")->with('success', 'Compañía actualizada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Compañía no encontrada');
            }
            $this->repository->delete($id);
            return redirect()->to('companies')->with('success', 'Compañía eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
