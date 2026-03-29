<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repositories\ServiceTypeRepository;
use App\Responses\ApiResponse;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceTypeController extends BaseController
{
    use ResponseTrait;

    protected ServiceTypeRepository $repository;

    public function __construct()
    {
        $this->repository = new ServiceTypeRepository();
    }

    public function toggleStatus(int $id): ResponseInterface
    {
        try {
            $item = $this->repository->getById($id);

            if (!$item) {
                throw new ResourceNotFoundException('Tipo de servicio no encontrado');
            }

            $newActive = $item->is_active ? false : true;
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
}
