<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\User;

/**
 * Modelo User
 */
class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = User::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[super_admin,admin,editor]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Buscar usuario activo por email
     */
    public function findActiveByEmail(string $email)
    {
        return $this->where('email', $email)
                    ->where('is_active', 1)
                    ->first();
    }

    /**
     * Buscar usuario activo por username
     */
    public function findActiveByUsername(string $username)
    {
        return $this->where('username', $username)
                    ->where('is_active', 1)
                    ->first();
    }

    /**
     * Obtener usuarios activos
     */
    public function findAllActive()
    {
        return $this->where('is_active', 1)->findAll();
    }
}
