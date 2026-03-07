<?php

namespace App\Repositories;

use App\Models\SectionTypeModel;

/**
 * Repositorio para tipos de secciones
 */
class SectionTypeRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new SectionTypeModel();
    }

    public function findByKey(string $key)
    {
        return $this->model->findByKey($key);
    }
}
