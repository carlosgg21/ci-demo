<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="login-wrapper">
    <!-- Left Panel – Branding -->
    <div class="login-brand d-none d-lg-flex">
        <div class="brand-content">
            <div class="brand-logo mb-4">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="height:52px; filter:brightness(0) invert(1);">
            </div>
            <h1 class="display-6 fw-bold text-white mb-3">Panel de Administración</h1>
            <p class="text-white-50 fs-5 mb-0">Gestiona tu landing page, servicios, equipo y más desde un solo lugar.</p>
            <div class="brand-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>
    </div>

    <!-- Right Panel – Form -->
    <div class="login-form-panel">
        <div class="login-form-container">
            <!-- Mobile logo -->
            <div class="d-lg-none text-center mb-4">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" style="height:40px;">
            </div>

            <div class="mb-4">
                <h2 class="fw-bold mb-1" style="color:#1e293b;">Bienvenido de nuevo</h2>
                <p class="text-muted mb-0">Ingresa tus credenciales para continuar</p>
            </div>

            <!-- Flash messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif ?>

            <form action="<?= base_url('login') ?>" method="POST" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label fw-medium">Correo electrónico</label>
                    <div class="input-group input-group-modern">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="correo@ejemplo.com"
                            value="<?= esc(old('email')) ?>"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label fw-medium mb-0">Contraseña</label>
                    </div>
                    <div class="input-group input-group-modern">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="input-group-text btn-toggle-pass" onclick="togglePassword()" tabindex="-1">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Reset auth layout body */
    body { background: #f1f5f9; display: block; min-height: 100vh; padding: 0; margin: 0; }

    .login-wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* ── Left branding panel ── */
    .login-brand {
        flex: 0 0 46%;
        background: linear-gradient(135deg, #435ebe 0%, #5b73e8 50%, #7c8ef7 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem;
    }

    .brand-content {
        position: relative;
        z-index: 2;
        max-width: 380px;
    }

    /* Floating shapes */
    .brand-shapes .shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }
    .shape-1 { width: 300px; height: 300px; top: -80px; right: -80px; }
    .shape-2 { width: 200px; height: 200px; bottom: 60px; left: -60px; }
    .shape-3 { width: 120px; height: 120px; bottom: 200px; right: 40px; background: rgba(255,255,255,0.05); }

    /* ── Right form panel ── */
    .login-form-panel {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: #fff;
    }

    .login-form-container {
        width: 100%;
        max-width: 420px;
    }

    /* Input group styling */
    .input-group-modern .input-group-text {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
    }

    .input-group-modern .form-control {
        border-color: #e2e8f0;
        padding: 0.65rem 0.9rem;
        font-size: 0.9375rem;
    }

    .input-group-modern .form-control:focus {
        border-color: #435ebe;
        box-shadow: 0 0 0 3px rgba(67,94,190,0.12);
    }

    .input-group-modern .form-control:focus + .btn-toggle-pass,
    .input-group-modern .form-control:focus ~ .input-group-text {
        border-color: #435ebe;
    }

    .btn-toggle-pass {
        cursor: pointer;
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
        transition: color 0.2s;
    }
    .btn-toggle-pass:hover { color: #435ebe; }

    .form-label { color: #374151; font-size: 0.875rem; }

    /* Login button */
    .btn-login {
        background: linear-gradient(135deg, #435ebe, #5b73e8);
        border: none;
        padding: 0.75rem;
        font-size: 0.9375rem;
        font-weight: 600;
        border-radius: 0.6rem;
        letter-spacing: 0.01em;
        transition: opacity 0.2s, transform 0.15s;
    }
    .btn-login:hover { opacity: 0.92; transform: translateY(-1px); }
    .btn-login:active { transform: translateY(0); }

    /* Alert */
    .alert-danger {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
        border-radius: 0.6rem;
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .login-form-panel {
            min-height: 100vh;
            background: #f1f5f9;
            padding: 1.5rem;
        }
        .login-form-container {
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
    }
</style>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>

<?= $this->endSection() ?>
