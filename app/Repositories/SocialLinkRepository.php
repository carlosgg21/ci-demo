<?php

namespace App\Repositories;

use App\Models\SocialLinkModel;

/**
 * Repositorio para enlaces sociales
 */
class SocialLinkRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new SocialLinkModel();
    }

    public function findByEntity(string $type, int $id)
    {
        return $this->model->findByEntity($type, $id);
    }

    public function findByEntityAndPlatform(string $type, int $id, string $platform)
    {
        return $this->model->findByEntityAndPlatform($type, $id, $platform);
    }
}
