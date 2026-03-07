<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\ContactSubmission;

/**
 * Modelo ContactSubmission
 */
class ContactSubmissionModel extends Model
{
    protected $table            = 'contact_submissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ContactSubmission::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'company_id',
        'name',
        'email',
        'phone',
        'message',
        'source',
        'ip_address',
        'is_read',
        'created_by',
    ];

    // Solo created_at, no updated_at (los mensajes de contacto no se editan)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'company_id' => 'required|numeric',
        'name'       => 'required|string|max_length[150]',
        'email'      => 'required|valid_email|max_length[150]',
        'message'    => 'required|string',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Obtener mensajes no leídos de una compañía
     */
    public function findUnreadByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener mensajes leídos de una compañía
     */
    public function findReadByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->where('is_read', 1)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtener todos los mensajes de una compañía
     */
    public function findByCompany(int $companyId)
    {
        return $this->where('company_id', $companyId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Contar mensajes no leídos
     */
    public function countUnreadByCompany(int $companyId): int
    {
        return $this->where('company_id', $companyId)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    /**
     * Marcar como leído
     */
    public function markAsRead(int $id): bool
    {
        return $this->update($id, ['is_read' => 1]);
    }

    /**
     * Marcar múltiples como leídos
     */
    public function markMultipleAsRead(array $ids): bool
    {
        return $this->whereIn('id', $ids)->set(['is_read' => 1])->update();
    }
}
