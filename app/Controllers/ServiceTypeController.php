<?php

namespace App\Controllers;

use App\Repositories\ServiceTypeRepository;
use App\Requests\StoreServiceTypeRequest;
use App\Requests\UpdateServiceTypeRequest;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class ServiceTypeController extends BaseController
{
    protected ServiceTypeRepository $repository;

    public function __construct()
    {
        $this->repository = new ServiceTypeRepository();
    }

    public function index(): string
    {
        return view('service-types/index', [
            'title'        => 'Tipos de Servicio',
            'pageTitle'    => 'Tipos de Servicio',
            'breadcrumb'   => ['Catálogos' => null, 'Tipos de Servicio' => null],
            'serviceTypes' => $this->repository->getAll(),
            'stats'        => $this->repository->getStats(),
        ]);
    }

    public function new()
    {
        return redirect()->to('service-types');
    }

    public function create(): RedirectResponse
    {
        try {
            StoreServiceTypeRequest::validate($this->request);
            $data = StoreServiceTypeRequest::validated($this->request);
            $this->repository->save($data);

            return redirect()->to('service-types')
                           ->with('success', 'Tipo de servicio creado exitosamente');
        } catch (\App\Exceptions\ValidationException $e) {
            return redirect()->back()
                           ->with('errors', $e->getErrors())
                           ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage())
                           ->withInput();
        }
    }

    public function show(int $id): string
    {
        $item = $this->repository->getById($id);

        if (!$item) {
            throw new ResourceNotFoundException('Tipo de servicio no encontrado');
        }

        return view('service-types/show', [
            'title' => 'Detalle del Tipo de Servicio',
            'item'  => $item,
        ]);
    }

    public function edit(int $id)
    {
        return redirect()->to('service-types');
    }

    public function update(int $id): RedirectResponse
    {
        try {
            $item = $this->repository->getById($id);

            if (!$item) {
                throw new ResourceNotFoundException('Tipo de servicio no encontrado');
            }

            UpdateServiceTypeRequest::validate($this->request, $id);
            $data = UpdateServiceTypeRequest::validated($this->request, $id);
            $this->repository->update($id, $data);

            return redirect()->to('service-types')
                           ->with('success', 'Tipo de servicio actualizado exitosamente');
        } catch (\App\Exceptions\ValidationException $e) {
            return redirect()->back()
                           ->with('errors', $e->getErrors())
                           ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage())
                           ->withInput();
        }
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Tipo de servicio no encontrado');
            }

            $this->repository->delete($id);

            return redirect()->to('service-types')
                           ->with('success', 'Tipo de servicio eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage());
        }
    }
}
