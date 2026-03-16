<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad Locale
 */
class Locale extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'is_active'  => 'int',
        'is_default' => 'int',
    ];

    /**
     * Verificar si es idioma por defecto
     */
    public function isDefault(): bool
    {
        return $this->is_default === 1 || $this->is_default === true;
    }

    /**
     * Verificar si está activo
     */
    public function isActive(): bool
    {
        return $this->is_active === 1 || $this->is_active === true;
    }
}
