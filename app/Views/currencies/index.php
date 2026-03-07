<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="currencyPage" @keydown.escape.window="drawerOpen = false">

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-currency-exchange"></i>
                </div>
                <div>
                    <div class="text-muted small">Total</div>
                    <div class="fs-4 fw-bold"><?= $stats['total'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Activas</div>
                    <div class="fs-4 fw-bold"><?= $stats['active'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-danger bg-opacity-10 text-danger me-3">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Inactivas</div>
                    <div class="fs-4 fw-bold"><?= $stats['inactive'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toolbar -->
<div class="crud-toolbar">
    <div class="crud-toolbar-left">
        <div class="crud-search">
            <form method="get" action="<?= base_url('currencies') ?>">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0"
                           placeholder="Buscar moneda..." value="<?= esc($search ?? '') ?>">
                    <?php if (!empty($search)): ?>
                    <a href="<?= base_url('currencies') ?>" class="input-group-text bg-transparent border-start-0 text-muted">
                        <i class="bi bi-x-lg" style="font-size:.7rem;"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <button class="btn btn-filter" :class="{ 'active': filtersOpen }" @click="filtersOpen = !filtersOpen">
            <i class="bi bi-funnel me-1"></i>Filtros
            <?php if (!empty($filters)): ?>
            <span class="badge bg-primary ms-1" style="font-size:.65rem;">1</span>
            <?php endif; ?>
        </button>
    </div>
    <div class="crud-toolbar-right">
        <button class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-download me-1"></i>Exportar
        </button>
        <button class="btn btn-primary btn-sm" @click="openCreate()">
            <i class="bi bi-plus-lg me-1"></i>Nueva Moneda
        </button>
    </div>
</div>

<!-- Panel de filtros -->
<div class="filter-panel" :class="{ 'show': filtersOpen }">
    <form method="get" action="<?= base_url('currencies') ?>" class="filter-group">
        <input type="hidden" name="q" value="<?= esc($search ?? '') ?>">
        <label>Estado</label>
        <select class="form-select" name="status">
            <option value="">Todos</option>
            <option value="active"   <?= ($filters['status'] ?? '') === 'active'   ? 'selected' : '' ?>>Activo</option>
            <option value="inactive" <?= ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
        </select>
        <a href="<?= base_url('currencies') ?>" class="btn btn-sm btn-link text-muted text-decoration-none">
            <i class="bi bi-x-lg me-1"></i>Limpiar
        </a>
    </form>
</div>

<!-- Table -->
<div class="card table-card" x-ref="tableCard" :class="{ 'opacity-50 pe-none': loading }">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bandera</th>
                    <th>Acrónimo</th>
                    <th>Moneda</th>
                    <th>Símbolo</th>
                    <th>ISO Num</th>
                    <th>Estado</th>
                    <th width="50"></th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($currencies)): ?>
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-currency-exchange"></i>
                            <h6>No hay monedas</h6>
                            <p class="small">Agrega tu primera moneda para empezar.</p>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($currencies as $currency): ?>
                <tr>
                    <td class="text-muted small"><?= $currency->id ?></td>
                    <td><?= $currency->getFlagHtml() ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-2" style="width:30px;height:30px;font-size:0.7rem;">
                                <?= strtoupper(substr($currency->acronym, 0, 2)) ?>
                            </div>
                            <span class="fw-semibold"><?= esc($currency->acronym) ?></span>
                        </div>
                    </td>
                    <td><?= esc($currency->name) ?></td>
                    <td><?= esc($currency->sign) ?></td>
                    <td class="text-muted"><?= $currency->iso_numeric ?? '—' ?></td>
                    <td><?= $currency->getStatusBadge() ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('currencies/' . $currency->id) ?>">
                                        <i class="bi bi-eye me-2 text-muted"></i>Ver detalle
                                    </a>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item"
                                            @click="openEdit(<?= esc(json_encode([
                                                'id'            => $currency->id,
                                                'acronym'       => $currency->acronym,
                                                'name'          => $currency->name,
                                                'sign'          => $currency->sign,
                                                'iso_numeric'   => $currency->iso_numeric,
                                                'internal_code' => $currency->internal_code,
                                                'flag'          => $currency->flag,
                                                'status'        => $currency->status,
                                            ]), 'attr') ?>)">
                                        <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                    </button>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger"
                                            @click="confirmDelete(<?= $currency->id ?>, '<?= esc($currency->name) ?>')">
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

    <?php if ($pager): ?>
    <?php
        $currentPage = $pager->getCurrentPage();
        $perPage     = $pager->getPerPage();
        $total       = $pager->getTotal();
        $from        = ($currentPage - 1) * $perPage + 1;
        $to          = min($currentPage * $perPage, $total);
    ?>
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted">Mostrando <?= $from ?>-<?= $to ?> de <?= $total ?> registros</small>
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->include('currencies/_drawer') ?>

<!-- Modal Confirmar Eliminar -->
<div class="modal fade" id="modalDelete" tabindex="-1" x-ref="modalDelete">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2.5rem;"></i>
                <h5 class="mt-3 mb-2">¿Eliminar moneda?</h5>
                <p class="text-muted small mb-0">
                    Se eliminará <strong x-text="deleteName"></strong>. Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <form :action="'<?= base_url('currencies/') ?>' + deleteId" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</div><!-- end x-data="currencyPage" -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    /* PHP → JS config bridge (único PHP permitido aquí) */
    window.CurrencyPageConfig = {
        filtersOpen: <?= !empty($filters) ? 'true' : 'false' ?>,
        baseUrl:     '<?= base_url('currencies') ?>',
    };
</script>
<script src="<?= base_url('assets/js/utils/fetch-partial.js') ?>"></script>
<script src="<?= base_url('assets/js/components/currency-page.js') ?>"></script>
<?= $this->endSection() ?>
