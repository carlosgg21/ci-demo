<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Currency extends Entity
{
    protected $datas = [
        'id'            => null,
        'acronym'       => null,
        'name'          => null,
        'sign'          => null,
        'iso_numeric'   => null,
        'internal_code' => null,
        'flag'          => null,
        'status'        => 'active',
        'created_at'    => null,
        'updated_at'    => null,
        'deleted_at'    => null,
    ];
    
    protected $casts = [
        'id'            => 'integer',
        'iso_numeric'   => 'integer',
        'internal_code' => 'integer',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
        'deleted_at'    => 'datetime',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    protected $attributes = [
        'status' => 'active'
    ];
    
    // ========== MUTATORS (SETTERS) ==========
    
    /**
     * Set acronym (siempre mayúsculas)
     */
    public function setAcronym(string $acronym)
    {
        $this->attributes['acronym'] = strtoupper(trim($acronym));
        return $this;
    }
    
    /**
     * Set name (siempre mayúsculas)
     */
    public function setName(string $name)
    {
        $this->attributes['name'] = strtoupper(trim($name));
        return $this;
    }
    
    /**
     * Set iso_numeric (asegurar entero)
     */
    public function setIsoNumeric($isoNumeric)
    {
        $this->attributes['iso_numeric'] = $isoNumeric ? (int)$isoNumeric : null;
        return $this;
    }
    
    // ========== ACCESSORS (GETTERS) ==========
    
    /**
     * Get formatted name (Acronym - Name)
     */
    public function getFormattedName()
    {
        return $this->attributes['acronym'] . ' - ' . $this->attributes['name'];
    }
    
    /**
     * Get display name with sign
     */
    public function getDisplayName()
    {
        $sign = $this->attributes['sign'] ?? '';
        return trim($this->attributes['acronym'] . ' ' . $sign);
    }
    
    /**
     * Check if currency is active
     */
    public function isActive()
    {
        return $this->attributes['status'] === 'active';
    }
    
    /**
     * Check if currency is inactive
     */
    public function isInactive()
    {
        return $this->attributes['status'] === 'inactive';
    }
    
    /**
     * Get flag HTML (si usas Flag Icons CSS)
     */
    public function getFlagHtml()
    {
        if (empty($this->attributes['flag'])) {
            return '';
        }
        
        return '<span class="' . $this->attributes['flag'] . '"></span>';
    }
    
    /**
     * Get status badge HTML
     */
    public function getStatusBadge()
    {
        if ($this->isActive()) {
            return '<span class="badge bg-success">Activo</span>';
        }
        
        return '<span class="badge bg-danger">Inactivo</span>';
    }
    
  
    
    /**
     * To JSON personalizado
     */
    public function toJson(bool $onlyChanged = false, bool $cast = true): string
    {
        return json_encode($this->toArray($onlyChanged, $cast));
    }
    
    /**
     * Activar moneda
     */
    public function activate()
    {
        $this->attributes['status'] = 'active';
        return $this;
    }
    
    /**
     * Desactivar moneda
     */
    public function deactivate()
    {
        $this->attributes['status'] = 'inactive';
        return $this;
    }
}