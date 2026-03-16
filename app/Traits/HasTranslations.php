<?php

namespace App\Traits;

/**
 * Trait HasTranslations
 *
 * Proporciona soporte de traduccion multi-idioma para entities de CodeIgniter 4.
 * Los campos del idioma default se almacenan en columnas regulares de la tabla.
 * Las traducciones a otros idiomas se almacenan en una columna JSON `translations`.
 *
 * Estructura esperada del JSON `translations`:
 * {
 *     "en": { "name": "Web Development", "description": "We build..." },
 *     "fr": { "name": "Developpement Web", "description": "Nous construisons..." }
 * }
 *
 * Uso: La entity debe definir la propiedad $translatable con los campos traducibles.
 *
 *   class Service extends Entity {
 *       use HasTranslations;
 *       protected array $translatable = ['name', 'description'];
 *   }
 */
trait HasTranslations
{
    /**
     * Obtener el valor de un campo resuelto al locale indicado.
     * Si el locale es el default, retorna la columna base.
     * Si no, busca en el JSON translations con fallback a la columna base.
     */
    public function t(string $field, ?string $locale = null): ?string
    {
        if (!in_array($field, $this->getTranslatableFields())) {
            return $this->{$field} ?? null;
        }

        $locale = $locale ?? $this->resolveLocale();
        $default = $this->resolveDefaultLocale();

        if ($locale === $default) {
            return $this->{$field} ?? null;
        }

        return $this->getTranslation($locale, $field) ?? $this->{$field} ?? null;
    }

    /**
     * Obtener la traduccion de un campo para un locale especifico.
     * Retorna null si no existe (sin fallback).
     */
    public function getTranslation(string $locale, string $field): ?string
    {
        $translations = $this->getTranslationsArray();
        return $translations[$locale][$field] ?? null;
    }

    /**
     * Establecer la traduccion de un campo para un locale especifico.
     */
    public function setTranslation(string $locale, string $field, ?string $value): static
    {
        $translations = $this->getTranslationsArray();
        $translations[$locale][$field] = $value;
        $this->translations = $translations;
        return $this;
    }

    /**
     * Establecer todas las traducciones de un locale de una vez.
     * $values es un array asociativo: ['name' => 'Web Dev', 'description' => '...']
     */
    public function setTranslationsForLocale(string $locale, array $values): static
    {
        $translations = $this->getTranslationsArray();

        foreach ($values as $field => $value) {
            if (in_array($field, $this->getTranslatableFields())) {
                $translations[$locale][$field] = $value;
            }
        }

        $this->translations = $translations;
        return $this;
    }

    /**
     * Obtener todas las traducciones de un locale especifico.
     * Retorna array asociativo con los campos traducibles.
     */
    public function getTranslationsForLocale(string $locale): array
    {
        $translations = $this->getTranslationsArray();
        $result = [];

        foreach ($this->getTranslatableFields() as $field) {
            $result[$field] = $translations[$locale][$field] ?? '';
        }

        return $result;
    }

    /**
     * Verificar si existe traduccion para un locale y campo especifico.
     */
    public function hasTranslation(string $locale, ?string $field = null): bool
    {
        $translations = $this->getTranslationsArray();

        if (!isset($translations[$locale])) {
            return false;
        }

        if ($field !== null) {
            return isset($translations[$locale][$field])
                && $translations[$locale][$field] !== ''
                && $translations[$locale][$field] !== null;
        }

        // Si no se especifica campo, verifica que al menos uno tenga valor
        foreach ($this->getTranslatableFields() as $f) {
            if (!empty($translations[$locale][$f])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtener los locales que tienen al menos una traduccion.
     * Retorna array de locale codes: ['en', 'fr']
     */
    public function getTranslatedLocales(): array
    {
        $translations = $this->getTranslationsArray();
        $locales = [];

        foreach (array_keys($translations) as $locale) {
            if ($this->hasTranslation($locale)) {
                $locales[] = $locale;
            }
        }

        return $locales;
    }

    /**
     * Obtener el porcentaje de completitud de traducciones para un locale.
     * Util para mostrar indicadores en el admin.
     */
    public function getTranslationCompleteness(string $locale): int
    {
        $fields = $this->getTranslatableFields();
        $total = count($fields);

        if ($total === 0) {
            return 100;
        }

        $filled = 0;
        $translations = $this->getTranslationsArray();

        foreach ($fields as $field) {
            if (!empty($translations[$locale][$field])) {
                $filled++;
            }
        }

        return (int) round(($filled / $total) * 100);
    }

    /**
     * Getter llamado por el Entity magic __get('translations').
     * Evita que el JsonCast falle con strings vacios o valores no-array.
     */
    public function getTranslations(): array
    {
        $raw = $this->attributes['translations'] ?? null;

        if (empty($raw)) {
            return [];
        }

        $decoded = is_string($raw) ? json_decode($raw, true) : $raw;

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Obtener el array completo de traducciones decodificado.
     */
    public function getTranslationsArray(): array
    {
        $value = $this->translations;

        if ($value === null || $value === '' || $value === false) {
            return [];
        }

        if (is_array($value)) {
            return $value;
        }

        if (is_object($value)) {
            return json_decode(json_encode($value), true) ?? [];
        }

        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return [];
    }

    /**
     * Obtener la lista de campos traducibles.
     */
    public function getTranslatableFields(): array
    {
        return $this->translatable ?? [];
    }

    /**
     * Construir el array de translations listo para guardar en BD.
     * Recibe el input del formulario y extrae las traducciones.
     *
     * Espera formato: translations[en][name] = "value"
     * O un array ya armado: ['en' => ['name' => 'value']]
     */
    public static function buildTranslationsFromInput(array $input, array $translatableFields): ?string
    {
        if (empty($input)) {
            return null;
        }

        $clean = [];
        foreach ($input as $locale => $fields) {
            if (!is_array($fields)) {
                continue;
            }

            $hasContent = false;
            foreach ($fields as $field => $value) {
                if (in_array($field, $translatableFields)) {
                    $clean[$locale][$field] = $value;
                    if ($value !== '' && $value !== null) {
                        $hasContent = true;
                    }
                }
            }

            if (!$hasContent) {
                unset($clean[$locale]);
            }
        }

        return !empty($clean) ? json_encode($clean, JSON_UNESCAPED_UNICODE) : null;
    }

    /**
     * Resolver el locale activo.
     * Orden: parametro > session > helper > 'es'
     */
    protected function resolveLocale(): string
    {
        if (function_exists('app_locale')) {
            return app_locale();
        }

        $session = session();
        if ($session && $session->has('app_locale')) {
            return $session->get('app_locale');
        }

        return 'es';
    }

    /**
     * Resolver el locale default de la aplicacion.
     */
    protected function resolveDefaultLocale(): string
    {
        if (function_exists('default_locale')) {
            return default_locale();
        }

        return 'es';
    }
}
