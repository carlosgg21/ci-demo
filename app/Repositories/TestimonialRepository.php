<?php

namespace App\Repositories;

use App\Models\TestimonialModel;

/**
 * Repositorio para testimonios
 */
class TestimonialRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new TestimonialModel();
    }

    public function findActiveByCompany(int $companyId)
    {
        return $this->model->findActiveByCompany($companyId);
    }

    public function findWithRatingByCompany(int $companyId)
    {
        return $this->model->findWithRatingByCompany($companyId);
    }
}
