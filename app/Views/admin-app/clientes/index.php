<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Toolbar unificada -->
<div class="crud-toolbar">
    <div class="crud-toolbar-left">
        <div class="crud-search">
            <form method="get" action="<?= base_url('clientes') ?>">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Buscar cliente..."
                           value="<?= esc($search) ?>">
                </div>
            </form>
        </div>
        <button class="btn btn-filter" id="btnFilter" onclick="toggleFilters()">
            <i class="bi bi-funnel me-1"></i>Filtros
        </button>
    </div>
    <div class="crud-toolbar-right">
        <button class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-download me-1"></i>Exportar
        </button>
        <button class="btn btn-primary btn-sm" onclick="openDrawer()">
            <i class="bi bi-plus-lg me-1"></i>Nuevo Cliente
        </button>
    </div>
</div>

<!-- Panel de filtros -->
<div class="filter-panel" id="filterPanel">
    <form method="get" action="<?= base_url('clientes') ?>" class="filter-group">
        <input type="hidden" name="q" value="<?= esc($search) ?>">
        <label>Estado</label>
        <select class="form-select" name="estado" onchange="this.form.submit()">
            <option value="">Todos</option>
            <option value="activo" <?= ($filters['estado'] ?? '') === 'activo' ? 'selected' : '' ?>>Activo</option>
            <option value="pendiente" <?= ($filters['estado'] ?? '') === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="inactivo" <?= ($filters['estado'] ?? '') === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
        </select>
        <label>Empresa</label>
        <select class="form-select" name="empresa" onchange="this.form.submit()">
            <option value="">Todas</option>
            <?php foreach ($empresas ?? [] as $emp): ?>
                <option value="<?= esc($emp) ?>" <?= ($filters['empresa'] ?? '') === $emp ? 'selected' : '' ?>><?= esc($emp) ?></option>
            <?php endforeach; ?>
        </select>
        <a href="<?= base_url('clientes') ?>" class="btn btn-sm btn-link text-muted text-decoration-none">
            <i class="bi bi-x-lg me-1"></i>Limpiar
        </a>
    </form>
</div>

<!-- Table -->
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th width="50"></th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($clientes)): ?>
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <h6>No hay clientes</h6>
                            <p class="small">Agrega tu primer cliente para empezar.</p>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-2" style="width:30px;height:30px;font-size:0.7rem;">
                                <?= strtoupper(substr($c['nombre'], 0, 2)) ?>
                            </div>
                            <span class="fw-semibold"><?= esc($c['nombre']) ?></span>
                        </div>
                    </td>
                    <td><?= esc($c['email']) ?></td>
                    <td><?= esc($c['telefono'] ?? '—') ?></td>
                    <td><?= esc($c['empresa'] ?? '—') ?></td>
                    <td>
                        <?php
                        $badgeClass = match($c['estado']) {
                            'activo'    => 'badge-active',
                            'pendiente' => 'badge-pending',
                            'inactivo'  => 'badge-inactive',
                            default     => 'badge-active',
                        };
                        ?>
                        <span class="badge badge-status <?= $badgeClass ?>"><?= ucfirst($c['estado']) ?></span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('clientes/' . $c['id']) ?>"><i class="bi bi-eye me-2 text-muted"></i>Ver detalle</a></li>
                                <li><a class="dropdown-item" href="#"
                                       onclick="editCliente(<?= esc(json_encode($c), 'attr') ?>)"><i class="bi bi-pencil me-2 text-muted"></i>Editar</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-copy me-2 text-muted"></i>Duplicar</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"
                                       onclick="confirmDelete(<?= $c['id'] ?>, '<?= esc($c['nombre']) ?>')"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($pager)): ?>
    <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
        <small class="text-muted"><?= $pager->getTotal() ?> registros encontrados</small>
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->include('pages/clientes/_drawer') ?>

<!-- Modal Confirmar Eliminar -->
<div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size:2.5rem;"></i>
                <h5 class="mt-3 mb-2">¿Eliminar cliente?</h5>
                <p class="text-muted small mb-0">
                    Se eliminará <strong id="deleteClienteName"></strong>. Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="post">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash me-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    function toggleFilters() {
        document.getElementById('filterPanel').classList.toggle('show');
        document.getElementById('btnFilter').classList.toggle('active');
    }

    // === Drawer ===
    function openDrawer() {
        resetDrawer();
        document.getElementById('drawerCliente').classList.add('show');
        document.getElementById('drawerOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('clienteNombre').focus(), 300);
    }

    function closeDrawer() {
        document.getElementById('drawerCliente').classList.remove('show');
        document.getElementById('drawerOverlay').classList.remove('show');
        document.body.style.overflow = '';
    }

    function resetDrawer() {
        document.getElementById('drawerTitle').textContent = 'Nuevo Cliente';
        document.getElementById('formCliente').action = '<?= base_url('clientes/store') ?>';
        document.getElementById('formCliente').reset();
        document.getElementById('btnSaveText').textContent = 'Guardar';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && document.getElementById('drawerCliente').classList.contains('show')) {
            closeDrawer();
        }
    });

    function editCliente(data) {
        document.getElementById('drawerTitle').textContent = 'Editar Cliente';
        document.getElementById('formCliente').action = '<?= base_url('clientes/update/') ?>' + data.id;
        document.getElementById('btnSaveText').textContent = 'Actualizar';
        document.getElementById('clienteNombre').value   = data.nombre;
        document.getElementById('clienteEmail').value     = data.email;
        document.getElementById('clienteTelefono').value  = data.telefono || '';
        document.getElementById('clienteEmpresa').value   = data.empresa || '';
        document.getElementById('clienteEstado').value    = data.estado;
        document.getElementById('drawerCliente').classList.add('show');
        document.getElementById('drawerOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function confirmDelete(id, nombre) {
        document.getElementById('deleteClienteName').textContent = nombre;
        document.getElementById('deleteForm').action = '<?= base_url('clientes/delete/') ?>' + id;
        new bootstrap.Modal(document.getElementById('modalDelete')).show();
    }

    <?php if (!empty($filters)): ?>
    document.addEventListener('DOMContentLoaded', () => toggleFilters());
    <?php endif; ?>
</script>
<?= $this->endSection() ?>
