<?php

namespace App\Requests;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\ValidationException;

class UpdateServiceTypeRequest
{
    protected array $rules = [
        'denomination' => [
            'label' => 'Denominación',
            'rules' => 'if_exist|required|min_length[2]|max_length[150]|is_unique[service_types.denomination,id,{id}]',
        ],
        'description' => [
            'label' => 'Descripción',
            'rules' => 'if_exist|permit_empty|max_length[500]',
        ],
        'is_active' => [
            'label' => 'Activo',
            'rules' => 'if_exist|permit_empty|in_list[0,1]',
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

    public static function validate(IncomingRequest $request, int $id): bool
    {
        $instance = new self();

        $rules = $instance->rules;
        array_walk_recursive($rules, function (&$value) use ($id) {
            $value = str_replace('{id}', $id, $value);
        });

        $validator = \Config\Services::validation();
        $validator->setRules($rules, $instance->messages);

        if (!$validator->withRequest($request)->run()) {
            throw new ValidationException($validator->getErrors());
        }

        return true;
    }

    public static function validated(IncomingRequest $request, int $id): array
    {
        self::validate($request, $id);

        $data = [];

        if ($request->getPost('denomination') !== null) {
            $data['denomination'] = $request->getPost('denomination');
        }
        if ($request->getPost('description') !== null) {
            $data['description'] = $request->getPost('description');
        }
        if ($request->getPost('is_active') !== null) {
            $data['is_active'] = $request->getPost('is_active');
        }

        return $data;
    }
}
