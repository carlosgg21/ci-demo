<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad Media
 */
class Media extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Obtener URL completa del archivo
     */
    public function getUrl(): string
    {
        return base_url($this->file_path);
    }

    /**
     * Verificar si está activo
     */
    public function isActive(): bool
    {
        return $this->is_active === 1 || $this->is_active === true;
    }

    /**
     * Es imagen
     */
    public function isImage(): bool
    {
        return $this->type === 'image' || str_starts_with($this->type ?? '', 'image/');
    }

    /**
     * Es video
     */
    public function isVideo(): bool
    {
        return $this->type === 'video' || str_starts_with($this->type ?? '', 'video/');
    }
}
