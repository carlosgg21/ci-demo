<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\TeamMember;

/**
 * Modelo TeamMember
 */
class TeamMemberModel extends Model
{
    protected $table            = 'team_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = TeamMember::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'name',
        'position',
        'bio',
        'translations',
        'email',
        'phone',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected array $castHandlers = [
        'safe-json' => \App\DataCaster\Cast\SafeJsonCast::class,
    ];

    protected array $casts = [
        'translations' => 'safe-json',
    ];

    protected $validationRules = [
        'company_id' => 'required|numeric',
        'name'       => 'required|string|max_length[150]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener miembros activos de una compañía
     */
    public function findActiveByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener todos los miembros de una compañía
     */
    public function findByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('sort_order', 'ASC')
                    ->findAll();
    }
}
