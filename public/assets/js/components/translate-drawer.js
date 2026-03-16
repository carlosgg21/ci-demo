/**
 * translateDrawer — Reusable Alpine.js mixin for the translate drawer.
 *
 * Usage in a page component:
 *   Alpine.data('myPage', () => ({
 *       ...crudPage({ ... }),
 *       ...translateDrawer({
 *           apiBaseUrl: '/api/v1/services',
 *           locales: [...],
 *           fields: ['name', 'description'],
 *           labels: { name: 'Nombre', description: 'Descripcion' },
 *           textareaFields: ['description'],
 *       }),
 *   }));
 */
function translateDrawer(config) {
    const locales = config.locales || [];
    const fields  = config.fields || [];
    const labels  = config.labels || {};
    const textareaFields = config.textareaFields || [];

    function emptyTransForm() {
        const t = {};
        locales.forEach(l => {
            t[l.code] = {};
            fields.forEach(f => t[l.code][f] = '');
        });
        return t;
    }

    function mergeTransForm(saved) {
        const base = emptyTransForm();
        if (!saved || typeof saved !== 'object') return base;
        for (const code in base) {
            if (saved[code]) {
                for (const field of fields) {
                    base[code][field] = saved[code][field] || '';
                }
            }
        }
        return base;
    }

    return {
        // State
        transDrawerOpen: false,
        transActiveTab:  locales.length > 0 ? locales[0].code : '',
        transEntityId:   null,
        transEntityName: '',
        transForm:       emptyTransForm(),
        transDefaults:   {},
        transSaving:     false,

        // Config exposed to template
        transLocales:        locales,
        transFields:         fields,
        transLabels:         labels,
        transTextareaFields: textareaFields,

        /**
         * Open the translate drawer for a specific entity.
         * @param {Object} data - Entity data including id, translatable field values, and translations
         * @param {string} name - Display name for the drawer title
         */
        openTranslate(data, name) {
            this.transEntityId   = data.id;
            this.transEntityName = name || '';
            this.transActiveTab  = locales.length > 0 ? locales[0].code : '';

            // Set default language values as reference
            this.transDefaults = {};
            fields.forEach(f => {
                this.transDefaults[f] = data[f] || '';
            });

            // Merge saved translations
            this.transForm = mergeTransForm(data.translations);
            this.transDrawerOpen = true;
        },

        /**
         * Tab dot color based on completeness.
         */
        getTransTabDotClass(code) {
            const t = this.transForm?.[code];
            if (!t) return 'empty';
            const filled = fields.filter(f => t[f] && t[f].trim() !== '').length;
            if (filled === fields.length) return 'complete';
            if (filled > 0) return 'partial';
            return 'empty';
        },

        /**
         * Save translations via API.
         */
        async saveTranslations() {
            this.transSaving = true;
            try {
                const res = await fetch(
                    config.apiBaseUrl + '/' + this.transEntityId + '/translations',
                    {
                        method: 'PATCH',
                        headers: {
                            'Content-Type':     'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN':     document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content || '',
                        },
                        body: JSON.stringify({ translations: this.transForm }),
                    }
                );

                if (!res.ok) throw new Error('Error al guardar traducciones');

                showToast('Traducciones guardadas exitosamente');
                this.transDrawerOpen = false;
            } catch (err) {
                showToast('Error al guardar traducciones', 'error');
            } finally {
                this.transSaving = false;
            }
        },
    };
}
