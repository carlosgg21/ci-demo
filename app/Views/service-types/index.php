<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="serviceTypePage" @keydown.escape.window="drawerOpen = false">

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
    <table id="serviceTypeTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Denominación</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th data-sortable="false" width="50"></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($serviceTypes)): ?>
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="bi bi-tags"></i>
                        <h6>No hay tipos de servicio</h6>
                        <p class="small">Agrega tu primer tipo de servicio para empezar.</p>
                    </div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($serviceTypes as $type): ?>
            <tr>
                <td class="text-muted small"><?= $type->id ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-2" style="width:30px;height:30px;font-size:0.7rem;">
                            <?= strtoupper(substr($type->denomination, 0, 2)) ?>
                        </div>
                        <span class="fw-semibold"><?= esc($type->denomination) ?></span>
                    </div>
                </td>
                <td>
                    <?php if ($type->description): ?>
                        <span class="text-muted small text-truncate d-inline-block" style="max-width:300px;"><?= esc($type->description) ?></span>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge <?= $type->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"
                          role="button" title="Clic para cambiar estado"
                          style="cursor:pointer;"
                          @click="toggleStatus(<?= $type->id ?>, $event)">
                        <?= $type->is_active ? 'Activo' : 'Inactivo' ?>
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('service-types/' . $type->id) ?>">
                                    <i class="bi bi-eye me-2 text-muted"></i>Ver detalle
                                </a>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openEdit(JSON.parse($el.dataset.entity))"
                                        data-entity="<?= esc(json_encode([
                                            'id'          => $type->id,
                                            'denomination'=> $type->denomination,
                                            'description' => $type->description,
                                            'is_active'   => $type->is_active,
                                        ]), 'attr') ?>">
                                    <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger"
                                        @click="confirmDelete(<?= $type->id ?>, '<?= esc($type->denomination) ?>')">
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

<?= $this->include('service-types/_drawer') ?>

</div><!-- end x-data="serviceTypePage" -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    window.ServiceTypePageConfig = {
        baseUrl:    '<?= base_url('service-types') ?>',
        apiBaseUrl: '<?= base_url('api/v1/service-types') ?>',
    };
</script>
<script src="<?= base_url('assets/js/components/service-type-page.js') ?>"></script>
<?= $this->endSection() ?>
