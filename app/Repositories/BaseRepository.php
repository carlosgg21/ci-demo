<?php

namespace App\Repositories;

use App\Traits\QueryTrait;
use CodeIgniter\Model;

/**
 * Clase base para todos los repositorios
 * Proporciona métodos comunes de acceso a datos
 */
abstract class BaseRepository
{
    use QueryTrait;

    /**
     * Instancia del modelo
     *
     * @var Model
     */
    protected Model $model;

    /**
     * Constructor
     * Debe ser sobrescrito en los repositorios hijos
     */
    abstract public function __construct();

    /**
     * Guardar un registro (crear o actualizar)
     *
     * @param object|array $data Datos a guardar
     * @return bool
     */
    public function save($data): bool
    {
        return $this->model->save($data);
    }

    /**
     * Insertar un nuevo registro
     *
     * @param array $data Datos a insertar
     * @return int|string ID del registro insertado
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Actualizar un registro por ID
     *
     * @param int $id ID del registro
     * @param array $data Datos a actualizar
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    /**
     * Eliminar un registro por ID
     *
     * @param int $id ID del registro a eliminar
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }

    /**
     * Eliminar múltiples registros
     *
     * @param array $ids IDs de registros a eliminar
     * @return bool
     */
    public function deleteMultiple(array $ids): bool
    {
        return $this->model->whereIn($this->model->primaryKey, $ids)->delete();
    }

    /**
     * Obtener el modelo
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Verificar si un registro existe
     *
     * @param int $id ID del registro
     * @return bool
     */
    public function exists(int $id): bool
    {
        return $this->getById($id) !== null;
    }

    /**
     * Limpiar la consulta del modelo
     *
     * @return $this
     */
    public function reset()
    {
        $this->model->reset();
        return $this;
    }

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
     * Obtener registros paginados ordenados por fecha de creación
     *
     * @param int $perPage
     * @param int $page
     * @return array
     */
    public function getPaginatedRecent(int $perPage = 10, int $page = 1): array
    {
        return $this->model->orderBy('created_at', 'DESC')
                          ->paginate($perPage, 'default', $page);
    }

    /**
     * Acceder al pager del último query paginado
     *
     * @return \CodeIgniter\Pager\Pager|null
     */
    public function getPager()
    {
        return $this->model->pager;
    }

    /**
     * Contar todos los registros
     *
     * @return int
     */
    public function count(): int
    {
        return $this->model->countAll();
    }

    /**
     * Contar registros donde campo = valor
     *
     * @param string $field
     * @param mixed $value
     * @return int
     */
    public function countWhere(string $field, $value): int
    {
        return $this->model->where($field, $value)->countAllResults();
    }
}

