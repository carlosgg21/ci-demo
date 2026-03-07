<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\SectionType;

/**
 * Modelo SectionType
 */
class SectionTypeModel extends Model
{
    protected $table            = 'section_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SectionType::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'key',
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'key'  => 'required|alpha_dash|is_unique[section_types.key]',
        'name' => 'required|string|max_length[100]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Buscar por clave
     */
    public function findByKey(string $key)
    {
        return $this->where('key', $key)->first();
    }
}
