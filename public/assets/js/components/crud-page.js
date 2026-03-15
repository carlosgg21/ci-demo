/**
 * crudPage — Reusable Alpine.js component for CRUD listing pages.
 *
 * Handles: Simple-DataTables init, status filter, drawer, toggle status, delete.
 *
 * Usage:
 *   Alpine.data('myPage', () => crudPage({ tableId: '...', baseUrl: '...', ... }))
 *
 * Required config:
 *   tableId      - id of the <table> element
 *   baseUrl      - web URL for the resource (e.g. '/currencies')
 *   apiBaseUrl   - API URL for the resource (e.g. '/api/v1/currencies')
 *   formDefaults - default form values for create mode
 *   statusCol    - column index (0-based) that contains the status badge
 *   actionCol    - column index (0-based) for the actions column (non-sortable)
 *   entityName   - { singular: 'moneda', singularUpper: 'Moneda' } for UI labels
 *
 * Optional config:
 *   statusField   - 'status' (default) or 'is_active' — determines API payload shape
 *   activeLabel   - label text for active status (default: 'Activo')
 *   inactiveLabel - label text for inactive status (default: 'Inactivo')
 *   perPage       - default rows per page (default: 10)
 *   defaultFilter - default status filter on load (default: 'active')
 *   topButtons    - array of { html, onClick? } for extra buttons in datatable-top
 */
