/**
 * Service Type page — extends crudPage.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.ServiceTypePageConfig ?? {};

    Alpine.data('serviceTypePage', () => crudPage({
        tableId:     'serviceTypeTable',
        baseUrl:     cfg.baseUrl || '/service-types',
        apiBaseUrl:  cfg.apiBaseUrl || '/api/v1/service-types',
        statusCol:   3,
        actionCol:   4,
        statusField: 'is_active',
        entityName:  { singular: 'tipo de servicio', singularUpper: 'Tipo de Servicio' },
        formDefaults: {
            id: null, denomination: '', description: '', is_active: 1,
        },
    }));
});
