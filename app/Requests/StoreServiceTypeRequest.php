<?php

namespace App\Requests;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\ValidationException;

class StoreServiceTypeRequest
{
    protected array $rules = [
        'denomination' => [
            'label' => 'Denominación',
            'rules' => 'required|min_length[2]|max_length[150]|is_unique[service_types.denomination]',
        ],
        'description' => [
            'label' => 'Descripción',
            'rules' => 'permit_empty|max_length[500]',
        ],
        'is_active' => [
            'label' => 'Activo',
            'rules' => 'permit_empty|in_list[0,1]',
        ],
    ];

    protected array $messages = [
        'denomination' => [
            'required'   => 'La denominación es obligatoria',
            'min_length' => 'La denominación debe tener al menos 2 caracteres',
            'max_length' => 'La denominación no puede exceder los 150 caracteres',
            'is_unique'  => 'Ya existe un tipo de servicio con esta denominación',
        ],
        'is_active' => [
            'in_list' => 'El estado debe ser 0 (inactivo) o 1 (activo)',
        ],
    ];

    public static function validate(IncomingRequest $request): bool
    {
        $instance  = new self();
        $validator = \Config\Services::validation();
        $validator->setRules($instance->rules, $instance->messages);

        if (!$validator->withRequest($request)->run()) {
            throw new ValidationException($validator->getErrors());
        }

        return true;
    }

    public static function validated(IncomingRequest $request): array
    {
        self::validate($request);

        return [
            'denomination' => $request->getPost('denomination'),
            'description'  => $request->getPost('description'),
            'is_active'    => $request->getPost('is_active') ?? 1,
        ];
    }
}
