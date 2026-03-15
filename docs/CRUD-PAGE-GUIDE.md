# CRUD Page — Guia de Integracion

Sistema reutilizable para paginas CRUD con DataTable, filtros, drawer y toggle de estado.

**Stack:** Bootstrap 5 + Alpine.js + Simple-DataTables + CodeIgniter 4

---

## Arquitectura

```
Componente base (JS)          Vista (PHP)              Config (JS)
crud-page.js          →  modulo/index.php       ←  modulo-page.js
(DataTable, filtros,      (tabla, drawer,            (URLs, columnas,
 drawer, delete,           filter-panel)              campos del form)
 toggleStatus)
```

Cada nuevo modulo necesita **3 archivos** + ajustes en controller/routes:

| Archivo | Lineas aprox | Que contiene |
|---------|-------------|--------------|
| `assets/js/components/X-page.js` | ~15 | Config del modulo |
| `Views/X/index.php` | ~80 | Tabla + filter panel + include drawer |
| `Views/X/_drawer.php` | ~40 | Campos del formulario |

---

## Paso a paso: Agregar un nuevo modulo

### 1. JS Config (`public/assets/js/components/mi-modulo-page.js`)

```js
document.addEventListener('alpine:init', () => {
    const cfg = window.MiModuloPageConfig ?? {};

    Alpine.data('miModuloPage', () => crudPage({
        // REQUERIDOS
        tableId:    'miModuloTable',           // id del <table>
        baseUrl:    cfg.baseUrl,               // URL web: /mi-modulo
        apiBaseUrl: cfg.apiBaseUrl,            // URL API: /api/v1/mi-modulo
        statusCol:  3,                         // indice columna Estado (0-based)
        actionCol:  4,                         // indice columna acciones (0-based)
        entityName: {
            singular: 'elemento',              // para mensajes: "Eliminar elemento?"
            singularUpper: 'Elemento',
        },
        formDefaults: {                        // valores por defecto al crear
            id: null, name: '', status: 'active',
        },

        // OPCIONALES
        statusField:   'status',               // 'status' (string) o 'is_active' (int 0/1)
        activeLabel:   'Activo',               // texto del badge activo
        inactiveLabel: 'Inactivo',             // texto del badge inactivo
        perPage:       10,                     // filas por pagina
        defaultFilter: 'active',               // filtro inicial: 'active', 'inactive', 'all'
    }));
});
```

### 2. Vista principal (`app/Views/mi-modulo/index.php`)

```php
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div x-data="miModuloPage" @keydown.escape.window="drawerOpen = false">

<!-- Panel de filtros (siempre igual, solo cambia x-ref) -->
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

<!-- Tabla: cambiar id, columnas y filas -->
<div class="card table-card">
    <table id="miModuloTable" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Campo2</th>
                <th>Estado</th>                        <!-- statusCol = 3 -->
                <th data-sortable="false" width="50"></th> <!-- actionCol = 4 -->
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td class="text-muted small"><?= $item->id ?></td>
                <td><span class="fw-semibold"><?= esc($item->name) ?></span></td>
                <td><?= esc($item->campo2) ?></td>
                <td>
                    <!-- Badge de estado (el texto DEBE coincidir con activeLabel/inactiveLabel) -->
                    <span class="badge <?= $item->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"
                          role="button" style="cursor:pointer;"
                          @click="toggleStatus(<?= $item->id ?>, $event)">
                        <?= $item->status === 'active' ? 'Activo' : 'Inactivo' ?>
                    </span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button type="button" class="dropdown-item"
                                        @click="openEdit(<?= esc(json_encode([
                                            'id'     => $item->id,
                                            'name'   => $item->name,
                                            'campo2' => $item->campo2,
                                            'status' => $item->status,
                                        ]), 'attr') ?>)">
                                    <i class="bi bi-pencil me-2 text-muted"></i>Editar
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger"
                                        @click="confirmDelete(<?= $item->id ?>, '<?= esc($item->name) ?>')">
                                    <i class="bi bi-trash me-2"></i>Eliminar
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('mi-modulo/_drawer') ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    window.MiModuloPageConfig = {
        baseUrl:    '<?= base_url('mi-modulo') ?>',
        apiBaseUrl: '<?= base_url('api/v1/mi-modulo') ?>',
    };
</script>
<script src="<?= base_url('assets/js/components/mi-modulo-page.js') ?>"></script>
<?= $this->endSection() ?>
```

### 3. Drawer (`app/Views/mi-modulo/_drawer.php`)

