<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * Esta es la configuración principal de rutas.
 * Las rutas específicas están organizadas en:
 * - Routes/Web.php  (rutas web)
 * - Routes/Api.php  (rutas API)
 */

// Cargar rutas web
require APPPATH . 'Config/Routes/Web.php';

// Cargar rutas API
require APPPATH . 'Config/Routes/Api.php';
