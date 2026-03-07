<?php

namespace App\Controllers;

use App\Repositories\SocialLinkRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class SocialLinkController extends BaseController
{
    protected SocialLinkRepository $repository;

    public function __construct()
    {
        $this->repository = new SocialLinkRepository();
    }

    public function index(): string
    {
        return view('social_links/index', [
            'title' => 'Listado de Enlaces Sociales',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('social_links/create', ['title' => 'Crear Nuevo Enlace Social']);
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
            return redirect()->to('social-links')->with('success', 'Enlace social creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Enlace social no encontrado');
        }
        return view('social_links/show', ['title' => 'Detalles del Enlace', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Enlace social no encontrado');
        }
        return view('social_links/edit', ['title' => 'Editar Enlace Social', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Enlace social no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("social-links/{$id}")->with('success', 'Enlace social actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Enlace social no encontrado');
            }
            $this->repository->delete($id);
            return redirect()->to('social-links')->with('success', 'Enlace social eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
