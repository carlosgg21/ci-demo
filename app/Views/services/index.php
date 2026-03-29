<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="servicePage" @keydown.escape.window="drawerOpen = false; transDrawerOpen = false">

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

<!-- Table -->
<div class="card table-card" x-ref="tableCard">
    <table id="serviceTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Slug</th>
                <th>Icono</th>
                <th>Orden</th>
                <th>Estado</th>
                <th data-sortable="false" width="50"></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($services)): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-gear"></i>
                        <h6>No hay servicios</h6>
                        <p class="small">Agrega tu primer servicio para empezar.</p>
                    </div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($services as $service): ?>
            <tr>
                <td class="text-muted small"><?= $service->id ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-2" style="width:30px;height:30px;font-size:0.7rem;">
                            <?= strtoupper(substr($service->name, 0, 2)) ?>
                        </div>
                        <div>
                            <span class="fw-semibold"><?= esc($service->name) ?></span>
                            <?php if ($service->description): ?>
                                <div class="text-muted small text-truncate" style="max-width:250px;"><?= esc($service->description) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td><span class="text-muted small"><?= esc($service->slug) ?></span></td>
                <td>
                    <?php if ($service->icon): ?>
                        <i class="<?= esc($service->icon) ?>"></i>
                        <span class="text-muted small ms-1"><?= esc($service->icon) ?></span>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td><?= $service->sort_order ?></td>
                <td>
                    <span class="badge <?= $service->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"
                          role="button" title="Clic para cambiar estado"
                          style="cursor:pointer;"
                          @click="toggleStatus(<?= $service->id ?>, $event)">
                        <?= $service->is_active ? 'Activo' : 'Inactivo' ?>
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('services/' . $service->id) ?>">
                                    <i class="bi bi-eye me-2 text-muted"></i>Ver detalle
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openEdit(JSON.parse($el.dataset.entity))"
                                        data-entity="<?= esc(json_encode([
                                            'id'              => $service->id,
                                            'service_type_id' => $service->service_type_id,
                                            'name'            => $service->name,
                                            'slug'            => $service->slug,
                                            'description'     => $service->description,
                                            'icon'            => $service->icon,
                                            'image'           => $service->image,
                                            'sort_order'      => $service->sort_order,
                                            'is_active'       => $service->is_active,
                                        ]), 'attr') ?>">
                                    <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                </button>
                            </li>
                            <?php if (!empty($secondaryLocales)): ?>
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openTranslate(JSON.parse($el.dataset.entity), $el.dataset.name)"
                                        data-entity="<?= esc(json_encode([
                                            'id'           => $service->id,
                                            'name'         => $service->name,
                                            'description'  => $service->description,
                                            'translations' => $service->getTranslationsArray(),
                                        ]), 'attr') ?>"
                                        data-name="<?= esc($service->name, 'attr') ?>">
                                    <i class="bi bi-translate me-2 text-muted"></i>Traducir
                                </button>
                            </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger"
                                        @click="confirmDelete(<?= $service->id ?>, '<?= esc($service->name) ?>')">
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

<?= $this->include('services/_drawer') ?>
<?= $this->include('partials/_translate_drawer') ?>

</div><!-- end x-data="servicePage" -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    window.ServicePageConfig = {
        baseUrl:    '<?= base_url('services') ?>',
        apiBaseUrl: '<?= base_url('api/v1/services') ?>',
        locales: <?= json_encode(array_map(fn($l) => [
            'code' => $l->code,
            'name' => $l->name,
        ], $secondaryLocales)) ?>,
        translatableFields: ['name', 'description'],
        translatableLabels: { name: 'Nombre', description: 'Descripcion' },
    };
</script>
<script src="<?= base_url('assets/js/components/translate-drawer.js') ?>"></script>
<script src="<?= base_url('assets/js/components/service-page.js') ?>"></script>
<?= $this->endSection() ?>
