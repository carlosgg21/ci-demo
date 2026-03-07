<?php

namespace App\Requests;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\ValidationException;

/**
 * Validaciones para crear un nuevo servicio
 */
class StoreServiceRequest
{
    /**
     * Reglas de validación
     *
     * @var array
     */
    protected array $rules = [
        'company_id' => [
            'label' => 'Empresa',
            'rules' => 'required|numeric|is_not_unique[companies.id]'
        ],
        'slug' => [
            'label' => 'Slug',
            'rules' => 'required|min_length[3]|max_length[150]|is_unique[services.slug]|alpha_dash'
        ],
        'image' => [
            'label' => 'Imagen',
            'rules' => 'permit_empty|valid_url_strict'
        ],
        'icon' => [
            'label' => 'Icono',
            'rules' => 'permit_empty|string|max_length[100]'
        ],
        'sort_order' => [
            'label' => 'Orden',
            'rules' => 'permit_empty|numeric'
        ],
        'is_active' => [
            'label' => 'Activo',
            'rules' => 'permit_empty|in_list[0,1]'
        ],
    ];

    /**
     * Mensajes personalizados
     *
     * @var array
     */
    protected array $messages = [
        'company_id' => [
            'required'      => 'La empresa es obligatoria',
            'numeric'       => 'El ID de empresa debe ser numérico',
            'is_not_unique' => 'La empresa no existe'
        ],
        'slug' => [
            'required'    => 'El slug es obligatorio',
            'min_length'  => 'El slug debe tener al menos 3 caracteres',
            'max_length'  => 'El slug no puede exceder los 150 caracteres',
            'is_unique'   => 'Ya existe un servicio con este slug',
            'alpha_dash'  => 'El slug solo puede contener letras, números, guiones y guiones bajos'
        ],
        'is_active' => [
            'in_list' => 'El estado debe ser 0 (inactivo) o 1 (activo)'
        ],
    ];

    /**
     * Validar los datos de la solicitud
     *
     * @param IncomingRequest $request
     * @return bool
     * @throws ValidationException
     */
    public static function validate(IncomingRequest $request): bool
    {
        $instance = new self();
        $validator = \Config\Services::validation();
        $validator->setRules($instance->rules);
        $validator->setCustomErrors($instance->messages);

        if (!$validator->withRequest($request)->run()) {
            throw new ValidationException($validator->getErrors());
        }

        return true;
    }

    /**
     * Obtener datos validados
     *
     * @param IncomingRequest $request
     * @return array
     * @throws ValidationException
     */
    public static function validated(IncomingRequest $request): array
    {
        self::validate($request);

        return [
            'company_id'  => $request->getPost('company_id'),
            'slug'        => $request->getPost('slug'),
            'image'       => $request->getPost('image'),
            'icon'        => $request->getPost('icon'),
            'sort_order'  => $request->getPost('sort_order', 0),
            'is_active'   => $request->getPost('is_active', 1),
        ];
    }
}
