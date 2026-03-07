<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Locale;

/**
 * Modelo Locale
 */
class LocaleModel extends Model
{
    protected $table            = 'locales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Locale::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'code',
        'name',
        'is_default',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'company_id' => 'required|numeric',
        'code'       => 'required|string|max_length[10]',
        'name'       => 'required|string|max_length[50]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener idioma por defecto de una compañía
     */
    public function findDefaultByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_default', 1)
                    ->first();
    }

    /**
     * Obtener todos los idiomas activos de una compañía
     */
    public function findActiveByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_active', 1)
                    ->findAll();
    }

    /**
     * Buscar por código y compañía
     */
    public function findByCodeAndCompany(string $code, int $companyId)
    {
        return $this->where('code', $code)
                    ->where('company_id', $companyId)
                    ->first();
    }
}
