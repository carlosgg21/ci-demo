<?php

namespace App\Repositories;

use App\Models\CurrencyModel;
use App\Entities\Currency;

/**
 * Repositorio para la entidad Currency
 * Maneja todas las operaciones de datos para monedas
 */
class CurrencyRepository extends BaseRepository
{
    /**
     * Constructor
     * Inicializa la instancia del modelo
     */
    public function __construct()
    {
        $this->model = new CurrencyModel();
    }

    /**
     * Obtener todas las monedas activas
     *
     * @return array
     */
    public function findAllActive(): array
    {
        return $this->model->where('status', 'active')->findAll();
    }

    /**
     * Obtener todas las monedas inactivas
     *
     * @return array
     */
    public function findAllInactive(): array
    {
        return $this->model->where('status', 'inactive')->findAll();
    }

    /**
     * Contar monedas activas
     *
     * @return int
     */
    public function countActive(): int
    {
        return $this->countWhere('status', 'active');
    }

    /**
     * Contar monedas inactivas
     *
     * @return int
     */
    public function countInactive(): int
    {
        return $this->countWhere('status', 'inactive');
    }

    /**
     * Buscar monedas por acrónimo, nombre o símbolo
     *
     * @param string $term Término de búsqueda
     * @return array
     */
    public function searchByNameOrAcronym(string $term): array
    {
        return $this->model->like('name', $term)
                          ->orLike('acronym', $term)
                          ->orLike('sign', $term)
                          ->findAll();
    }

    /**
     * Obtener moneda por acrónimo
     *
     * @param string $acronym Acrónimo a buscar
     * @return Currency|null
     */
    public function findByAcronym(string $acronym): ?Currency
    {
        return $this->findBy('acronym', strtoupper($acronym));
    }

    /**
     * Obtener moneda por código ISO numérico
     *
     * @param int $isoNumeric Código ISO numérico
     * @return Currency|null
     */
    public function findByIsoNumeric(int $isoNumeric): ?Currency
    {
        return $this->findBy('iso_numeric', $isoNumeric);
    }

    /**
     * Obtener moneda por código interno
     *
     * @param int $internalCode Código interno
     * @return Currency|null
     */
    public function findByInternalCode(int $internalCode): ?Currency
    {
        return $this->findBy('internal_code', $internalCode);
    }

    /**
     * Obtener monedas recientes
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
     * Obtener monedas más antiguas
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
     * Obtener estadísticas de monedas
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
     * Obtener monedas con paginación ordenadas por fecha
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
     * Obtener monedas con filtros y paginación
     *
     * @param int $perPage
     * @param int $page
     * @param string|null $search Busca en name, acronym, sign
     * @param string|null $status 'active' | 'inactive'
     * @return array
     */
    public function getPaginatedFiltered(int $perPage = 10, int $page = 1, ?string $search = null, ?string $status = null): array
    {
        $builder = $this->model->orderBy('created_at', 'DESC');

        if ($search) {
            $builder->groupStart()
                    ->like('name', $search)
                    ->orLike('acronym', $search)
                    ->orLike('sign', $search)
                    ->groupEnd();
        }

        if ($status) {
            $builder->where('status', $status);
        }

        return $builder->paginate($perPage, 'default', $page);
    }

    /**
     * Activar una moneda
     *
     * @param int $id ID de la moneda
     * @return bool
     */
    public function activate(int $id): bool
    {
        return $this->update($id, ['status' => 'active']);
    }

    /**
     * Desactivar una moneda
     *
     * @param int $id ID de la moneda
     * @return bool
     */
    public function deactivate(int $id): bool
    {
        return $this->update($id, ['status' => 'inactive']);
    }

    /**
     * Cambiar estado de una moneda
     *
     * @param int $id ID de la moneda
     * @param string $status Nuevo estado
     * @return bool
     */
    public function changeStatus(int $id, string $status): bool
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return false;
        }

        return $this->update($id, ['status' => $status]);
    }

    /**
     * Verificar si existe una moneda con ese acrónimo
     *
     * @param string $acronym Acrónimo a verificar
     * @param int|null $excludeId ID a excluir de la búsqueda
     * @return bool
     */
    public function acronymExists(string $acronym, ?int $excludeId = null): bool
    {
        $query = $this->model->where('acronym', strtoupper($acronym));

        if ($excludeId !== null) {
            $query->where('id !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }

    /**
     * Verificar si existe una moneda con ese código ISO numérico
     *
     * @param int $isoNumeric Código ISO numérico
     * @param int|null $excludeId ID a excluir de la búsqueda
     * @return bool
     */
    public function isoNumericExists(int $isoNumeric, ?int $excludeId = null): bool
    {
        $query = $this->model->where('iso_numeric', $isoNumeric);

        if ($excludeId !== null) {
            $query->where('id !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }

    /**
     * Obtener todas las monedas ordenadas alfabéticamente
     *
     * @return array
     */
    public function getAllAlphabetical(): array
    {
        return $this->model->orderBy('name', 'ASC')->findAll();
    }

    /**
     * Obtener monedas activas ordenadas alfabéticamente
     *
     * @return array
     */
    public function getActiveAlphabetical(): array
    {
        return $this->model->where('status', 'active')
                          ->orderBy('name', 'ASC')
                          ->findAll();
    }

    /**
     * Restaurar una moneda eliminada lógicamente
     *
     * @param int $id ID de la moneda
     * @return bool
     */
    public function restore(int $id): bool
    {
        return $this->model->update($id, ['deleted_at' => null]);
    }
}
