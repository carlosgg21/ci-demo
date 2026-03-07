<header class="app-header">
    <button class="navbar-toggler-sidebar d-lg-none me-2" id="mobile-sidebar-toggle">
        <i class="bi bi-list fs-4"></i>
    </button>
    <button class="navbar-toggler-sidebar d-none d-lg-block" id="sidebar-toggle" data-bs-toggle="tooltip" title="Toggle sidebar">
        <i class="bi bi-layout-sidebar-inset"></i>
    </button>

    <div class="d-flex align-items-center ms-auto gap-1">
        <!-- Dark mode -->
        <button class="navbar-toggler-sidebar" id="dark-mode-toggle" data-bs-toggle="tooltip" title="Tema oscuro">
            <i class="bi bi-moon-fill"></i>
        </button>

        <!-- Notifications -->
        <div class="dropdown">
            <button class="navbar-toggler-sidebar position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="notification-badge"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end p-3" style="width:280px;">
                <h6 class="mb-2 fw-bold small">Notificaciones</h6>
                <p class="mb-0 text-muted small">No hay notificaciones nuevas</p>
            </div>
        </div>

        <!-- User -->
        <div class="dropdown ms-2">
            <button class="d-flex align-items-center bg-transparent border-0 p-0" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    <?= strtoupper(substr(session()->get('user_name') ?? 'U', 0, 2)) ?>
                </div>
                <span class="d-none d-md-inline ms-2 small fw-semibold text-body">
                    <?= esc(session()->get('user_name') ?? 'Usuario') ?>
                </span>
                <i class="bi bi-chevron-down ms-1 small text-muted"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= base_url('perfil') ?>"><i class="bi bi-person me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('configuracion/general') ?>"><i class="bi bi-gear me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</header>
