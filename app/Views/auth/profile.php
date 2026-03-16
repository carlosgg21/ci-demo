<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-heading mb-4">
    <h3 class="page-title">Mi Perfil</h3>
    <p class="text-muted mb-0">Gestiona tu información personal y seguridad de la cuenta</p>
</div>

<div class="row g-4">

    <!-- ── Avatar Card ── -->
    <div class="col-12 col-lg-4 col-xl-3">
        <div class="card border-0 shadow-sm h-auto">
            <div class="card-body text-center p-4">
                <div class="profile-avatar mx-auto mb-3">
                    <?= strtoupper(substr($user->username, 0, 2)) ?>
                </div>
                <h5 class="fw-bold mb-0"><?= esc($user->username) ?></h5>
                <p class="text-muted small mb-2"><?= esc($user->email) ?></p>
                <span class="badge role-badge role-<?= esc($user->role) ?>">
                    <?php $roleLabels = ['super_admin' => 'Super Admin', 'admin' => 'Administrador', 'editor' => 'Editor']; ?>
                    <?= $roleLabels[$user->role] ?? ucfirst($user->role) ?>
                </span>

                <hr class="my-3">

                <div class="profile-meta text-start">
                    <div class="meta-item">
                        <i class="bi bi-calendar3"></i>
                        <div>
                            <span class="meta-label">Miembro desde</span>
                            <span class="meta-value"><?= date('d M Y', strtotime($user->created_at)) ?></span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-shield-check"></i>
                        <div>
                            <span class="meta-label">Estado</span>
                            <span class="meta-value text-success fw-medium">Activo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Tabs Card ── -->
    <div class="col-12 col-lg-8 col-xl-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-0">
                <ul class="nav nav-tabs nav-tabs-profile" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                            <i class="bi bi-person me-2"></i>Información
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                            <i class="bi bi-lock me-2"></i>Seguridad
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <!-- Flash messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success d-flex align-items-center gap-2 py-2 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('success')) ?></span>
                    </div>
                <?php endif ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-4" role="alert">
                        <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                        <span><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                <?php endif ?>

                <div class="tab-content" id="profileTabsContent">

                    <!-- ── Tab: Información ── -->
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <form action="<?= base_url('perfil') ?>" method="POST" novalidate>
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PUT">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="username" class="form-label">Nombre de usuario</label>
                                    <div class="input-group input-group-profile">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input
                                            type="text"
                                            id="username"
                                            name="username"
                                            class="form-control"
                                            value="<?= esc(old('username', $user->username)) ?>"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <div class="input-group input-group-profile">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="form-control"
                                            value="<?= esc(old('email', $user->email)) ?>"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Rol</label>
                                    <div class="input-group input-group-profile">
                                        <span class="input-group-text"><i class="bi bi-shield"></i></span>
                                        <input type="text" class="form-control" value="<?= $roleLabels[$user->role] ?? ucfirst($user->role) ?>" disabled>
                                    </div>
                                    <div class="form-text">El rol solo puede ser modificado por un Super Administrador.</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-profile-save">
                                    <i class="bi bi-check2 me-2"></i>Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ── Tab: Seguridad ── -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <form action="<?= base_url('perfil') ?>" method="POST" novalidate id="security-form">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PUT">

                            <div class="security-notice mb-4">
                                <i class="bi bi-info-circle-fill"></i>
                                <span>Usa una contraseña segura de al menos 8 caracteres con letras y números.</span>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="current_password" class="form-label">Contraseña actual</label>
                                    <div class="input-group input-group-profile">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" id="current_password" name="current_password" class="form-control" placeholder="••••••••" autocomplete="current-password">
                                        <button type="button" class="input-group-text btn-eye" onclick="toggleField('current_password', 'eye0')"><i class="bi bi-eye" id="eye0"></i></button>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label for="new_password" class="form-label">Nueva contraseña</label>
                                    <div class="input-group input-group-profile">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="••••••••" autocomplete="new-password" oninput="checkStrength(this.value)">
                                        <button type="button" class="input-group-text btn-eye" onclick="toggleField('new_password', 'eye1')"><i class="bi bi-eye" id="eye1"></i></button>
                                    </div>
                                    <div class="password-strength mt-2" id="strength-bar">
                                        <div class="strength-fill" id="strength-fill"></div>
                                    </div>
                                    <div class="form-text" id="strength-label"></div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                                    <div class="input-group input-group-profile">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" autocomplete="new-password">
                                        <button type="button" class="input-group-text btn-eye" onclick="toggleField('confirm_password', 'eye2')"><i class="bi bi-eye" id="eye2"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-profile-save">
                                    <i class="bi bi-shield-lock me-2"></i>Actualizar contraseña
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<style>
/* ── Profile Avatar ── */
.profile-avatar {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    background: linear-gradient(135deg, #435ebe, #7c8ef7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    letter-spacing: 0.02em;
}

/* ── Role badges ── */
.role-badge {
    font-size: 0.75rem;
    padding: 0.35em 0.75em;
    border-radius: 2rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}
.role-super_admin { background: #ede9fe; color: #6d28d9; }
.role-admin       { background: #dbeafe; color: #1d4ed8; }
.role-editor      { background: #dcfce7; color: #15803d; }

/* ── Meta items ── */
.profile-meta { display: flex; flex-direction: column; gap: 0.75rem; }
.meta-item { display: flex; align-items: flex-start; gap: 0.65rem; }
.meta-item > i { font-size: 1rem; color: #94a3b8; margin-top: 2px; }
.meta-label { display: block; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.04em; }
.meta-value { display: block; font-size: 0.875rem; color: #374151; font-weight: 500; }

/* ── Nav tabs ── */
.nav-tabs-profile { border-bottom: 2px solid #e2e8f0; gap: 0.25rem; }
.nav-tabs-profile .nav-link {
    color: #64748b;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    padding: 0.65rem 1.1rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0;
    transition: color 0.2s;
}
.nav-tabs-profile .nav-link:hover { color: #435ebe; background: transparent; }
.nav-tabs-profile .nav-link.active {
    color: #435ebe;
    font-weight: 600;
    border-bottom-color: #435ebe;
    background: transparent;
}

/* ── Input group ── */
.input-group-profile .input-group-text {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #94a3b8;
}
.input-group-profile .form-control {
    border-color: #e2e8f0;
    padding: 0.65rem 0.9rem;
}
.input-group-profile .form-control:focus {
    border-color: #435ebe;
    box-shadow: 0 0 0 3px rgba(67,94,190,0.1);
}
.input-group-profile .form-control:disabled {
    background: #f1f5f9;
    color: #94a3b8;
}
.btn-eye {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #94a3b8;
    cursor: pointer;
    transition: color 0.2s;
}
.btn-eye:hover { color: #435ebe; }

/* ── Security notice ── */
.security-notice {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 0.6rem;
    padding: 0.75rem 1rem;
    color: #1d4ed8;
    font-size: 0.875rem;
}
.security-notice i { font-size: 1rem; flex-shrink: 0; }

/* ── Password strength ── */
.password-strength {
    height: 4px;
    background: #e2e8f0;
    border-radius: 9999px;
    overflow: hidden;
}
.strength-fill {
    height: 100%;
    width: 0;
    border-radius: 9999px;
    transition: width 0.3s, background 0.3s;
}

/* ── Save button ── */
.btn-profile-save {
    background: linear-gradient(135deg, #435ebe, #5b73e8);
    border: none;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 0.5rem;
}
.btn-profile-save:hover { opacity: 0.9; }

/* Alerts */
.alert-success { background:#f0fdf4; border-color:#bbf7d0; color:#15803d; border-radius:0.6rem; font-size:0.875rem; }
.alert-danger  { background:#fef2f2; border-color:#fecaca; color:#b91c1c; border-radius:0.6rem; font-size:0.875rem; }
</style>

<script>
function toggleField(id, iconId) {
    const input = document.getElementById(id);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function checkStrength(value) {
    const fill  = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');
    let score = 0;
    if (value.length >= 6) score++;
    if (value.length >= 10) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;

    const levels = [
        { pct: '20%', color: '#ef4444', text: 'Muy débil' },
        { pct: '40%', color: '#f97316', text: 'Débil' },
        { pct: '60%', color: '#eab308', text: 'Regular' },
        { pct: '80%', color: '#84cc16', text: 'Buena' },
        { pct: '100%', color: '#22c55e', text: 'Muy fuerte' },
    ];

    if (!value) { fill.style.width = '0'; label.textContent = ''; return; }
    const level = levels[Math.min(score - 1, 4)] || levels[0];
    fill.style.width = level.pct;
    fill.style.background = level.color;
    label.textContent = level.text;
    label.style.color = level.color;
}

// Open security tab when there's an error from password change
<?php if (session()->getFlashdata('error') && old('current_password')): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('security-tab').click();
});
<?php endif ?>
</script>

<?= $this->endSection() ?>
