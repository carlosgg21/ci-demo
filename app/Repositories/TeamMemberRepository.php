<?php

namespace App\Repositories;

use App\Models\TeamMemberModel;

/**
 * Repositorio para miembros del equipo
 */
class TeamMemberRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new TeamMemberModel();
    }

    public function findActiveByCompany(int $companyId)
    {
        return $this->model->findActiveByCompany($companyId);
    }

    public function findByCompany(int $companyId)
    {
        return $this->model->findByCompany($companyId);
    }
}
