<?php

namespace App\Exceptions;

use Exception;

/**
 * Excepción que se lanza cuando hay un error en la lógica de negocio
 */
class BusinessLogicException extends Exception
{
    /**
     * Constructor
     *
     * @param string $message Mensaje de error
     * @param int $code Código de error
     */
    public function __construct(string $message = 'Error en la lógica de negocio', int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
