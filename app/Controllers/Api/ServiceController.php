<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repositories\ServiceRepository;
use App\Requests\StoreServiceRequest;
use App\Requests\UpdateServiceRequest;
use App\Responses\ApiResponse;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\ValidationException;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controlador API para gestionar servicios
 * Proporciona endpoints RESTful para operaciones de servicios
 */
class ServiceController extends BaseController
{
    use ResponseTrait;

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
     * Obtener listado de servicios
     *
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        $services = $this->repository->getAll();

        return $this->respond(
            ApiResponse::success($services, 200, 'Servicios obtenidos exitosamente')
        );
    }

    /**
     * Obtener servicios paginados
     *
     * @return ResponseInterface
     */
    public function browser(): ResponseInterface
    {
      
         $services = $this->repository->getAll();

        return $this->respond(
            ApiResponse::success($services, 200, 'Servicios obtenidos exitosamente')
        );
    }

    /**
     * Obtener un servicio específico
     *
     * @param int $id ID del servicio
     * @return ResponseInterface
     */
    public function show(int $id): ResponseInterface
    {
        try {
            $service = $this->repository->getById($id);

            if (!$service) {
                throw new ResourceNotFoundException('Servicio no encontrado');
            }

            return $this->respond(
                ApiResponse::success($service, 200, 'Servicio obtenido')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(
                ApiResponse::notFound($e->getMessage()),
                404
            );
        }
    }

    /**
     * Crear un nuevo servicio
     *
     * @return ResponseInterface
     */
    public function store(): ResponseInterface
    {
        try {
            StoreServiceRequest::validate($this->request);
            $data = StoreServiceRequest::validated($this->request);
            $id = $this->repository->insert($data);
            $service = $this->repository->getById($id);

            return $this->respond(
                ApiResponse::success($service, 201, 'Servicio creado exitosamente'),
                201
            );
        } catch (ValidationException $e) {
            return $this->respond(
                ApiResponse::validationFailed($e->getErrors()),
                422
            );
        } catch (\Exception $e) {
            return $this->respond(
                ApiResponse::error($e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * Actualizar un servicio
     *
     * @param int $id ID del servicio
     * @return ResponseInterface
     */
    public function update(int $id): ResponseInterface
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Servicio no encontrado');
            }

            UpdateServiceRequest::validate($this->request, $id);
            $data = UpdateServiceRequest::validated($this->request, $id);
            $this->repository->update($id, $data);
            $service = $this->repository->getById($id);

            return $this->respond(
                ApiResponse::success($service, 200, 'Servicio actualizado exitosamente')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(
                ApiResponse::notFound($e->getMessage()),
                404
            );
        } catch (ValidationException $e) {
            return $this->respond(
                ApiResponse::validationFailed($e->getErrors()),
                422
            );
        } catch (\Exception $e) {
            return $this->respond(
                ApiResponse::error($e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * Eliminar un servicio
     *
     * @param int $id ID del servicio
     * @return ResponseInterface
     */
    public function delete(int $id): ResponseInterface
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Servicio no encontrado');
            }

            $this->repository->delete($id);

            return $this->respond(
                ApiResponse::success(null, 200, 'Servicio eliminado exitosamente')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(
                ApiResponse::notFound($e->getMessage()),
                404
            );
        } catch (\Exception $e) {
            return $this->respond(
                ApiResponse::error($e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * Toggle estado de un servicio (is_active 1 <-> 0)
     */
    public function toggleStatus(int $id): ResponseInterface
    {
        try {
            $service = $this->repository->getById($id);

            if (!$service) {
                throw new ResourceNotFoundException('Servicio no encontrado');
            }

            $newActive = $service->is_active ? false : true;
            $this->repository->changeStatus($id, $newActive);

            return $this->respond(
                ApiResponse::success(['is_active' => $newActive ? 1 : 0], 200, 'Estado actualizado')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(
                ApiResponse::notFound($e->getMessage()),
                404
            );
        } catch (\Exception $e) {
            return $this->respond(
                ApiResponse::error($e->getMessage(), 500),
                500
            );
        }
    }

    /**
     * Obtener servicios activos
     *
     * @return ResponseInterface
     */
    public function active(): ResponseInterface
    {
        $services = $this->repository->findAllActive();

        return $this->respond(
            ApiResponse::success($services, 200, 'Servicios activos obtenidos')
        );
    }

    /**
     * Obtener servicios inactivos
     *
     * @return ResponseInterface
     */
    public function inactive(): ResponseInterface
    {
        $services = $this->repository->findAllInactive();

        return $this->respond(
            ApiResponse::success($services, 200, 'Servicios inactivos obtenidos')
        );
    }

    /**
     * Buscar servicios
     *
     * @return ResponseInterface
     */
    public function search(): ResponseInterface
    {
        $term = $this->request->getVar('q', '');

        if (strlen($term) < 2) {
            return $this->respond(
                ApiResponse::error('El término de búsqueda debe tener al menos 2 caracteres', 400),
                400
            );
        }

        $services = $this->repository->searchByNameOrDescription($term);

        return $this->respond(
            ApiResponse::success($services, 200, 'Búsqueda completada')
        );
    }
}
