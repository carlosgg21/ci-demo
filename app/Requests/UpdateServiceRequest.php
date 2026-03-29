<?php

namespace App\Requests;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\ValidationException;

/**
 * Validaciones para actualizar un servicio
 */
class UpdateServiceRequest
{
    /**
     * Reglas de validación
     *
     * @var array
     */
    protected array $rules = [
        'service_type_id' => [
            'label' => 'Tipo de Servicio',
            'rules' => 'if_exist|permit_empty|numeric|is_not_unique[service_types.id]',
        ],
        'name' => [
            'label' => 'Nombre',
            'rules' => 'if_exist|required|min_length[2]|max_length[200]'
        ],
        'slug' => [
            'label' => 'Slug',
            'rules' => 'if_exist|required|min_length[3]|max_length[150]|is_unique[services.slug,id,{id}]|alpha_dash'
        ],
        'description' => [
            'label' => 'Descripción',
            'rules' => 'if_exist|permit_empty'
        ],
        'image' => [
            'label' => 'Imagen',
            'rules' => 'if_exist|permit_empty|valid_url_strict'
        ],
        'icon' => [
            'label' => 'Icono',
            'rules' => 'if_exist|permit_empty|max_length[100]'
        ],
        'sort_order' => [
            'label' => 'Orden',
            'rules' => 'if_exist|permit_empty|numeric'
        ],
        'is_active' => [
            'label' => 'Activo',
            'rules' => 'if_exist|permit_empty|in_list[0,1]'
        ],
    ];

    /**
     * Mensajes personalizados
     *
     * @var array
     */
    protected array $messages = [
        'name' => [
            'required'   => 'El nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede exceder los 200 caracteres',
        ],
        'slug' => [
            'required'   => 'El slug es obligatorio',
            'min_length' => 'El slug debe tener al menos 3 caracteres',
            'max_length' => 'El slug no puede exceder los 150 caracteres',
            'is_unique'  => 'Ya existe un servicio con este slug',
            'alpha_dash' => 'El slug solo puede contener letras, números, guiones y guiones bajos'
        ],
        'is_active' => [
            'in_list' => 'El estado debe ser 0 (inactivo) o 1 (activo)'
        ],
    ];

    /**
     * Validar los datos de la solicitud
     *
     * @param IncomingRequest $request
     * @param int $id ID del servicio a actualizar
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
     * @param int $id ID del servicio a actualizar
     * @return array
     * @throws ValidationException
     */
    public static function validated(IncomingRequest $request, int $id): array
    {
        self::validate($request, $id);

        $data = [];

        if ($request->getPost('service_type_id') !== null) {
            $data['service_type_id'] = $request->getPost('service_type_id') ?: null;
        }
        if ($request->getPost('name') !== null) {
            $data['name'] = $request->getPost('name');
        }
        if ($request->getPost('slug') !== null) {
            $data['slug'] = $request->getPost('slug');
        }
        if ($request->getPost('description') !== null) {
            $data['description'] = $request->getPost('description');
        }
        if ($request->getPost('image') !== null) {
            $data['image'] = $request->getPost('image');
        }
        if ($request->getPost('icon') !== null) {
            $data['icon'] = $request->getPost('icon');
        }
        if ($request->getPost('sort_order') !== null) {
            $data['sort_order'] = $request->getPost('sort_order');
        }
        if ($request->getPost('is_active') !== null) {
            $data['is_active'] = $request->getPost('is_active');
        }

        return $data;
    }
}
