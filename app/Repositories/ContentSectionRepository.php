<?php

namespace App\Repositories;

use App\Models\ContentSectionModel;

/**
 * Repositorio para secciones de contenido
 */
class ContentSectionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new ContentSectionModel();
    }

    public function findActiveByCompany(int $companyId)
    {
        return $this->model->findActiveByCompany($companyId);
    }

    public function findByCompanyAndType(int $companyId, int $sectionTypeId)
    {
        return $this->model->findByCompanyAndType($companyId, $sectionTypeId);
    }
}
