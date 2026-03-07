<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * Rutas Web - Controladores web para vistas
 */

// Home
$routes->get('/', 'Home::index');

// CRUD web resources para Landing CMS
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
