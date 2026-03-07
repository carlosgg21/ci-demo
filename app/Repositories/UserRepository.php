<?php

namespace App\Repositories;

use App\Models\UserModel;

/**
 * Repositorio para usuarios
 */
class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * Buscar usuario activo por email
     */
    public function findActiveByEmail(string $email)
    {
        return $this->model->findActiveByEmail($email);
    }

    /**
     * Buscar usuario activo por username
     */
    public function findActiveByUsername(string $username)
    {
        return $this->model->findActiveByUsername($username);
    }
}
