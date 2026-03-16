/**
 * Locale page — extends crudPage.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.LocalePageConfig ?? {};

    Alpine.data('localePage', () => ({
        ...crudPage({
            tableId:     'localeTable',
            baseUrl:     cfg.baseUrl  || '/locales',
            apiBaseUrl:  cfg.apiBaseUrl || '/api/v1/locales',
            statusCol:   4,
            actionCol:   5,
            statusField: 'is_active',
            entityName:  { singular: 'idioma', singularUpper: 'Idioma' },
            formDefaults: {
                id: null, code: '', name: '', is_default: 0, is_active: 1,
            },
        }),
    }));
});
