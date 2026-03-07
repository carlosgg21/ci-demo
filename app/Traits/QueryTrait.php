<?php

namespace App\Traits;

/**
 * Trait para métodos de consulta comunes en repositorios
 */
trait QueryTrait
{
    /**
     * Obtener todos los registros
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->model->findAll();
    }

    /**
     * Obtener un registro por ID
     *
     * @param int $id ID del registro
     * @return object|null
     */
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Obtener registros paginados
     *
     * @param int $perPage Registros por página
     * @param int $page Página actual
     * @return array
     */
    public function getPaginated(int $perPage = 10, int $page = 1): array
    {
        return $this->model->paginate($perPage, 'default', $page);
    }

    /**
     * Contar total de registros
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->countAllResults();
    }

    /**
     * Contar registros con condición
     *
     * @param string $field Campo a evaluar
     * @param mixed $value Valor a comparar
     * @return int
     */
    public function countWhere(string $field, $value): int
    {
        return $this->model->where($field, $value)->countAllResults();
    }

    /**
     * Buscar registros con LIKE
     *
     * @param string $field Campo para buscar
     * @param string $term Término de búsqueda
     * @return array
     */
    public function search(string $field, string $term): array
    {
        return $this->model->like($field, $term)->findAll();
    }

    /**
     * Buscar un registro por un campo específico
     *
     * @param string $field Campo para buscar
     * @param mixed $value Valor a buscar
     * @return object|null
     */
    public function findBy(string $field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * Buscar múltiples registros por un campo
     *
     * @param string $field Campo para buscar
     * @param mixed $value Valor a buscar
     * @return array
     */
    public function findAllBy(string $field, $value): array
    {
        return $this->model->where($field, $value)->findAll();
    }

    /**
     * Obtener el objeto pager para paginación
     *
     * @return object
     */
    public function getPager()
    {
        return $this->model->pager;
    }
}
