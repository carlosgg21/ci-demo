<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="localePage" @keydown.escape.window="drawerOpen = false">

<!-- Panel de filtros -->
<div class="filter-panel" :class="{ 'show': filtersOpen }">
    <div class="filter-group">
        <label>Estado</label>
        <select class="form-select" @change="applyStatusFilter($event.target.value)" x-ref="statusFilter">
            <option value="all">Todos</option>
            <option value="active" selected>Activo</option>
            <option value="inactive">Inactivo</option>
        </select>
        <button type="button" class="btn btn-sm btn-link text-muted text-decoration-none"
                @click="$refs.statusFilter.value = 'all'; applyStatusFilter('all')">
            <i class="bi bi-x-lg me-1"></i>Limpiar
        </button>
    </div>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-globe"></i></div>
                <div>
                    <div class="stat-value"><?= $stats['total'] ?></div>
                    <div class="stat-label">Total idiomas</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-check-circle"></i></div>
                <div>
                    <div class="stat-value"><?= $stats['active'] ?></div>
                    <div class="stat-label">Activos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-x-circle"></i></div>
                <div>
                    <div class="stat-value"><?= $stats['inactive'] ?></div>
                    <div class="stat-label">Inactivos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card table-card" x-ref="tableCard">
    <table id="localeTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Por defecto</th>
                <th>Estado</th>
                <th data-sortable="false" width="50"></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($locales)): ?>
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="bi bi-globe"></i>
                        <h6>No hay idiomas</h6>
                        <p class="small">Agrega tu primer idioma para empezar.</p>
                    </div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($locales as $locale): ?>
            <tr>
                <td class="text-muted small"><?= $locale->id ?></td>
                <td>
                    <code class="text-secondary fw-semibold"
                          style="font-size:.85rem;letter-spacing:.05em;">
                        <?= esc(strtoupper($locale->code)) ?>
                    </code>
                </td>
                <td class="fw-semibold"><?= esc($locale->name) ?></td>
                <td>
                    <?php if ($locale->isDefault()): ?>
                        <span class="text-primary small fw-semibold">
                            <i class="bi bi-star-fill me-1"></i>Principal
                        </span>
                    <?php else: ?>
                        <span class="text-muted small">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge <?= $locale->isActive() ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"
                          role="button" title="Clic para cambiar estado"
                          style="cursor:pointer;"
                          @click="toggleStatus(<?= $locale->id ?>, $event)">
                        <?= $locale->isActive() ? 'Activo' : 'Inactivo' ?>
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openEdit(JSON.parse($el.dataset.entity))"
                                        data-entity="<?= esc(json_encode([
                                            'id'         => $locale->id,
                                            'code'       => $locale->code,
                                            'name'       => $locale->name,
                                            'is_default' => $locale->is_default,
                                            'is_active'  => $locale->is_active,
                                        ]), 'attr') ?>">
                                    <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger"
                                        @click="confirmDelete(<?= $locale->id ?>, '<?= esc($locale->name) ?>')">
                                    <i class="bi bi-trash me-2"></i>Eliminar
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->include('locales/_drawer') ?>

</div><!-- end x-data -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    window.LocalePageConfig = {
        baseUrl:    '<?= base_url('locales') ?>',
        apiBaseUrl: '<?= base_url('api/v1/locales') ?>',
    };
</script>
<script src="<?= base_url('assets/js/components/locale-page.js') ?>"></script>
<?= $this->endSection() ?>
