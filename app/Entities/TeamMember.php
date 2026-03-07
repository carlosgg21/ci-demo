<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad TeamMember
 */
class TeamMember extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'translations' => 'json',
    ];

    /**
     * Obtener traducción
     */
    public function getTranslation(string $locale, string $field): ?string
    {
        $translations = $this->translations ?? [];
        return $translations[$locale][$field] ?? null;
    }

    /**
     * Verificar si está activo
     */
    public function isActive(): bool
    {
        return $this->is_active === 1 || $this->is_active === true;
    }
}
