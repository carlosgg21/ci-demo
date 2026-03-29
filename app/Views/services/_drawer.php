<!-- Drawer Crear/Editar Servicio -->
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nuevo Servicio' : 'Editar Servicio'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <div class="drawer-body" x-ref="drawerBody">
            <div class="mb-3">
                <label class="form-label">Tipo de Servicio</label>
                <select name="service_type_id" class="form-select" x-model="form.service_type_id">
                    <option value="">— Sin tipo —</option>
                    <?php foreach ($serviceTypes ?? [] as $id => $denomination): ?>
                        <option value="<?= $id ?>"><?= esc($denomination) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control"
                       x-model="form.name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" class="form-control"
                       x-model="form.slug" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <textarea name="description" class="form-control" rows="3"
                          x-model="form.description"></textarea>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Icono</label>
                    <input type="text" name="icon" class="form-control"
                           x-model="form.icon" placeholder="ej. bi bi-gear">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Orden</label>
                    <input type="number" name="sort_order" class="form-control"
                           x-model="form.sort_order">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen URL</label>
                <input type="url" name="image" class="form-control"
                       x-model="form.image" placeholder="https://...">
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
