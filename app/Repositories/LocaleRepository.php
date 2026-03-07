<?php

namespace App\Repositories;

use App\Models\LocaleModel;

/**
 * Repositorio para locales (idiomas)
 */
class LocaleRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new LocaleModel();
    }

    public function findDefaultByCompany(int $companyId)
    {
        return $this->model->findDefaultByCompany($companyId);
    }

    public function findActiveByCompany(int $companyId)
    {
        return $this->model->findActiveByCompany($companyId);
    }
}
