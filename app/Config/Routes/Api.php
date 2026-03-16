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
        $routes->patch('services/(:num)/toggle-status', 'ServiceController::toggleStatus/$1');
        $routes->patch('services/(:num)/translations', 'ServiceController::updateTranslations/$1');
        $routes->resource('services', ['controller' => 'ServiceController']);
        $routes->patch('currencies/(:num)/toggle-status', 'CurrencyController::toggleStatus/$1');
        $routes->resource('currencies', ['controller' => 'CurrencyController']);
        $routes->resource('users', ['controller' => 'UserController']);
        $routes->resource('companies', ['controller' => 'CompanyController']);
        $routes->patch('locales/(:num)/toggle-status', 'LocaleController::toggleStatus/$1');
        $routes->resource('locales', ['controller' => 'LocaleController']);
        $routes->resource('settings', ['controller' => 'SettingController']);
        $routes->resource('social-links', ['controller' => 'SocialLinkController']);
        $routes->resource('section-types', ['controller' => 'SectionTypeController']);
        $routes->resource('content-sections', ['controller' => 'ContentSectionController']);
        $routes->patch('team-members/(:num)/toggle-status', 'TeamMemberController::toggleStatus/$1');
        $routes->patch('team-members/(:num)/translations', 'TeamMemberController::updateTranslations/$1');
        $routes->resource('team-members', ['controller' => 'TeamMemberController']);
        $routes->patch('testimonials/(:num)/toggle-status', 'TestimonialController::toggleStatus/$1');
        $routes->patch('testimonials/(:num)/translations', 'TestimonialController::updateTranslations/$1');
        $routes->resource('testimonials', ['controller' => 'TestimonialController']);
        $routes->resource('media', ['controller' => 'MediaController']);
        $routes->resource('contact-submissions', ['controller' => 'ContactSubmissionController']);
    });

    // Versión 2 de la API (futura)
    // $routes->group('v2', function($routes) {
    //     // Rutas versión 2 aquí
    // });
});
