<!-- Drawer Crear/Editar Testimonio -->
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nuevo Testimonio' : 'Editar Testimonio'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <input type="hidden" name="company_id" value="1">
        <div class="drawer-body" x-ref="drawerBody">
            <div class="mb-3">
                <label class="form-label">Nombre del cliente <span class="text-danger">*</span></label>
                <input type="text" name="client_name" class="form-control"
                       x-model="form.client_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cargo / Posicion</label>
                <input type="text" name="client_position" class="form-control"
                       x-model="form.client_position">
            </div>
            <div class="mb-3">
                <label class="form-label">Testimonio <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control" rows="4"
                          x-model="form.content" required></textarea>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select" x-model="form.rating">
                        <option value="">Sin rating</option>
                        <option value="1">1 estrella</option>
                        <option value="2">2 estrellas</option>
                        <option value="3">3 estrellas</option>
                        <option value="4">4 estrellas</option>
                        <option value="5">5 estrellas</option>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Orden</label>
                    <input type="number" name="sort_order" class="form-control"
                           x-model="form.sort_order">
                </div>
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
