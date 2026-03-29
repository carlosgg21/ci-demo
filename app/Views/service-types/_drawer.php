<!-- Drawer Crear/Editar Tipo de Servicio (Alpine controlled) -->
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nuevo Tipo de Servicio' : 'Editar Tipo de Servicio'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <div class="drawer-body" x-ref="drawerBody">
            <div class="mb-3">
                <label class="form-label">Denominación <span class="text-danger">*</span></label>
                <input type="text" name="denomination" class="form-control"
                       x-model="form.denomination" maxlength="150" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3"
                          x-model="form.description"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="is_active" class="form-select" x-model="form.is_active">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
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
