<!-- Drawer Crear/Editar Idioma -->
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nuevo Idioma' : 'Editar Idioma'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <div class="drawer-body" x-ref="drawerBody">

            <div class="row g-3">
                <div class="col-4">
                    <label class="form-label">Código <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control text-uppercase"
                           x-model="form.code"
                           placeholder="ej. en"
                           maxlength="10"
                           required>
                    <div class="form-text">ISO 639-1 (2 letras)</div>
                </div>
                <div class="col-8">
                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           x-model="form.name"
                           placeholder="ej. English"
                           required>
                </div>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Estado</label>
                <select name="is_active" class="form-select" x-model="form.is_active">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_default"
                           id="is_default" value="1"
                           :checked="form.is_default == 1"
                           @change="form.is_default = $event.target.checked ? 1 : 0">
                    <label class="form-check-label" for="is_default">
                        Idioma principal (por defecto)
                    </label>
                </div>
                <div class="form-text text-warning">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Solo puede haber un idioma principal. Sus contenidos se guardan en las columnas base.
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
