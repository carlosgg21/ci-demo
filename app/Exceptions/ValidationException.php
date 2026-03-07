<?php

namespace App\Exceptions;

use Exception;

/**
 * Excepción que se lanza cuando la validación falla
 */
class ValidationException extends Exception
{
    /**
     * Errores de validación
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * Constructor
     *
     * @param array $errors Errores de validación
     * @param string $message Mensaje personalizado
     * @param int $code Código de error
     */
    public function __construct(array $errors = [], string $message = 'Validación fallida', int $code = 422)
    {
        $this->errors = $errors;
        parent::__construct($message, $code);
    }

    /**
     * Obtener los errores de validación
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
