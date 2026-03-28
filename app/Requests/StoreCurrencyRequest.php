<?php

namespace App\Requests;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\ValidationException;

/**
 * Validaciones para crear una nueva moneda
 */
class StoreCurrencyRequest
{
    /**
     * Reglas de validación
     *
     * @var array
     */
    protected array $rules = [
        'acronym' => [
            'label' => 'Acrónimo',
            'rules' => 'required|min_length[2]|max_length[3]|is_unique[currencies.acronym]'
        ],
        'name' => [
            'label' => 'Nombre',
            'rules' => 'required|min_length[3]|max_length[50]'
        ],
        'sign' => [
            'label' => 'Símbolo',
            'rules' => 'permit_empty|max_length[5]'
        ],
        'iso_numeric' => [
            'label' => 'Código ISO numérico',
            'rules' => 'permit_empty|integer|exact_length[3]|is_unique[currencies.iso_numeric]'
        ],
        'internal_code' => [
            'label' => 'Código interno',
            'rules' => 'permit_empty|integer'
        ],
        'flag' => [
            'label' => 'Bandera',
            'rules' => 'permit_empty|max_length[50]'
        ],
        'status' => [
            'label' => 'Estado',
            'rules' => 'required|in_list[active,inactive]'
        ],
    ];

    /**
     * Mensajes personalizados
     *
     * @var array
     */
    protected array $messages = [
        'acronym' => [
            'required'   => 'El acrónimo es obligatorio',
            'min_length' => 'El acrónimo debe tener al menos 2 caracteres',
            'max_length' => 'El acrónimo debe tener máximo 3 caracteres',
            'is_unique'  => 'Este acrónimo ya está registrado'
        ],
        'name' => [
            'required'   => 'El nombre de la moneda es obligatorio',
            'min_length' => 'El nombre debe tener al menos 3 caracteres',
            'max_length' => 'El nombre debe tener máximo 50 caracteres'
        ],
        'status' => [
            'required' => 'El estado es obligatorio',
            'in_list'  => 'El estado debe ser active o inactive'
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
        $validator->setRules($instance->rules, $instance->messages);

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
            'acronym'       => $request->getPost('acronym'),
            'name'          => $request->getPost('name'),
            'sign'          => $request->getPost('sign'),
            'iso_numeric'   => $request->getPost('iso_numeric'),
            'internal_code' => $request->getPost('internal_code'),
            'flag'          => $request->getPost('flag'),
            'status'        => $request->getPost('status') ?? 'active',
        ];
    }
}
