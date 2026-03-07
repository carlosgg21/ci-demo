<?php

namespace App\Repositories;

use App\Models\CompanyModel;

/**
 * Repositorio para compañías
 */
class CompanyRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new CompanyModel();
    }

    public function findBySlug(string $slug)
    {
        return $this->model->findBySlug($slug);
    }
}
