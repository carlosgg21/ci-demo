/**
 * Currency page — extends crudPage base component.
 * Only defines config specific to currencies.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.CurrencyPageConfig ?? {};

    Alpine.data('currencyPage', () => crudPage({
        tableId:    'currencyTable',
        baseUrl:    cfg.baseUrl || '/currencies',
        apiBaseUrl: cfg.apiBaseUrl || '/api/v1/currencies',
        statusCol:  4,
        actionCol:  5,
        statusField: 'status',
        entityName: { singular: 'moneda', singularUpper: 'Moneda' },
        formDefaults: {
            id: null, acronym: '', name: '', sign: '',
            iso_numeric: '', internal_code: '', flag: '', status: 'active',
        },
    }));
});
