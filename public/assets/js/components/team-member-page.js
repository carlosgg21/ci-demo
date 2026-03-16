/**
 * Team Member page — extends crudPage + translateDrawer.
 */
document.addEventListener('alpine:init', () => {
    const cfg = window.TeamMemberPageConfig ?? {};

    Alpine.data('teamMemberPage', () => ({
        ...crudPage({
            tableId:     'teamMemberTable',
            baseUrl:     cfg.baseUrl || '/team-members',
            apiBaseUrl:  cfg.apiBaseUrl || '/api/v1/team-members',
            statusCol:   5,
            actionCol:   6,
            statusField: 'is_active',
            entityName:  { singular: 'miembro', singularUpper: 'Miembro' },
            formDefaults: {
                id: null, name: '', position: '', bio: '',
                email: '', phone: '', sort_order: 0, is_active: 1,
            },
        }),
        ...translateDrawer({
            apiBaseUrl:      cfg.apiBaseUrl || '/api/v1/team-members',
            locales:         cfg.locales || [],
            fields:          cfg.translatableFields || ['name', 'position', 'bio'],
            labels:          cfg.translatableLabels || { name: 'Nombre', position: 'Cargo', bio: 'Biografia' },
            textareaFields:  ['bio'],
        }),
    }));
});
