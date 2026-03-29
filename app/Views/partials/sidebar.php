<?php
// Helpers para estado activo
$isActive = function(string $path) {
    return str_contains(current_url(), $path) ? 'active' : '';
};
$isOpen = function(array $paths) {
    foreach ($paths as $path) {
        if (str_contains(current_url(), $path)) return true;
    }
    return false;
};
?>

<aside class="app-sidebar">
    <div class="sidebar-brand">
        <a href="<?= base_url('/') ?>" class="brand-link">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="CLIQ" class="brand-logo">
            <img src="<?= base_url('assets/img/logo_mini.png') ?>" alt="CLIQ" class="brand-logo-mini">
        </a>
    </div>

    <div class="sidebar-wrapper">
        <ul class="sidebar-menu">
            <li class="menu-header">Principal</li>

            <li class="menu-item">
                <a href="<?= base_url('dashboard') ?>" class="menu-link <?= $isActive('dashboard') ?>">
                    <i class="bi bi-grid-1x2-fill menu-icon"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li class="menu-item has-submenu">
                <a href="#" class="menu-link" data-submenu="menuCRM"
                   aria-expanded="<?= $isOpen(['clientes', 'leads']) ? 'true' : 'false' ?>">
                    <i class="bi bi-people-fill menu-icon"></i>
                    <span class="menu-text">CRM</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <ul id="menuCRM" class="submenu <?= $isOpen(['clientes', 'leads']) ? 'show' : '' ?>">
                    <li class="flyout-header">CRM</li>
                    <li class="menu-item">
                        <a href="<?= base_url('clientes') ?>" class="menu-link <?= $isActive('clientes') ?>">
                            <span class="menu-text">Clientes</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('leads') ?>" class="menu-link <?= $isActive('leads') ?>">
                            <span class="menu-text">Leads</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="<?= base_url('cotizaciones') ?>" class="menu-link <?= $isActive('cotizaciones') ?>">
                    <i class="bi bi-file-earmark-text-fill menu-icon"></i>
                    <span class="menu-text">Cotizaciones</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="<?= base_url('proyectos') ?>" class="menu-link <?= $isActive('proyectos') ?>">
                    <i class="bi bi-kanban-fill menu-icon"></i>
                    <span class="menu-text">Proyectos</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="<?= base_url('facturacion') ?>" class="menu-link <?= $isActive('facturacion') ?>">
                    <i class="bi bi-receipt menu-icon"></i>
                    <span class="menu-text">Facturación</span>
                </a>
            </li>

            <li class="menu-header">Análisis</li>

            <li class="menu-item">
                <a href="<?= base_url('reportes') ?>" class="menu-link <?= $isActive('reportes') ?>">
                    <i class="bi bi-bar-chart-fill menu-icon"></i>
                    <span class="menu-text">Reportes</span>
                </a>
            </li>

            <li class="menu-header">Landing Page</li>

            <li class="menu-item has-submenu">
                <a href="#" class="menu-link" data-submenu="menuLanding"
                   aria-expanded="<?= $isOpen(['services', 'testimonials', 'team-members']) ? 'true' : 'false' ?>">
                    <i class="bi bi-window-desktop menu-icon"></i>
                    <span class="menu-text">Secciones del Sitio</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <ul id="menuLanding" class="submenu <?= $isOpen(['services', 'testimonials', 'team-members']) ? 'show' : '' ?>">
                    <li class="flyout-header">Secciones del Sitio</li>
                    <li class="menu-item">
                        <a href="<?= base_url('services') ?>" class="menu-link <?= $isActive('services') ?>">
                            <i class="bi bi-briefcase-fill menu-icon"></i>
                            <span class="menu-text">Servicios</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('testimonials') ?>" class="menu-link <?= $isActive('testimonials') ?>">
                            <i class="bi bi-chat-quote-fill menu-icon"></i>
                            <span class="menu-text">Testimonios</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('team-members') ?>" class="menu-link <?= $isActive('team-members') ?>">
                            <i class="bi bi-person-lines-fill menu-icon"></i>
                            <span class="menu-text">Equipo</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Catálogos</li>

            <li class="menu-item has-submenu">
                <a href="#" class="menu-link" data-submenu="menuCatalogos"
                   aria-expanded="<?= $isOpen(['currencies', 'service-types']) ? 'true' : 'false' ?>">
                    <i class="bi bi-collection-fill menu-icon"></i>
                    <span class="menu-text">Catálogos</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <ul id="menuCatalogos" class="submenu <?= $isOpen(['currencies', 'service-types']) ? 'show' : '' ?>">
                    <li class="flyout-header">Catálogos</li>
                    <li class="menu-item">
                        <a href="<?= base_url('currencies') ?>" class="menu-link <?= $isActive('currencies') ?>">
                            <i class="bi bi-currency-exchange menu-icon"></i>
                            <span class="menu-text">Monedas</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('service-types') ?>" class="menu-link <?= $isActive('service-types') ?>">
                            <i class="bi bi-tags-fill menu-icon"></i>
                            <span class="menu-text">Tipos de Servicio</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Seguridad</li>

            <li class="menu-item has-submenu">
                <a href="#" class="menu-link" data-submenu="menuSeguridad"
                   aria-expanded="<?= $isOpen(['users', 'roles']) ? 'true' : 'false' ?>">
                    <i class="bi bi-shield-lock-fill menu-icon"></i>
                    <span class="menu-text">Seguridad</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <ul id="menuSeguridad" class="submenu <?= $isOpen(['users', 'roles']) ? 'show' : '' ?>">
                    <li class="flyout-header">Seguridad</li>
                    <li class="menu-item">
                        <a href="<?= base_url('users') ?>" class="menu-link <?= $isActive('users') ?>">
                            <i class="bi bi-people-fill menu-icon"></i>
                            <span class="menu-text">Usuarios</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('roles') ?>" class="menu-link <?= $isActive('roles') ?>">
                            <i class="bi bi-person-badge-fill menu-icon"></i>
                            <span class="menu-text">Roles</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header">Sistema</li>

            <li class="menu-item has-submenu">
                <a href="#" class="menu-link" data-submenu="menuConfig"
                   aria-expanded="<?= $isOpen(['configuracion', 'locales']) ? 'true' : 'false' ?>">
                    <i class="bi bi-gear-fill menu-icon"></i>
                    <span class="menu-text">Configuración</span>
                    <i class="bi bi-chevron-right menu-arrow"></i>
                </a>
                <ul id="menuConfig" class="submenu <?= $isOpen(['configuracion', 'locales']) ? 'show' : '' ?>">
                    <li class="flyout-header">Configuración</li>
                    <li class="menu-item">
                        <a href="<?= base_url('configuracion/general') ?>" class="menu-link"><span class="menu-text">General</span></a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= base_url('locales') ?>" class="menu-link <?= $isActive('locales') ?>">
                            <i class="bi bi-globe menu-icon"></i>
                            <span class="menu-text">Idiomas</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
