<?php

namespace App\Controllers;

use App\Repositories\ContactSubmissionRepository;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class ContactSubmissionController extends BaseController
{
    protected ContactSubmissionRepository $repository;

    public function __construct()
    {
        $this->repository = new ContactSubmissionRepository();
    }

    public function index(): string
    {
        return view('contact_submissions/index', [
            'title' => 'Listado de Envíos de Contacto',
            'items' => $this->repository->getAll(),
        ]);
    }

    public function create(): string
    {
        return view('contact_submissions/create', ['title' => 'Agregar Envío']);
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
            return redirect()->to('contact-submissions')->with('success', 'Envío guardado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Envío no encontrado');
        }
        return view('contact_submissions/show', ['title' => 'Detalles del Envío', 'item' => $item]);
    }

    public function edit(int $id): string
    {
        $item = $this->repository->getById($id);
        if (!$item) {
            throw new ResourceNotFoundException('Envío no encontrado');
        }
        return view('contact_submissions/edit', ['title' => 'Editar Envío', 'item' => $item]);
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Envío no encontrado');
            }
            $data = $this->request->getPost();
            if (!$this->repository->getModel()->validate($data)) {
                return redirect()->back()
                               ->with('errors', $this->repository->getModel()->errors())
                               ->withInput();
            }
            $this->repository->update($id, $data);
            return redirect()->to("contact-submissions/{$id}")->with('success', 'Envío actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Envío no encontrado');
            }
            $this->repository->delete($id);
            return redirect()->to('contact-submissions')->with('success', 'Envío eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
