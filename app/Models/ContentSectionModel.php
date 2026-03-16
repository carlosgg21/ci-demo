<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ContentSection;

/**
 * Modelo ContentSection
 */
class ContentSectionModel extends Model
{
    protected $table            = 'content_sections';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ContentSection::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'section_type_id',
        'title',
        'subtitle',
        'content',
        'button_text',
        'translations',
        'button_link',
        'metadata',
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
        'metadata'     => 'safe-json',
    ];

    protected $validationRules = [
        'company_id'      => 'required|numeric',
        'section_type_id' => 'required|numeric',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener secciones activas de una compañía
     */
    public function findActiveByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener secciones por tipo
     */
    public function findByCompanyAndType(int $companyId, int $sectionTypeId)
    {
        return $this->where('company_id', $companyId)
                    ->where('section_type_id', $sectionTypeId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
