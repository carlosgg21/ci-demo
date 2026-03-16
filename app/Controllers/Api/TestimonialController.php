<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repositories\TestimonialRepository;
use App\Responses\ApiResponse;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class TestimonialController extends BaseController
{
    use ResponseTrait;

    protected TestimonialRepository $repository;

    public function __construct()
    {
        $this->repository = new TestimonialRepository();
    }

    public function index(): ResponseInterface
    {
        return $this->respond(
            ApiResponse::success($this->repository->getAll(), 200, 'Testimonios obtenidos')
        );
    }

    public function show(int $id): ResponseInterface
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }
            return $this->respond(ApiResponse::success($item, 200, 'Testimonio obtenido'));
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        }
    }

    public function store(): ResponseInterface
    {
        try {
            $data = $this->request->getJSON(true) ?: $this->request->getPost();
            $model = $this->repository->getModel();

            if (!$model->validate($data)) {
                return $this->respond(ApiResponse::validationFailed($model->errors()), 422);
            }

            $id = $this->repository->insert($data);
            $item = $this->repository->getById($id);

            return $this->respond(ApiResponse::success($item, 201, 'Testimonio creado exitosamente'), 201);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }

    public function update(int $id): ResponseInterface
    {
        try {
            if (!$this->repository->exists($id)) {
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }

            $data = $this->request->getJSON(true) ?: $this->request->getPost();
            $this->repository->update($id, $data);
            $item = $this->repository->getById($id);

            return $this->respond(ApiResponse::success($item, 200, 'Testimonio actualizado'));
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
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }
            $this->repository->delete($id);
            return $this->respond(ApiResponse::success(null, 200, 'Testimonio eliminado'));
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }

    public function updateTranslations(int $id): ResponseInterface
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }

            $data = $this->request->getJSON(true);
            $translations = $data['translations'] ?? [];

            $this->repository->update($id, ['translations' => json_encode($translations)]);

            return $this->respond(
                ApiResponse::success(['translations' => $translations], 200, 'Traducciones actualizadas')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }

    public function toggleStatus(int $id): ResponseInterface
    {
        try {
            $item = $this->repository->getById($id);
            if (!$item) {
                throw new ResourceNotFoundException('Testimonio no encontrado');
            }

            $newActive = $item->is_active ? 0 : 1;
            $this->repository->update($id, ['is_active' => $newActive]);

            return $this->respond(
                ApiResponse::success(['is_active' => $newActive], 200, 'Estado actualizado')
            );
        } catch (ResourceNotFoundException $e) {
            return $this->respond(ApiResponse::notFound($e->getMessage()), 404);
        } catch (\Exception $e) {
            return $this->respond(ApiResponse::error($e->getMessage(), 500), 500);
        }
    }
}
