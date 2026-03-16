<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repositories\LocaleRepository;
use App\Responses\ApiResponse;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class LocaleController extends BaseController
{
    use ResponseTrait;

    protected LocaleRepository $repository;

    public function __construct()
    {
        $this->repository = new LocaleRepository();
    }

    public function index(): ResponseInterface
    {
        return $this->respond(
            ApiResponse::success($this->repository->getAll(), 200, 'Idiomas obtenidos exitosamente')
        );
    }

    public function show(int $id): ResponseInterface
    {
        try {
            $locale = $this->repository->getById($id);
            if (!$locale) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }
            return $this->respond(ApiResponse::success($locale, 200, 'Idioma obtenido'));
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        }
    }

    public function store(): ResponseInterface
    {
        try {
            $data = $this->request->getJSON(true) ?? $this->request->getPost();
            $data['company_id'] = $data['company_id'] ?? 1;
            $id     = $this->repository->insert($data);
            $locale = $this->repository->getById($id);

            return $this->respond(ApiResponse::success($locale, 201, 'Idioma creado exitosamente'), 201);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }

    public function update(int $id): ResponseInterface
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }
            $data = $this->request->getJSON(true) ?? $this->request->getPost();
            $this->repository->update($id, $data);
            $locale = $this->repository->getById($id);

            return $this->respond(ApiResponse::success($locale, 200, 'Idioma actualizado exitosamente'));
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }

    public function delete(int $id): ResponseInterface
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }
            $this->repository->delete($id);
            return $this->respond(ApiResponse::success(null, 200, 'Idioma eliminado exitosamente'));
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }

    public function toggleStatus(int $id): ResponseInterface
    {
        try {
            $locale = $this->repository->getById($id);
            if (!$locale) {
                throw new ResourceNotFoundException('Idioma no encontrado');
            }

            $newActive = $locale->is_active ? false : true;
            $this->repository->changeStatus($id, $newActive);

            return $this->respond(
                ApiResponse::success(['is_active' => $newActive ? 1 : 0], 200, 'Estado actualizado')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }
}
