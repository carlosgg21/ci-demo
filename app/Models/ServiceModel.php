<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Service;

/**
 * Modelo Service
 */
class ServiceModel extends Model
{
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Service::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'slug',
        'image',
        'icon',
        'translations',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected array $casts = [
        'translations' => 'json',
    ];

    protected $validationRules = [
        'company_id' => 'required|numeric',
        'slug'       => 'required|alpha_dash|max_length[150]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener servicios activos de una compañía
     */
    public function findActiveByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Buscar por slug y compañía
     */
    public function findBySlugAndCompany(string $slug, int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('slug', $slug)
                    ->first();
    }

    /**
     * Buscar por compañía ordenado
     */
    public function findByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Búsqueda de servicios
     */
    public function search(string $term, int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->like('slug', $term)
                    ->findAll();
    }
}
