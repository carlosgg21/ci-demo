<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ServiceType;

class ServiceTypeModel extends Model
{
    protected $table            = 'service_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ServiceType::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'denomination',
        'description',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'denomination' => 'required|max_length[150]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    public function findActiveByDenomination(string $denomination): ?ServiceType
    {
        return $this->where('denomination', $denomination)
                    ->where('is_active', 1)
                    ->first();
    }

    public function getActive(): array
    {
        return $this->where('is_active', 1)->orderBy('denomination', 'ASC')->findAll();
    }

    public function getOptionsForDropdown(): array
    {
        $items = $this->where('is_active', 1)->orderBy('denomination', 'ASC')->findAll();
        $options = [];
        foreach ($items as $item) {
            $options[$item->id] = $item->denomination;
        }
        return $options;
    }
}
