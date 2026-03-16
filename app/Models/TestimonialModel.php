<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Testimonial;

/**
 * Modelo Testimonial
 */
class TestimonialModel extends Model
{
    protected $table            = 'testimonials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Testimonial::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'client_name',
        'client_position',
        'content',
        'translations',
        'rating',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected array $castHandlers = [
        'safe-json' => \App\DataCaster\Cast\SafeJsonCast::class,
    ];

    protected array $casts = [
        'translations' => 'safe-json',
    ];

    protected $validationRules = [
        'company_id' => 'required|numeric',
        'client_name' => 'required|string|max_length[150]',
        'content' => 'required|string',
        'rating' => 'permit_empty|numeric|greater_than_equal_to[1]|less_than_equal_to[5]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener testimonios activos de una compañía
     */
    public function findActiveByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener testimonios con calificación
     */
    public function findWithRatingByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_active', 1)
                    ->where('rating !=', null)
                    ->orderBy('rating', 'DESC')
                    ->findAll();
    }
}
