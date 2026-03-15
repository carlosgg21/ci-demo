<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Repositories\CurrencyRepository;
use App\Responses\ApiResponse;
use App\Exceptions\ResourceNotFoundException;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class CurrencyController extends BaseController
{
    use ResponseTrait;

    protected CurrencyRepository $repository;

    public function __construct()
    {
        $this->repository = new CurrencyRepository();
    }

    /**
     * Toggle estado de una moneda (active <-> inactive)
     */
    public function toggleStatus(int $id): ResponseInterface
    {
        try {
            $currency = $this->repository->getById($id);

            if (!$currency) {
                throw new ResourceNotFoundException('Moneda no encontrada');
            }

            $newStatus = $currency->status === 'active' ? 'inactive' : 'active';
            $this->repository->changeStatus($id, $newStatus);

            return $this->respond(
                ApiResponse::success(['status' => $newStatus], 200, 'Estado actualizado')
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
