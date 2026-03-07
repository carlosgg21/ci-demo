<!-- Drawer Crear/Editar Moneda (Alpine controlled) -->
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nueva Moneda' : 'Editar Moneda'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <div class="drawer-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Acrónimo <span class="text-danger">*</span></label>
                    <input type="text" name="acronym" class="form-control text-uppercase"
                           x-model="form.acronym" x-ref="acronymInput" maxlength="10" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Símbolo <span class="text-danger">*</span></label>
                    <input type="text" name="sign" class="form-control"
                           x-model="form.sign" maxlength="10" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                       x-model="form.name" required>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">ISO Numérico</label>
                    <input type="number" name="iso_numeric" class="form-control"
                           x-model="form.iso_numeric">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Código Interno</label>
                    <input type="number" name="internal_code" class="form-control"
                           x-model="form.internal_code">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Bandera <span class="text-muted small">(clase CSS)</span>
                    <span class="ms-2" x-show="form.flag">
                        <span :class="form.flag"></span>
                    </span>
                </label>
                <input type="text" name="flag" class="form-control"
                       x-model="form.flag" placeholder="ej. fi fi-us">
            </div>
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="status" class="form-select" x-model="form.status">
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="drawer-footer">
            <button type="button" class="btn btn-outline-secondary" @click="drawerOpen = false">Cancelar</button>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>
                <span x-text="mode === 'create' ? 'Guardar' : 'Actualizar'"></span>
            </button>
        </div>
    </form>
</div>
