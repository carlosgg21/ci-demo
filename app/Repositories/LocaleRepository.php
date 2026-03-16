<?php

namespace App\Repositories;

use App\Models\LocaleModel;

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

    public function changeStatus(int $id, bool $isActive): bool
    {
        return $this->update($id, ['is_active' => $isActive ? 1 : 0]);
    }

    public function getStats(): array
    {
        $total    = $this->count();
        $active   = $this->countWhere('is_active', 1);
        $inactive = $this->countWhere('is_active', 0);

        return [
            'total'    => $total,
            'active'   => $active,
            'inactive' => $inactive,
        ];
    }
}
