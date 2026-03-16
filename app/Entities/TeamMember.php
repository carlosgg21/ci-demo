<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Traits\HasTranslations;

/**
 * Entidad TeamMember
 */
class TeamMember extends Entity
{
    use HasTranslations;

    protected array $translatable = ['name', 'position', 'bio'];

    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        // 'translations' cast handled by getTranslations() in HasTranslations trait
    ];

    /**
     * Verificar si esta activo
     */
    public function isActive(): bool
    {
        return $this->is_active === 1 || $this->is_active === true;
    }
}
