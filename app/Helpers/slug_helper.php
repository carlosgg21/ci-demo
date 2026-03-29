<?php

if (!function_exists('generate_slug')) {
    /**
     * Genera un slug a partir de un string.
     *
     * @param string $value Texto fuente (ej. "Consultoría Técnica")
     * @return string Slug generado (ej. "consultoria-tecnica")
     */
    function generate_slug(string $value): string
    {
        helper('url');

        return url_title($value, '-', true);
    }
}
