<?php

namespace App\Repositories;

use App\Models\ServiceTypeModel;
use App\Entities\ServiceType;

class ServiceTypeRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new ServiceTypeModel();
    }

    public function findAllActive(): array
    {
        return $this->model->where('is_active', 1)->findAll();
    }

    public function findAllInactive(): array
    {
        return $this->model->where('is_active', 0)->findAll();
    }

    public function countActive(): int
    {
        return $this->countWhere('is_active', 1);
    }

    public function countInactive(): int
    {
        return $this->countWhere('is_active', 0);
    }

    public function findByDenomination(string $denomination): ?ServiceType
    {
        return $this->findBy('denomination', $denomination);
    }

    public function searchByDenomination(string $term): array
    {
        return $this->model
            ->groupStart()
                ->like('denomination', $term)
                ->orLike('description', $term)
            ->groupEnd()
            ->findAll();
    }

    public function getStats(): array
    {
        $total    = $this->count();
        $active   = $this->countActive();
        $inactive = $this->countInactive();

        return [
            'total'      => $total,
            'active'     => $active,
            'inactive'   => $inactive,
            'percentage' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
        ];
    }

    public function activate(int $id): bool
    {
        return $this->update($id, ['is_active' => 1]);
    }

    public function deactivate(int $id): bool
    {
        return $this->update($id, ['is_active' => 0]);
    }

    public function changeStatus(int $id, bool $isActive): bool
    {
        return $this->update($id, ['is_active' => $isActive ? 1 : 0]);
    }

    public function denominationExists(string $denomination, ?int $excludeId = null): bool
    {
        $query = $this->model->where('denomination', $denomination);

        if ($excludeId !== null) {
            $query->where('id !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }

    public function getOptionsForDropdown(): array
    {
        return $this->model->getOptionsForDropdown();
    }
}
