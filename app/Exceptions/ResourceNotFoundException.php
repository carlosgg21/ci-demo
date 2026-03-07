<?php

namespace App\Exceptions;

use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Excepción que se lanza cuando un recurso no es encontrado
 */
class ResourceNotFoundException extends PageNotFoundException
{
    /**
     * Constructor
     *
     * @param string $message Mensaje de error
     * @param int $code Código de error
     */
    public function __construct(string $message = 'Recurso no encontrado', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
