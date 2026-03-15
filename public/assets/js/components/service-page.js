/**
 * Service page — extends crudPage base component.
 * Only defines config specific to services.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.ServicePageConfig ?? {};

    Alpine.data('servicePage', () => crudPage({
        tableId:     'serviceTable',
        baseUrl:     cfg.baseUrl || '/services',
        apiBaseUrl:  cfg.apiBaseUrl || '/api/v1/services',
        statusCol:   5,
        actionCol:   6,
        statusField: 'is_active',
        entityName:  { singular: 'servicio', singularUpper: 'Servicio' },
        formDefaults: {
            id: null, name: '', slug: '', description: '',
            icon: '', image: '', sort_order: 0, is_active: 1,
        },
    }));
});
