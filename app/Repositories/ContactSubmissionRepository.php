<?php

namespace App\Repositories;

use App\Models\ContactSubmissionModel;

/**
 * Repositorio para envíos de contacto
 */
class ContactSubmissionRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new ContactSubmissionModel();
    }

    public function findUnreadByCompany(int $companyId)
    {
        return $this->model->findUnreadByCompany($companyId);
    }

    public function markAsRead(int $id): bool
    {
        return $this->model->markAsRead($id);
    }

    public function countUnreadByCompany(int $companyId): int
    {
        return $this->model->countUnreadByCompany($companyId);
    }
}