function crudPage(config) {
    const defaults = {
        statusField:   'status',
        activeLabel:   'Activo',
        inactiveLabel: 'Inactivo',
        perPage:       10,
        defaultFilter: 'active',
        topButtons:    [],
    };
    const cfg = { ...defaults, ...config };

    return {
        // --- State ---
        drawerOpen:   false,
        filtersOpen:  false,
        statusFilter: cfg.defaultFilter,
        mode:         'create',
        dataTable:    null,
        _allRows:     [],
        _dtConfig:    null,
        form:         { ...cfg.formDefaults },

        // --- Lifecycle ---
        init() {
            this.$watch('drawerOpen', val => {
                document.body.style.overflow = val ? 'hidden' : '';
            });
            this.initDataTable();
        },

        // --- Simple-DataTables ---
        initDataTable() {
            const table = document.getElementById(cfg.tableId);
            if (!table || !table.querySelector('tbody tr td:not([colspan])')) return;

            // Save all original rows
            this._allRows = [];
            table.querySelectorAll('tbody tr').forEach(tr => {
                const badge = tr.querySelector('.badge');
                const text = badge?.textContent.trim() || '';
                const status = text === cfg.activeLabel ? 'active' : 'inactive';
                this._allRows.push({ el: tr.cloneNode(true), status });
            });

            this._dtConfig = {
                perPage: cfg.perPage,
                perPageSelect: [5, 10, 25, 50],
                searchable: true,
                sortable: true,
                fixedHeight: false,
                labels: {
                    placeholder: 'Buscar...',
                    perPage: 'registros por página',
                    noRows: 'No se encontraron registros',
                    noResults: 'No hay coincidencias para tu búsqueda',
                    info: 'Mostrando {start} a {end} de {rows} registros',
                },
                columns: [
                    { select: cfg.actionCol, sortable: false },
                ],
            };

            // Apply default filter before first init
            this._rebuildTableRows(this.statusFilter);

            this.dataTable = new simpleDatatables.DataTable(table, this._dtConfig);
            this._setupDatatableUI();
        },

        _rebuildTableRows(status) {
            const table = document.getElementById(cfg.tableId);
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = '';

            const matching = this._allRows.filter(
                item => status === 'all' || item.status === status
            );

            if (matching.length === 0) {
                const colCount = table.querySelectorAll('thead th').length;
                tbody.innerHTML = `<tr><td colspan="${colCount}"><div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h6>Sin resultados</h6>
                    <p class="small">No hay registros con este filtro.</p>
                </div></td></tr>`;
                return false;
            }

            matching.forEach(item => tbody.appendChild(item.el.cloneNode(true)));
            return true;
        },

        _setupDatatableUI() {
            const table = document.getElementById(cfg.tableId);
            const wrapper = table.closest('.datatable-wrapper');
            if (!wrapper) return;

            // Move per-page dropdown to bottom
            const dropdown = wrapper.querySelector('.datatable-top .datatable-dropdown');
            const bottom = wrapper.querySelector('.datatable-bottom');
            if (dropdown && bottom) bottom.prepend(dropdown);

            // Inject action buttons
            const top = wrapper.querySelector('.datatable-top');
            if (top && !top.querySelector('.datatable-actions')) {
                const actions = document.createElement('div');
                actions.className = 'datatable-actions';

                // Filter button
                let html = `<button class="btn btn-filter btn-sm ${this.filtersOpen ? 'active' : ''}" data-action="filter">
                    <i class="bi bi-funnel me-1"></i>Filtros
                </button>`;

                // Extra buttons from config
                cfg.topButtons.forEach(btn => { html += btn.html; });

                // Create button
                html += `<button class="btn btn-primary btn-sm" data-action="create">
                    <i class="bi bi-plus-lg me-1"></i>Nuevo
                </button>`;

                actions.innerHTML = html;
                top.appendChild(actions);

                actions.querySelector('[data-action="create"]')
                    .addEventListener('click', () => this.openCreate());

                actions.querySelector('[data-action="filter"]')
                    .addEventListener('click', (e) => {
                        this.filtersOpen = !this.filtersOpen;
                        e.currentTarget.classList.toggle('active', this.filtersOpen);
                    });

                // Bind extra button callbacks
                cfg.topButtons.forEach(btn => {
                    if (btn.action && btn.onClick) {
                        const el = actions.querySelector(`[data-action="${btn.action}"]`);
                        if (el) el.addEventListener('click', btn.onClick);
                    }
                });
            }
        },

        // --- Filter by status (client-side) ---
        applyStatusFilter(status) {
            this.statusFilter = status;

            if (this.dataTable) {
                this.dataTable.destroy();
                this.dataTable = null;
            }

            const table = document.getElementById(cfg.tableId);
            const hasRows = this._rebuildTableRows(status);

            if (hasRows) {
                this.dataTable = new simpleDatatables.DataTable(table, this._dtConfig);
                this._setupDatatableUI();
            }
        },

        // --- Computed ---
        get formAction() {
            return this.mode === 'edit'
                ? cfg.baseUrl + '/' + this.form.id
                : cfg.baseUrl;
        },

        // --- Drawer ---
        openCreate() {
            this.mode = 'create';
            this.form = { ...cfg.formDefaults };
            this.drawerOpen = true;
            this.$nextTick(() => {
                const firstInput = this.$refs.drawerBody?.querySelector('input:not([type=hidden])');
                firstInput?.focus();
            });
        },

        openEdit(data) {
            this.mode = 'edit';
            this.form = { ...data };
            this.drawerOpen = true;
        },

        // --- Delete ---
        async confirmDelete(id, name) {
            const ok = await confirmAction({
                title:       `¿Eliminar ${cfg.entityName.singular}?`,
                message:     `Se eliminará ${name}. Esta acción no se puede deshacer.`,
                confirmText: 'Eliminar',
                icon:        'bi-exclamation-triangle-fill text-danger',
            });
            if (!ok) return;

            const form = document.createElement('form');
            form.method = 'post';
            form.action = cfg.baseUrl + '/' + id;
            form.innerHTML = `
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="csrf_test_name"
                       value="${document.querySelector('meta[name=X-CSRF-TOKEN]')?.content || ''}">
            `;
            document.body.appendChild(form);
            form.submit();
        },

        // --- Toggle Status ---
        async toggleStatus(id, event) {
            const badge   = event.target;
            const row     = badge.closest('tr');
            const current = badge.textContent.trim();
            const next    = current === cfg.activeLabel ? 'inactivo' : 'activo';
            const name    = row.querySelector('.fw-semibold')?.textContent || '';

            const ok = await confirmAction({
                title:        '¿Cambiar estado?',
                message:      `${name} pasará a ${next}.`,
                confirmText:  'Sí, cambiar',
                confirmClass: 'btn-primary',
                icon:         'bi-arrow-repeat text-primary',
            });
            if (!ok) return;

            try {
                const res = await fetch(cfg.apiBaseUrl + '/' + id + '/toggle-status', {
                    method: 'PATCH',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content || '',
                    },
                });
                if (!res.ok) throw new Error('Error al cambiar estado');
                const json = await res.json();

                // Determine new status from response (supports both 'status' and 'is_active')
                let newIsActive;
                if (cfg.statusField === 'is_active') {
                    newIsActive = json.data.is_active === 1 || json.data.is_active === true;
                } else {
                    newIsActive = json.data.status === 'active';
                }

                const labelDone = newIsActive ? 'activado' : 'desactivado';

                // Update internal row data
                const rowItem = this._allRows.find(item => {
                    const idCell = item.el.querySelector('td');
                    return idCell && idCell.textContent.trim() === String(id);
                });
                if (rowItem) {
                    rowItem.status = newIsActive ? 'active' : 'inactive';
                    const rowBadge = rowItem.el.querySelector('.badge');
                    if (rowBadge) {
                        rowBadge.className = newIsActive
                            ? 'badge bg-success-subtle text-success'
                            : 'badge bg-danger-subtle text-danger';
                        rowBadge.textContent = newIsActive ? cfg.activeLabel : cfg.inactiveLabel;
                    }
                }

                // If filter doesn't match new status, fade out row
                if (this.statusFilter !== 'all' && this.statusFilter !== (newIsActive ? 'active' : 'inactive')) {
                    row.style.transition = 'opacity .3s';
                    row.style.opacity = '0';
                    setTimeout(() => this.applyStatusFilter(this.statusFilter), 300);
                } else {
                    badge.className = newIsActive
                        ? 'badge bg-success-subtle text-success'
                        : 'badge bg-danger-subtle text-danger';
                    badge.textContent = newIsActive ? cfg.activeLabel : cfg.inactiveLabel;
                }

                showToast(`${name} ${labelDone} exitosamente`);
            } catch (err) {
                showToast('Error al cambiar estado', 'error');
            }
        },
    };
}
