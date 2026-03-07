<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad Company
 */
class Company extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Obtener URL de logo
     */
    public function getLogoUrl(): ?string
    {
        return $this->logo ? base_url('uploads/' . $this->logo) : null;
    }

    /**
     * Obtener URL de favicon
     */
    public function getFaviconUrl(): ?string
    {
        return $this->favicon ? base_url('uploads/' . $this->favicon) : null;
    }
}
