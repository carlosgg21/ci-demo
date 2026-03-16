<!-- Drawer Crear/Editar Miembro -->
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nuevo Miembro' : 'Editar Miembro'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <input type="hidden" name="company_id" value="1">
        <div class="drawer-body" x-ref="drawerBody">
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                       x-model="form.name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cargo</label>
                <input type="text" name="position" class="form-control"
                       x-model="form.position">
            </div>
            <div class="mb-3">
                <label class="form-label">Biografia</label>
                <textarea name="bio" class="form-control" rows="3"
                          x-model="form.bio"></textarea>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           x-model="form.email">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Telefono</label>
                    <input type="tel" name="phone" class="form-control"
                           x-model="form.phone">
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Orden</label>
                    <input type="number" name="sort_order" class="form-control"
                           x-model="form.sort_order">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Estado</label>
                    <select name="is_active" class="form-select" x-model="form.is_active">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
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
