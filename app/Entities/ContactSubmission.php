<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Entidad ContactSubmission
 */
class ContactSubmission extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Verificar si está leído
     */
    public function isRead(): bool
    {
        return $this->is_read === 1 || $this->is_read === true;
    }

    /**
     * Marcar como leído
     */
    public function markAsRead(): void
    {
        $this->is_read = 1;
    }

    /**
     * Marcar como no leído
     */
    public function markAsUnread(): void
    {
        $this->is_read = 0;
    }
}
