<?php

namespace App\Requests;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\ValidationException;

/**
 * Validaciones para actualizar una moneda
 */
class UpdateCurrencyRequest
{
    /**
     * Reglas de validación
     *
     * @var array
     */
    protected array $rules = [
        'acronym' => [
            'label' => 'Acrónimo',
            'rules' => 'if_exist|required|min_length[2]|max_length[3]|is_unique[currencies.acronym,id,{id}]'
        ],
        'name' => [
            'label' => 'Nombre',
            'rules' => 'if_exist|required|min_length[3]|max_length[50]'
        ],
        'sign' => [
            'label' => 'Símbolo',
            'rules' => 'if_exist|permit_empty|max_length[5]'
        ],
        'iso_numeric' => [
            'label' => 'Código ISO numérico',
            'rules' => 'if_exist|permit_empty|integer|exact_length[3]|is_unique[currencies.iso_numeric,id,{id}]'
        ],
        'internal_code' => [
            'label' => 'Código interno',
            'rules' => 'if_exist|permit_empty|integer'
        ],
        'flag' => [
            'label' => 'Bandera',
            'rules' => 'if_exist|permit_empty|max_length[50]'
        ],
        'status' => [
            'label' => 'Estado',
            'rules' => 'if_exist|required|in_list[active,inactive]'
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
     * @param int $id ID de la moneda a actualizar
     * @return bool
     * @throws ValidationException
     */
    public static function validate(IncomingRequest $request, int $id): bool
    {
        $instance = new self();
        
        // Reemplazar {id} en las reglas
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

    /**
     * Obtener datos validados
     *
     * @param IncomingRequest $request
     * @param int $id ID de la moneda a actualizar
     * @return array
     * @throws ValidationException
     */
    public static function validated(IncomingRequest $request, int $id): array
    {
        self::validate($request, $id);

        $data = [];
        
        if ($request->getPost('acronym') !== null) {
            $data['acronym'] = $request->getPost('acronym');
        }
        if ($request->getPost('name') !== null) {
            $data['name'] = $request->getPost('name');
        }
        if ($request->getPost('sign') !== null) {
            $data['sign'] = $request->getPost('sign');
        }
        if ($request->getPost('iso_numeric') !== null) {
            $data['iso_numeric'] = $request->getPost('iso_numeric');
        }
        if ($request->getPost('internal_code') !== null) {
            $data['internal_code'] = $request->getPost('internal_code');
        }
        if ($request->getPost('flag') !== null) {
            $data['flag'] = $request->getPost('flag');
        }
        if ($request->getPost('status') !== null) {
            $data['status'] = $request->getPost('status');
        }

        return $data;
    }
}
