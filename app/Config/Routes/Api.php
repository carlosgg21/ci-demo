<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * Rutas API - Controladores API para endpoints REST
 */

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Versión 1 de la API
    $routes->group('v1', function($routes) {
        // Rutas RESTful para servicios
        $routes->resource('services', ['controller' => 'ServiceController']);
        $routes->resource('currencies', ['controller' => 'CurrencyController']);
        $routes->resource('users', ['controller' => 'UserController']);
        $routes->resource('companies', ['controller' => 'CompanyController']);
        $routes->resource('locales', ['controller' => 'LocaleController']);
        $routes->resource('settings', ['controller' => 'SettingController']);
        $routes->resource('social-links', ['controller' => 'SocialLinkController']);
        $routes->resource('section-types', ['controller' => 'SectionTypeController']);
        $routes->resource('content-sections', ['controller' => 'ContentSectionController']);
        $routes->resource('team-members', ['controller' => 'TeamMemberController']);
        $routes->resource('testimonials', ['controller' => 'TestimonialController']);
        $routes->resource('media', ['controller' => 'MediaController']);
        $routes->resource('contact-submissions', ['controller' => 'ContactSubmissionController']);
    });

    // Versión 2 de la API (futura)
    // $routes->group('v2', function($routes) {
    //     // Rutas versión 2 aquí
    // });
});
