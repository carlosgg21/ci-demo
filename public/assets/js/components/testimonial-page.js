/**
 * Testimonial page — extends crudPage + translateDrawer.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.TestimonialPageConfig ?? {};

    Alpine.data('testimonialPage', () => ({
        ...crudPage({
            tableId:     'testimonialTable',
            baseUrl:     cfg.baseUrl || '/testimonials',
            apiBaseUrl:  cfg.apiBaseUrl || '/api/v1/testimonials',
            statusCol:   5,
            actionCol:   6,
            statusField: 'is_active',
            entityName:  { singular: 'testimonio', singularUpper: 'Testimonio' },
            formDefaults: {
                id: null, client_name: '', client_position: '', content: '',
                rating: '', sort_order: 0, is_active: 1,
            },
        }),
        ...translateDrawer({
            apiBaseUrl:      cfg.apiBaseUrl || '/api/v1/testimonials',
            locales:         cfg.locales || [],
            fields:          cfg.translatableFields || ['client_name', 'client_position', 'content'],
            labels:          cfg.translatableLabels || { client_name: 'Nombre del cliente', client_position: 'Cargo', content: 'Testimonio' },
            textareaFields:  ['content'],
        }),
    }));
});
