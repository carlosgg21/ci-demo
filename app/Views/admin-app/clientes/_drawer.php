<!-- Drawer Crear/Editar Cliente -->
<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
<div class="drawer" id="drawerCliente">
    <div class="drawer-header">
        <h5 id="drawerTitle">Nuevo Cliente</h5>
        <button class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x-lg"></i></button>
    </div>
    <form id="formCliente" method="post" action="<?= base_url('clientes/store') ?>">
        <?= csrf_field() ?>
        <div class="drawer-body">
            <div class="mb-3">
                <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                <input type="text" name="nombre" class="form-control" id="clienteNombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" id="clienteEmail" required>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" id="clienteTelefono">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" id="clienteEstado">
                        <option value="activo">Activo</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Empresa</label>
                <input type="text" name="empresa" class="form-control" id="clienteEmpresa">
            </div>
            <div class="mb-3">
                <label class="form-label">Notas</label>
                <textarea name="notas" class="form-control" id="clienteNotas" rows="3" placeholder="Notas internas..."></textarea>
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-outline-secondary" onclick="closeDrawer()">Cancelar</button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i><span id="btnSaveText">Guardar</span>
            </button>
        </div>
    </form>
</div>
