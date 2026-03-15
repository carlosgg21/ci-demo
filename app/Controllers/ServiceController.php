<?php

namespace App\Controllers;

use App\Repositories\ServiceRepository;
use App\Requests\StoreServiceRequest;
use App\Requests\UpdateServiceRequest;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Controlador para gestionar servicios
 * Maneja las operaciones web (vistas) de servicios
 */
class ServiceController extends BaseController
{
    /**
     * Instancia del repositorio de servicios
     *
     * @var ServiceRepository
     */
    protected ServiceRepository $repository;

    /**
     * Constructor
     * Inicializa el repositorio
     */
    public function __construct()
    {
        $this->repository = new ServiceRepository();
    }

    /**
     * Listar todos los servicios paginados
     *
     * @return string
     */
    public function index(): string
    {
        return view('services/index', [
            'title'      => 'Listado de Servicios',
            'pageTitle'  => 'Servicios',
            'breadcrumb' => ['Configuración' => null, 'Servicios' => null],
            'services'   => $this->repository->getAll(),
            'stats'      => $this->repository->getStats(),
        ]);
    }

    /**
     * Mostrar formulario para crear nuevo servicio
     *
     * @return string
     */
    public function create(): string
    {
        return view('services/create', [
            'title' => 'Crear Nuevo Servicio',
        ]);
    }

    /**
     * Guardar nuevo servicio
     *
     * @return RedirectResponse
     */
    public function store(): RedirectResponse
    {
        try {
            StoreServiceRequest::validate($this->request);

            $data = StoreServiceRequest::validated($this->request);
            $this->repository->save($data);

            return redirect()->to('services')
                           ->with('success', 'Servicio creado exitosamente');
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

    /**
     * Mostrar detalles de un servicio
     *
     * @param int $id ID del servicio
     * @return string
     * @throws ResourceNotFoundException
     */
    public function show(int $id): string
    {
        $service = $this->repository->getById($id);

        if (!$service) {
            throw new ResourceNotFoundException('Servicio no encontrado');
        }

        return view('services/show', [
            'title'   => 'Detalles del Servicio',
            'service' => $service,
        ]);
    }

    /**
     * Mostrar formulario para editar un servicio
     *
     * @param int $id ID del servicio
     * @return string
     * @throws ResourceNotFoundException
     */
    public function edit(int $id): string
    {
        $service = $this->repository->getById($id);

        if (!$service) {
            throw new ResourceNotFoundException('Servicio no encontrado');
        }

        return view('services/edit', [
            'title'   => 'Editar Servicio',
            'service' => $service,
        ]);
    }

    /**
     * Actualizar un servicio
     *
     * @param int $id ID del servicio
     * @return RedirectResponse
     * @throws ResourceNotFoundException
     */
    public function update(int $id): RedirectResponse
    {
        try {
            $service = $this->repository->getById($id);

            if (!$service) {
                throw new ResourceNotFoundException('Servicio no encontrado');
            }

            UpdateServiceRequest::validate($this->request, $id);
            $data = UpdateServiceRequest::validated($this->request, $id);
            $this->repository->update($id, $data);

            return redirect()->to("services/{$id}")
                           ->with('success', 'Servicio actualizado exitosamente');
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

    /**
     * Eliminar un servicio
     *
     * @param int $id ID del servicio
     * @return RedirectResponse
     * @throws ResourceNotFoundException
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Servicio no encontrado');
            }

            $this->repository->delete($id);

            return redirect()->to('services')
                           ->with('success', 'Servicio eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', $e->getMessage());
        }
    }
}
