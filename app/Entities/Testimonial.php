<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Traits\HasTranslations;

/**
 * Entidad Testimonial
 */
class Testimonial extends Entity
{
    use HasTranslations;

    protected array $translatable = ['client_name', 'client_position', 'content'];

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

    /**
     * Validar calificacion
     */
    public function hasRating(): bool
    {
        return $this->rating !== null && $this->rating > 0;
    }
}
