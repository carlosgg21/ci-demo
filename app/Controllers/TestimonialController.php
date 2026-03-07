<?php

namespace App\Controllers;

use App\Repositories\TestimonialRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class TestimonialController extends BaseController
{
    protected TestimonialRepository $repository;

    public function __construct()
    {
        $this->repository = new TestimonialRepository();
    }

    public function index(): string
    {
        return view('testimonials/index', [
            'title' => 'Listado de Testimonios',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('testimonials/create', ['title' => 'Crear Nuevo Testimonio']);
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
            return redirect()->to('testimonials')->with('success', 'Testimonio creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Testimonio no encontrado');
        }
        return view('testimonials/show', ['title' => 'Detalles del Testimonio', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Testimonio no encontrado');
        }
        return view('testimonials/edit', ['title' => 'Editar Testimonio', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("testimonials/{$id}")->with('success', 'Testimonio actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }
            $this->repository->delete($id);
            return redirect()->to('testimonials')->with('success', 'Testimonio eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
