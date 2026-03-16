<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="testimonialPage" @keydown.escape.window="drawerOpen = false; transDrawerOpen = false">

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
    <table id="testimonialTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Testimonio</th>
                <th>Rating</th>
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
                        <i class="bi bi-chat-quote"></i>
                        <h6>No hay testimonios</h6>
                        <p class="small">Agrega tu primer testimonio para empezar.</p>
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
                            <?= strtoupper(substr($item->client_name, 0, 2)) ?>
                        </div>
                        <div>
                            <span class="fw-semibold"><?= esc($item->client_name) ?></span>
                            <?php if ($item->client_position): ?>
                                <div class="text-muted small"><?= esc($item->client_position) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="text-muted small text-truncate" style="max-width:250px;">
                        <?= esc($item->content) ?>
                    </div>
                </td>
                <td>
                    <?php if ($item->rating): ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi bi-star<?= $i <= $item->rating ? '-fill text-warning' : ' text-muted' ?>" style="font-size:0.7rem;"></i>
                        <?php endfor; ?>
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
                                            'id'              => $item->id,
                                            'client_name'     => $item->client_name,
                                            'client_position' => $item->client_position,
                                            'content'         => $item->content,
                                            'rating'          => $item->rating,
                                            'sort_order'      => $item->sort_order,
                                            'is_active'       => $item->is_active,
                                        ]), 'attr') ?>)">
                                    <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                </button>
                            </li>
                            <?php if (!empty($secondaryLocales)): ?>
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openTranslate(<?= esc(json_encode([
                                            'id'              => $item->id,
                                            'client_name'     => $item->client_name,
                                            'client_position' => $item->client_position,
                                            'content'         => $item->content,
                                            'translations'    => $item->getTranslationsArray(),
                                        ]), 'attr') ?>, '<?= esc($item->client_name) ?>')">
                                    <i class="bi bi-translate me-2 text-muted"></i>Traducir
                                </button>
                            </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger"
                                        @click="confirmDelete(<?= $item->id ?>, '<?= esc($item->client_name) ?>')">
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

<?= $this->include('testimonials/_drawer') ?>
<?= $this->include('partials/_translate_drawer') ?>

</div><!-- end x-data -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    window.TestimonialPageConfig = {
        baseUrl:    '<?= base_url('testimonials') ?>',
        apiBaseUrl: '<?= base_url('api/v1/testimonials') ?>',
        locales: <?= json_encode(array_map(fn($l) => [
            'code' => $l->code,
            'name' => $l->name,
        ], $secondaryLocales)) ?>,
        translatableFields: ['client_name', 'client_position', 'content'],
        translatableLabels: { client_name: 'Nombre del cliente', client_position: 'Cargo', content: 'Testimonio' },
    };
</script>
<script src="<?= base_url('assets/js/components/translate-drawer.js') ?>"></script>
<script src="<?= base_url('assets/js/components/testimonial-page.js') ?>"></script>
<?= $this->endSection() ?>
