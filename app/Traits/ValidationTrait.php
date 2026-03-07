<?php

namespace App\Traits;

use App\Exceptions\ValidationException;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * Trait para manejo de validaciones comunes
 */
trait ValidationTrait
{
    /**
     * Validar una solicitud HTTP
     *
     * @param IncomingRequest $request Solicitud a validar
     * @param array $rules Reglas de validación
     * @param array $messages Mensajes personalizados
     * @return bool
     * @throws ValidationException
     */
    public function validate(IncomingRequest $request, array $rules, array $messages = []): bool
    {
        $validator = \Config\Services::validation();
        $validator->setRules($rules);

        if (!empty($messages)) {
            $validator->setCustomErrors($messages);
        }

        if (!$validator->withRequest($request)->run()) {
            throw new ValidationException($validator->getErrors());
        }

        return true;
    }

    /**
     * Validar un campo específico
     *
     * @param string $field Nombre del campo
     * @param mixed $value Valor a validar
     * @param string $rule Regla de validación
     * @return bool
     */
    public function validateField(string $field, $value, string $rule): bool
    {
        $validator = \Config\Services::validation();
        
        return $validator->check($value, $rule);
    }

    /**
     * Obtener errores de validación
     *
     * @return array
     */
    public function getValidationErrors(): array
    {
        $validator = \Config\Services::validation();
        
        return $validator->getErrors();
    }

    /**
     * Comprobar si hay errores
     *
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->getValidationErrors());
    }
}
