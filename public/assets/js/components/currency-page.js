/**
 * Alpine component: currencyPage
 *
 * Requires window.CurrencyPageConfig set by the view:
 *   { filtersOpen: bool, baseUrl: string }
 *
 * Requires: utils/fetch-partial.js loaded before this file.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.CurrencyPageConfig ?? { filtersOpen: false, baseUrl: '/currencies' };

    Alpine.data('currencyPage', () => ({

        // --- State ---
        drawerOpen:  false,
        filtersOpen: cfg.filtersOpen,
        loading:     false,
        mode:        'create',
        form: {
            id: null, acronym: '', name: '', sign: '',
            iso_numeric: '', internal_code: '', flag: '', status: 'active',
        },
        deleteId:   null,
        deleteName: '',

        // --- Lifecycle ---
        init() {
            this.$watch('drawerOpen', val => {
                document.body.style.overflow = val ? 'hidden' : '';
            });
            this.bindPager();
            this.bindForms();
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
            this.form = { id: null, acronym: '', name: '', sign: '', iso_numeric: '', internal_code: '', flag: '', status: 'active' };
            this.drawerOpen = true;
            this.$nextTick(() => this.$refs.acronymInput?.focus());
        },

        openEdit(data) {
            this.mode = 'edit';
            this.form = { ...data };
            this.drawerOpen = true;
        },

        // --- Delete ---
        confirmDelete(id, name) {
            this.deleteId   = id;
            this.deleteName = name;
            bootstrap.Modal.getOrCreateInstance(this.$refs.modalDelete).show();
        },

        // --- Search & Filters AJAX ---
        bindForms() {
            // Search: intercept submit
            document.querySelector('.crud-search form')
                ?.addEventListener('submit', e => {
                    e.preventDefault();
                    this.submitForm(e.target);
                });

            // Filter select: intercept change
            document.querySelector('.filter-panel select[name="status"]')
                ?.addEventListener('change', e => {
                    this.submitForm(e.target.closest('form'));
                });

            // Clear links (search X + filter "Limpiar")
            document.querySelectorAll('.crud-search a[href], .filter-panel a[href]')
                .forEach(a => a.addEventListener('click', e => {
                    e.preventDefault();
                    this.goToPage(a.href);
                }));
        },

        submitForm(form) {
            const url = new URL(form.action);
            url.search = '';
            new FormData(form).forEach((val, key) => {
                if (val !== '') url.searchParams.set(key, val);
            });
            this.goToPage(url.toString());
        },

        // --- Pagination AJAX ---
        bindPager() {
            this.$nextTick(() => {
                this.$refs.tableCard?.querySelectorAll('.card-footer .page-link').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        this.goToPage(link.href);
                    });
                });
            });
        },

        async goToPage(url) {
            this.loading = true;
            try {
                const card = await fetchPartial(url, '.card.table-card');
                if (card) {
                    this.$refs.tableCard.innerHTML = card.innerHTML;
                    history.pushState({}, '', url);
                    this.bindPager();
                }
            } finally {
                this.loading = false;
            }
        },
    }));
});
