<?php

namespace App\Repositories;

use App\Models\SettingModel;

/**
 * Repositorio para configuraciones
 */
class SettingRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new SettingModel();
    }

    public function findByKeyAndCompany(string $key, ?int $companyId = null)
    {
        return $this->model->findByKeyAndCompany($key, $companyId);
    }

    public function findByCompany(?int $companyId = null)
    {
        return $this->model->findByCompany($companyId);
    }
}
