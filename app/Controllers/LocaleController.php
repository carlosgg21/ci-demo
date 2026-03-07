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
            'title' => 'Listado de Idiomas',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('locales/create', ['title' => 'Crear Nuevo Idioma']);
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
            return redirect()->to('locales')->with('success', 'Idioma creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Idioma no encontrado');
        }
        return view('locales/show', ['title' => 'Detalles del Idioma', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Idioma no encontrado');
        }
        return view('locales/edit', ['title' => 'Editar Idioma', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("locales/{$id}")->with('success', 'Idioma actualizado exitosamente');
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
