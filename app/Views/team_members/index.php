<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="teamMemberPage" @keydown.escape.window="drawerOpen = false; transDrawerOpen = false">

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
    <table id="teamMemberTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Email</th>
                <th>Orden</th>
                <th>Estado</th>
                <th data-sortable="false" width="50"></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($items)): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h6>No hay miembros</h6>
                        <p class="small">Agrega tu primer miembro del equipo.</p>
                    </div>
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($items as $item): ?>
            <tr>
                <td class="text-muted small"><?= $item->id ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-2" style="width:30px;height:30px;font-size:0.7rem;">
                            <?= strtoupper(substr($item->name, 0, 2)) ?>
                        </div>
                        <span class="fw-semibold"><?= esc($item->name) ?></span>
                    </div>
                </td>
                <td>
                    <?php if ($item->position): ?>
                        <span class="text-muted small"><?= esc($item->position) ?></span>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($item->email): ?>
                        <span class="text-muted small"><?= esc($item->email) ?></span>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </td>
                <td><?= $item->sort_order ?></td>
                <td>
                    <span class="badge <?= $item->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"
                          role="button" title="Clic para cambiar estado"
                          style="cursor:pointer;"
                          @click="toggleStatus(<?= $item->id ?>, $event)">
                        <?= $item->is_active ? 'Activo' : 'Inactivo' ?>
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
                                        @click="openEdit(<?= esc(json_encode([
                                            'id'           => $item->id,
                                            'name'         => $item->name,
                                            'position'     => $item->position,
                                            'bio'          => $item->bio,
                                            'email'        => $item->email,
                                            'phone'        => $item->phone,
                                            'sort_order'   => $item->sort_order,
                                            'is_active'    => $item->is_active,
                                        ]), 'attr') ?>)">
                                    <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                </button>
                            </li>
                            <?php if (!empty($secondaryLocales)): ?>
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openTranslate(<?= esc(json_encode([
                                            'id'           => $item->id,
                                            'name'         => $item->name,
                                            'position'     => $item->position,
                                            'bio'          => $item->bio,
                                            'translations' => $item->getTranslationsArray(),
                                        ]), 'attr') ?>, '<?= esc($item->name) ?>')">
                                    <i class="bi bi-translate me-2 text-muted"></i>Traducir
                                </button>
                            </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger"
                                        @click="confirmDelete(<?= $item->id ?>, '<?= esc($item->name) ?>')">
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

<?= $this->include('team_members/_drawer') ?>
<?= $this->include('partials/_translate_drawer') ?>

</div><!-- end x-data -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    window.TeamMemberPageConfig = {
        baseUrl:    '<?= base_url('team-members') ?>',
        apiBaseUrl: '<?= base_url('api/v1/team-members') ?>',
        locales: <?= json_encode(array_map(fn($l) => [
            'code' => $l->code,
            'name' => $l->name,
        ], $secondaryLocales)) ?>,
        translatableFields: ['name', 'position', 'bio'],
        translatableLabels: { name: 'Nombre', position: 'Cargo', bio: 'Biografia' },
    };
</script>
<script src="<?= base_url('assets/js/components/translate-drawer.js') ?>"></script>
<script src="<?= base_url('assets/js/components/team-member-page.js') ?>"></script>
<?= $this->endSection() ?>
