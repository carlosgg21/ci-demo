<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Media;

/**
 * Modelo Media
 */
class MediaModel extends Model
{
    protected $table            = 'media';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Media::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'entity_type',
        'entity_id',
        'file_path',
        'type',
        'alt_text',
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
        'file_path'   => 'required|string|max_length[255]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener media de una entidad
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
     * Obtener primera imagen de una entidad
     */
    public function findFirstImageByEntity(string $entityType, int $entityId)
    {
        return $this->where('entity_type', $entityType)
                    ->where('entity_id', $entityId)
                    ->where('is_active', 1)
                    ->like('type', 'image')
                    ->orderBy('sort_order', 'ASC')
                    ->first();
    }

    /**
     * Obtener todas las imágenes de una entidad
     */
    public function findImagesByEntity(string $entityType, int $entityId)
    {
        return $this->where('entity_type', $entityType)
                    ->where('entity_id', $entityId)
                    ->where('is_active', 1)
                    ->like('type', 'image')
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
