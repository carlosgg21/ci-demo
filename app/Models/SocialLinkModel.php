<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\SocialLink;

/**
 * Modelo SocialLink
 */
class SocialLinkModel extends Model
{
    protected $table            = 'social_links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SocialLink::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'entity_type',
        'entity_id',
        'platform',
        'url',
        'icon',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'entity_type' => 'required|string|max_length[50]',
        'entity_id'   => 'required|numeric',
        'platform'    => 'required|string|max_length[50]',
        'url'         => 'required|valid_url',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener links sociales de una entidad
     */
    public function findByEntity(string $entityType, int $entityId)
    {
        return $this->where('entity_type', $entityType)
                    ->where('entity_id', $entityId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener link social por plataforma
     */
    public function findByEntityAndPlatform(string $entityType, int $entityId, string $platform)
    {
        return $this->where('entity_type', $entityType)
                    ->where('entity_id', $entityId)
                    ->where('platform', $platform)
                    ->first();
    }
}