```php
<div class="drawer-overlay" :class="{ 'show': drawerOpen }" @click="drawerOpen = false"></div>
<div class="drawer" :class="{ 'show': drawerOpen }">
    <div class="drawer-header">
        <h5 x-text="mode === 'create' ? 'Nuevo Elemento' : 'Editar Elemento'"></h5>
        <button class="drawer-close" @click="drawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <form :action="formAction" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" :value="mode === 'edit' ? 'PUT' : ''">
        <div class="drawer-body" x-ref="drawerBody">
            <!-- Tus campos aqui -->
            <div class="mb-3">
                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" x-model="form.name" required>
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
```

### 4. Controller (cambios minimos)

```php
public function index(): string
{
    return view('mi-modulo/index', [
        'title'      => 'Listado de Elementos',
        'pageTitle'  => 'Elementos',
        'breadcrumb' => ['Seccion' => null, 'Elementos' => null],
        'items'      => $this->repository->getAll(),  // cargar TODOS (client-side)
        'stats'      => $this->repository->getStats(),
    ]);
}
```

### 5. API Route (para toggle-status)

En `app/Config/Routes/Api.php`:

```php
$routes->patch('mi-modulo/(:num)/toggle-status', 'MiModuloController::toggleStatus/$1');
```

### 6. API Controller (metodo toggleStatus)

```php
public function toggleStatus(int $id): ResponseInterface
{
    $item = $this->repository->getById($id);
    if (!$item) throw new ResourceNotFoundException('No encontrado');

    // Para statusField = 'status' (string):
    $newStatus = $item->status === 'active' ? 'inactive' : 'active';
    $this->repository->changeStatus($id, $newStatus);
    return $this->respond(ApiResponse::success(['status' => $newStatus]));

    // Para statusField = 'is_active' (int):
    // $newActive = !$item->is_active;
    // $this->repository->changeStatus($id, $newActive);
    // return $this->respond(ApiResponse::success(['is_active' => $newActive ? 1 : 0]));
}
```

---

## Modelos con `status` (string) vs `is_active` (int)

| Patron | Config JS | Badge PHP | API Response |
|--------|-----------|-----------|-------------|
| `status = 'active'/'inactive'` | `statusField: 'status'` | `$item->status === 'active'` | `{ status: 'active' }` |
| `is_active = 1/0` | `statusField: 'is_active'` | `$item->is_active ? ...` | `{ is_active: 1 }` |

El componente base maneja ambos automaticamente.

---

## Referencia rapida: Config de crudPage

| Propiedad | Tipo | Default | Descripcion |
|-----------|------|---------|-------------|
| `tableId` | string | **requerido** | ID del elemento `<table>` |
| `baseUrl` | string | **requerido** | URL web del recurso |
| `apiBaseUrl` | string | **requerido** | URL API del recurso |
| `statusCol` | int | **requerido** | Indice de columna del badge de estado |
| `actionCol` | int | **requerido** | Indice de columna de acciones |
| `entityName` | object | **requerido** | `{ singular, singularUpper }` |
| `formDefaults` | object | **requerido** | Valores default del form |
| `statusField` | string | `'status'` | Campo del API: `'status'` o `'is_active'` |
| `activeLabel` | string | `'Activo'` | Texto del badge activo |
| `inactiveLabel` | string | `'Inactivo'` | Texto del badge inactivo |
| `perPage` | int | `10` | Filas por pagina |
| `defaultFilter` | string | `'active'` | Filtro inicial |
| `topButtons` | array | `[]` | Botones extra en el top bar |

---

## Metodos disponibles en la vista (Alpine)

Todos estos metodos estan disponibles dentro del `x-data`:

- `openCreate()` — abre drawer en modo crear
- `openEdit(data)` — abre drawer en modo editar con datos
- `confirmDelete(id, name)` — confirma y elimina
- `toggleStatus(id, event)` — cambia estado via API
- `applyStatusFilter(status)` — filtra tabla ('all', 'active', 'inactive')

---

## Ejemplo real: Currencies vs Services

### Currencies (15 lineas de JS config)

```js
Alpine.data('currencyPage', () => crudPage({
    tableId: 'currencyTable',
    statusCol: 4, actionCol: 5,
    statusField: 'status',
    entityName: { singular: 'moneda', singularUpper: 'Moneda' },
    formDefaults: { id: null, acronym: '', name: '', sign: '', ... },
    ...urls
}));
```

### Services (15 lineas de JS config)

```js
Alpine.data('servicePage', () => crudPage({
    tableId: 'serviceTable',
    statusCol: 4, actionCol: 5,
    statusField: 'is_active',
    entityName: { singular: 'servicio', singularUpper: 'Servicio' },
    formDefaults: { id: null, slug: '', icon: '', sort_order: 0, ... },
    ...urls
}));
```

Misma funcionalidad, diferente modelo. Solo cambia la config.
