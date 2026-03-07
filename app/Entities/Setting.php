<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad Setting
 */
class Setting extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Obtener valor parseado según tipo
     */
    public function getParsedValue()
    {
        return match($this->type) {
            'boolean' => $this->value === '1' || $this->value === 'true',
            'integer' => (int) $this->value,
            'float'   => (float) $this->value,
            'json'    => json_decode($this->value, true),
            default   => $this->value,
        };
    }
}
