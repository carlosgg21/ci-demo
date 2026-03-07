<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Company;

/**
 * Modelo Company
 */
class CompanyModel extends Model
{
    protected $table            = 'companies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Company::class;
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'name',
        'slug',
        'legal_name',
        'tax_id',
        'email',
        'phone',
        'mobile',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'logo',
        'favicon',
        'website',
        'created_by',
        'updated_by',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|string|max_length[150]',
        'slug' => 'required|alpha_dash|is_unique[companies.slug]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Buscar por slug
     */
    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * Obtener con locales
     */
    public function withLocales(int $id)
    {
        $company = $this->find($id);
        if ($company) {
            $localeModel = new LocaleModel();
            $company->locales = $localeModel->where('company_id', $id)->findAll();
        }
        return $company;
    }
}
