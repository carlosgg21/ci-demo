<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad SocialLink
 */
class SocialLink extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Verificar si está activo
     */
    public function isActive(): bool
    {
        return $this->is_active === 1 || $this->is_active === true;
    }
}
