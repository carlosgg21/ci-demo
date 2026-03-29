/**
 * Service page — extends crudPage + translateDrawer.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.ServicePageConfig ?? {};

    Alpine.data('servicePage', () => ({
        ...crudPage({
            tableId:     'serviceTable',
            baseUrl:     cfg.baseUrl || '/services',
            apiBaseUrl:  cfg.apiBaseUrl || '/api/v1/services',
            statusCol:   5,
            actionCol:   6,
            statusField: 'is_active',
            entityName:  { singular: 'servicio', singularUpper: 'Servicio' },
            formDefaults: {
                id: null, service_type_id: '', name: '', slug: '', description: '',
                icon: '', image: '', sort_order: 0, is_active: 1,
            },
        }),
        ...translateDrawer({
            apiBaseUrl:      cfg.apiBaseUrl || '/api/v1/services',
            locales:         cfg.locales || [],
            fields:          cfg.translatableFields || ['name', 'description'],
            labels:          cfg.translatableLabels || { name: 'Nombre', description: 'Descripcion' },
            textareaFields:  ['description'],
        }),
    }));
});
