<?php

namespace App\Repositories;

use App\Models\ServiceModel;
use App\Entities\Service;

/**
 * Repositorio para la entidad Service
 * Maneja todas las operaciones de datos para servicios
 */
class ServiceRepository extends BaseRepository
{
    /**
     * Constructor
     * Inicializa la instancia del modelo
     */
    public function __construct()
    {
        $this->model = new ServiceModel();
    }

    /**
     * Obtener todos los servicios activos
     *
     * @return array
     */
    public function findAllActive(): array
    {
        return $this->model->where('is_active', 1)->findAll();
    }

    /**
     * Obtener todos los servicios inactivos
     *
     * @return array
     */
    public function findAllInactive(): array
    {
        return $this->model->where('is_active', 0)->findAll();
    }

    /**
     * Contar servicios activos
     *
     * @return int
     */
    public function countActive(): int
    {
        return $this->countWhere('is_active', 1);
    }

    /**
     * Contar servicios inactivos
     *
     * @return int
     */
    public function countInactive(): int
    {
        return $this->countWhere('is_active', 0);
    }

    /**
     * Buscar servicios por slug
     *
     * @param string $term Término de búsqueda (slug)
     * @return array
     */
    public function searchBySlug(string $term): array
    {
        return $this->model->like('slug', $term)->findAll();
    }

    /**
     * Buscar servicios por slug exacto
     *
     * @param string $slug Slug a buscar
     * @return Service|null
     */
    public function findBySlug(string $slug): ?Service
    {
        return $this->findBy('slug', $slug);
    }

    /**
     * Obtener servicios recientes
     *
     * @param int $limit Cantidad de registros
     * @return array
     */
    public function getRecent(int $limit = 10): array
    {
        return $this->model->orderBy('created_at', 'DESC')
                          ->limit($limit)
                          ->findAll();
    }

    /**
     * Obtener servicios más antiguos
     *
     * @param int $limit Cantidad de registros
     * @return array
     */
    public function getOldest(int $limit = 10): array
    {
        return $this->model->orderBy('created_at', 'ASC')
                          ->limit($limit)
                          ->findAll();
    }

    /**
     * Obtener estadísticas de servicios
     *
     * @return array
     */
    public function getStats(): array
    {
        $total = $this->count();
        $active = $this->countActive();
        $inactive = $this->countInactive();

        return [
            'total'      => $total,
            'active'     => $active,
            'inactive'   => $inactive,
            'percentage' => $total > 0 ? round(($active / $total) * 100, 2) : 0
        ];
    }

    /**
     * Obtener servicios con paginación ordenados por fecha
     *
     * @param int $perPage Registros por página
     * @param int $page Página actual
     * @return array
     */
    public function getPaginatedRecent(int $perPage = 10, int $page = 1): array
    {
        return $this->model->orderBy('created_at', 'DESC')
                          ->paginate($perPage, 'default', $page);
    }

    /**
     * Activar un servicio
     *
     * @param int $id ID del servicio
     * @return bool
     */
    public function activate(int $id): bool
    {
        return $this->update($id, ['is_active' => 1]);
    }

    /**
     * Desactivar un servicio
     *
     * @param int $id ID del servicio
     * @return bool
     */
    public function deactivate(int $id): bool
    {
        return $this->update($id, ['is_active' => 0]);
    }

    /**
     * Cambiar estado de un servicio
     *
     * @param int $id ID del servicio
     * @param bool $isActive Nuevo estado
     * @return bool
     */
    public function changeStatus(int $id, bool $isActive): bool
    {
        return $this->update($id, ['is_active' => $isActive ? 1 : 0]);
    }

    /**
     * Verificar si existe un servicio con ese slug
     *
     * @param string $slug Slug a verificar
     * @param int|null $excludeId ID a excluir de la búsqueda
     * @return bool
     */
    public function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = $this->model->where('slug', $slug);

        if ($excludeId !== null) {
            $query->where('id !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }
}
