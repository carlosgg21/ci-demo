<?php

/**
 * Locale Helper
 *
 * Funciones globales para resolucion de idioma en la aplicacion.
 * Se usa en conjunto con el trait HasTranslations.
 *
 * Cargar con: helper('locale');
 * O auto-cargar en app/Config/Autoload.php: $helpers = ['locale'];
 */

if (!function_exists('app_locale')) {
    /**
     * Obtener el locale activo de la aplicacion.
     * Orden de prioridad:
     *   1. Session (app_locale) - set por el usuario en la landing o admin
     *   2. Config default de CI4 (app.defaultLocale)
     *   3. Fallback 'es'
     */
    function app_locale(): string
    {
        $session = session();

        if ($session && $session->has('app_locale')) {
            return $session->get('app_locale');
        }

        $request = service('request');
        if ($request) {
            $locale = $request->getLocale();
            if ($locale) {
                return $locale;
            }
        }

        return config('App')->defaultLocale ?? 'es';
    }
}

if (!function_exists('default_locale')) {
    /**
     * Obtener el locale default de la compania actual.
     * Busca en la tabla locales el registro con is_default = 1.
     * Si no encuentra, usa el defaultLocale de CI4.
     */
    function default_locale(): string
    {
        static $cached = null;

        if ($cached !== null) {
            return $cached;
        }

        $session = session();
        if ($session && $session->has('default_locale')) {
            $cached = $session->get('default_locale');
            return $cached;
        }

        $cached = config('App')->defaultLocale ?? 'es';
        return $cached;
    }
}

if (!function_exists('available_locales')) {
    /**
     * Obtener los locales activos disponibles para la compania actual.
     * Retorna array de objetos Locale de la tabla locales.
     */
    function available_locales(?int $companyId = null): array
    {
        static $cached = null;

        if ($cached !== null && $companyId === null) {
            return $cached;
        }

        $localeModel = new \App\Models\LocaleModel();

        if ($companyId === null) {
            $session = session();
            $companyId = $session ? ($session->get('company_id') ?? 1) : 1;
        }

        $cached = $localeModel->findActiveByCompany($companyId);
        return $cached;
    }
}

if (!function_exists('secondary_locales')) {
    /**
     * Obtener solo los locales secundarios (no default).
     * Util para generar los tabs de traduccion en el admin.
     */
    function secondary_locales(?int $companyId = null): array
    {
        $all = available_locales($companyId);
        return array_filter($all, fn($locale) => !$locale->isDefault());
    }
}
