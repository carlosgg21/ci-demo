<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Setting;

/**
 * Modelo Setting
 */
class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Setting::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'key',
        'value',
        'type',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'key'   => 'required|string|max_length[100]',
        'value' => 'required|string',
        'type'  => 'required|in_list[text,boolean,integer,float,json]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Buscar setting por clave y compañía
     */
    public function findByKeyAndCompany(string $key, ?int $companyId = null)
    {
        $query = $this->where('key', $key);
        if ($companyId) {
            $query->where('company_id', $companyId);
        } else {
            $query->where('company_id', null);
        }
        return $query->first();
    }

    /**
     * Obtener settings de una compañía
     */
    public function findByCompany(?int $companyId = null)
    {
        $query = $this->newInstance();
        if ($companyId) {
            $query->where('company_id', $companyId);
        } else {
            $query->where('company_id', null);
        }
        return $query->findAll();
    }
}
