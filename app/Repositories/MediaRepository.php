<?php

namespace App\Repositories;

use App\Models\MediaModel;

/**
 * Repositorio para medios
 */
class MediaRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new MediaModel();
    }

    public function findByEntity(string $type, int $id)
    {
        return $this->model->findByEntity($type, $id);
    }
}
