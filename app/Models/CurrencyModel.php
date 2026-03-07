<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Currency;

class CurrencyModel extends Model
{
    protected $table            = 'currencies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Currency::class;  // Usamos la entidad personalizada
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    
    // Campos permitidos para asignación masiva
    protected $allowedFields = [
        'acronym',
        'name',
        'sign',
        'iso_numeric',
        'internal_code',
        'flag',
        'status'
    ];
    
    // Fechas automáticas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Reglas de validación
    protected $validationRules = [
        'acronym' => [
            'rules'  => 'required|min_length[2]|max_length[3]|is_unique[currencies.acronym,id,{id}]',
            'label'  => 'Acrónimo',
            'errors' => [
                'required'   => 'El {field} es obligatorio',
                'min_length' => 'El {field} debe tener al menos 2 caracteres',
                'max_length' => 'El {field} debe tener máximo 3 caracteres',
                'is_unique'  => 'Este {field} ya está registrado',
            ],
        ],
        'name' => [
            'rules'  => 'required|min_length[3]|max_length[50]',
            'label'  => 'Nombre',
            'errors' => [
                'required'   => 'El {field} de la moneda es obligatorio',
                'min_length' => 'El {field} debe tener al menos 3 caracteres',
                'max_length' => 'El {field} debe tener máximo 50 caracteres',
            ],
        ],
        'sign' => [
            'rules'  => 'permit_empty|max_length[5]',
            'label'  => 'Símbolo',
        ],
        'iso_numeric' => [
            'rules'  => 'permit_empty|integer|exact_length[3]|is_unique[currencies.iso_numeric,id,{id}]',
            'label'  => 'Código ISO numérico',
            'errors' => [
                'integer'    => 'El {field} debe ser un número entero',
                'exact_length' => 'El {field} debe tener exactamente 3 dígitos',
                'is_unique'  => 'Este {field} ya está registrado',
            ],
        ],
        'internal_code' => [
            'rules'  => 'permit_empty|integer',
            'label'  => 'Código interno',
        ],
        'flag' => [
            'rules'  => 'permit_empty|max_length[50]',
            'label'  => 'Bandera',
        ],
        'status' => [
            'rules'  => 'required|in_list[active,inactive]',
            'label'  => 'Estado',
            'errors' => [
                'required' => 'El {field} es obligatorio',
                'in_list'  => 'El {field} debe ser active o inactive',
            ],
        ],
    ];
    
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;
    
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    /**
     * Before Insert callback
     */
    protected function beforeInsert(array $data)
    {
        $data = $this->sanitizeData($data);
        return $data;
    }
    
    /**
     * Before Update callback
     */
    protected function beforeUpdate(array $data)
    {
        $data = $this->sanitizeData($data);
        return $data;
    }
    
    /**
     * Sanitizar datos
     */
    private function sanitizeData(array $data)
    {
        if (isset($data['data']['acronym'])) {
            $data['data']['acronym'] = strtoupper(trim($data['data']['acronym']));
        }
        
        if (isset($data['data']['name'])) {
            $data['data']['name'] = strtoupper(trim($data['data']['name']));
        }
        
        return $data;
    }
    
    // ========== MÉTODOS DE UTILIDAD ==========
    
    /**
     * Obtener monedas activas
     */
    public function getActive()
    {
        return $this->where('status', 'active')
                    ->orderBy('acronym', 'ASC')
                    ->findAll();
    }
    
    /**
     * Obtener monedas inactivas
     */
    public function getInactive()
    {
        return $this->where('status', 'inactive')
                    ->orderBy('acronym', 'ASC')
                    ->findAll();
    }
    
    /**
     * Buscar por acrónimo
     */
    public function findByAcronym(string $acronym)
    {
        return $this->where('acronym', strtoupper($acronym))->first();
    }
    
    /**
     * Buscar por código ISO numérico
     */
    public function findByIsoNumeric(int $isoNumeric)
    {
        return $this->where('iso_numeric', $isoNumeric)->first();
    }
    
    /**
     * Obtener opciones para dropdown
     */
    public function getOptionsForDropdown()
    {
        $currencies = $this->select('id, acronym, name, sign')
                           ->where('status', 'active')
                           ->orderBy('acronym', 'ASC')
                           ->findAll();
        
        $options = [];
        foreach ($currencies as $currency) {
            $options[$currency->id] = $currency->acronym . ' - ' . $currency->name . ' (' . $currency->sign . ')';
        }
        
        return $options;
    }
    
    /**
     * Contar por estado
     */
    public function countByStatus(string $status)
    {
        return $this->where('status', $status)->countAllResults();
    }
    
    /**
     * Activar moneda
     */
    public function activate(int $id)
    {
        return $this->update($id, ['status' => 'active']);
    }
    
    /**
     * Desactivar moneda
     */
    public function deactivate(int $id)
    {
        return $this->update($id, ['status' => 'inactive']);
    }
}