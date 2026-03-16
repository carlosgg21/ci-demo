<?php

namespace App\DataCaster\Cast;

use CodeIgniter\DataCaster\Cast\BaseCast;

/**
 * Cast JSON seguro: siempre retorna array, nunca falla con strings vacios o nulos.
 */
class SafeJsonCast extends BaseCast
{
    public static function get(
        mixed $value,
        array $params = [],
        ?object $helper = null,
    ): array {
        if ($value === null || $value === '' || $value === false) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_object($value)) {
            return (array) $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    public static function set(
        mixed $value,
        array $params = [],
        ?object $helper = null,
    ): string {
        if ($value === null || $value === '') {
            return '{}';
        }

        if (is_string($value)) {
            return $value;
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE) ?: '{}';
    }
}
