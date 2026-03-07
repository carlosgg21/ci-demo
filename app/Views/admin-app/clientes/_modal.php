<!-- Modal Crear/Editar Cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClienteTitle">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- El action se cambia dinámicamente con JS (store o update/id) -->
            <form id="formCliente" method="post" action="<?= base_url('clientes/store') ?>">
                <?= csrf_field() ?>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" id="clienteNombre" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" id="clienteEmail" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" id="clienteTelefono">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Empresa</label>
                        <input type="text" name="empresa" class="form-control" id="clienteEmpresa">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" id="clienteEstado">
                            <option value="activo">Activo</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i><span id="btnSaveText">Guardar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
