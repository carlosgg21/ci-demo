<?php

namespace App\Responses;

/**
 * Clase para estandarizar respuestas JSON de la API
 */
class ApiResponse
{
    /**
     * Respuesta exitosa
     *
     * @param mixed $data Datos a devolver
     * @param int $code Código HTTP
     * @param string $message Mensaje personalizado
     * @return array
     */
    public static function success($data = null, int $code = 200, string $message = 'Éxito'): array
    {
        return [
            'success' => true,
            'status'  => $code,
            'message' => $message,
            'data'    => $data
        ];
    }

    /**
     * Respuesta de error
     *
     * @param string $message Mensaje de error
     * @param int $code Código HTTP
     * @param mixed $errors Errores adicionales
     * @return array
     */
    public static function error(string $message = 'Error', int $code = 400, $errors = null): array
    {
        $response = [
            'success' => false,
            'status'  => $code,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return $response;
    }

    /**
     * Respuesta de validación fallida
     *
     * @param array $errors Errores de validación por campo
     * @param string $message Mensaje personalizado
     * @return array
     */
    public static function validationFailed(array $errors, string $message = 'Validation failed'): array
    {
        return [
            'success' => false,
            'status'  => 422,
            'message' => $message,
            'errors'  => $errors
        ];
    }

    /**
     * Respuesta no encontrado
     *
     * @param string $message Mensaje personalizado
     * @return array
     */
    public static function notFound(string $message = 'Recurso no encontrado'): array
    {
        return self::error($message, 404);
    }

    /**
     * Respuesta no autorizado
     *
     * @param string $message Mensaje personalizado
     * @return array
     */
    public static function unauthorized(string $message = 'No autorizado'): array
    {
        return self::error($message, 401);
    }

    /**
     * Respuesta desde listado paginado
     *
     * @param array $data Datos del listado
     * @param object $pager Objeto pager de CodeIgniter
     * @return array
     */
    public static function paginated(array $data, $pager): array
    {
        return self::success([
            'items'       => $data,
            'total'       => $pager->getTotal(),
            'perPage'     => $pager->getPerPage(),
            'currentPage' => $pager->getCurrentPage(),
            'lastPage'    => $pager->getPageCount(),
            'hasNext'     => $pager->hasNext(),
            'hasPrevious' => $pager->hasPrevious(),
        ], 200, 'Listado obtenido correctamente');
    }
}
