<?php

namespace App\Traits;

/**
 * Trait para manejo de timestamps en entidades
 */
trait TimestampTrait
{
    /**
     * Obtener fecha formateada de creación
     *
     * @param string $format Formato de la fecha
     * @return string
     */
    public function createdAtFormatted(string $format = 'd/m/Y H:i'): string
    {
        return $this->created_at?->format($format) ?? 'N/A';
    }

    /**
     * Obtener fecha formateada de actualización
     *
     * @param string $format Formato de la fecha
     * @return string
     */
    public function updatedAtFormatted(string $format = 'd/m/Y H:i'): string
    {
        return $this->updated_at?->format($format) ?? 'N/A';
    }

    /**
     * Obtener cuánto tiempo hace que fue creado
     *
     * @return string
     */
    public function createdAtAgo(): string
    {
        if (!$this->created_at) {
            return 'N/A';
        }

        $now = new \DateTime();
        $diff = $this->created_at->diff($now);

        if ($diff->y > 0) {
            return "{$diff->y} año" . ($diff->y > 1 ? 's' : '') . ' atrás';
        }
        if ($diff->m > 0) {
            return "{$diff->m} mes" . ($diff->m > 1 ? 'es' : '') . ' atrás';
        }
        if ($diff->d > 0) {
            return "{$diff->d} día" . ($diff->d > 1 ? 's' : '') . ' atrás';
        }
        if ($diff->h > 0) {
            return "{$diff->h} hora" . ($diff->h > 1 ? 's' : '') . ' atrás';
        }
        if ($diff->i > 0) {
            return "{$diff->i} minuto" . ($diff->i > 1 ? 's' : '') . ' atrás';
        }

        return 'Ahora';
    }

    /**
     * Comprobar si fue creado hoy
     *
     * @return bool
     */
    public function createdToday(): bool
    {
        if (!$this->created_at) {
            return false;
        }

        return $this->created_at->format('Y-m-d') === (new \DateTime())->format('Y-m-d');
    }

    /**
     * Comprobar si fue actualizado hoy
     *
     * @return bool
     */
    public function updatedToday(): bool
    {
        if (!$this->updated_at) {
            return false;
        }

        return $this->updated_at->format('Y-m-d') === (new \DateTime())->format('Y-m-d');
    }
}
