<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="currencyPage" @keydown.escape.window="drawerOpen = false">

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
    <table id="currencyTable" class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Acrónimo</th>
                    <th>Moneda</th>
                    <th>Símbolo</th>
                    <th>Estado</th>
                    <th data-sortable="false" width="50"></th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($currencies)): ?>
                <tr>
                    <td colspan="6">
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
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-2" style="width:30px;height:30px;font-size:0.7rem;">
                                <?= strtoupper(substr($currency->acronym, 0, 2)) ?>
                            </div>
                            <span class="fw-semibold"><?= esc($currency->acronym) ?></span>
                        </div>
                    </td>
                    <td><?= $currency->getFlagHtml() ?> <?= esc($currency->name) ?></td>
                    <td><?= esc($currency->sign) ?></td>
                    <td>
                        <span class="badge <?= $currency->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"
                              role="button" title="Clic para cambiar estado"
                              style="cursor:pointer;"
                              @click="toggleStatus(<?= $currency->id ?>, $event)">
                            <?= $currency->status === 'active' ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
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

<?= $this->include('currencies/_drawer') ?>


</div><!-- end x-data="currencyPage" -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    /* PHP -> JS config bridge */
    window.CurrencyPageConfig = {
        baseUrl:    '<?= base_url('currencies') ?>',
        apiBaseUrl: '<?= base_url('api/v1/currencies') ?>',
    };
</script>
<script src="<?= base_url('assets/js/components/currency-page.js') ?>"></script>
<?= $this->endSection() ?>
