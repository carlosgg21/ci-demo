<!-- Drawer Traducir — Componente reutilizable -->
<div class="drawer-overlay" :class="{ 'show': transDrawerOpen }" @click="transDrawerOpen = false"></div>
<div class="drawer" :class="{ 'show': transDrawerOpen }">
    <div class="drawer-header">
        <h5>
            <i class="bi bi-translate me-2"></i>Traducir
            <span class="text-muted fw-normal ms-1" x-text="transEntityName"></span>
        </h5>
        <button class="drawer-close" @click="transDrawerOpen = false"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="drawer-body" x-ref="transDrawerBody">

        <!-- Referencia: valores en idioma default -->
        <div class="trans-reference-card mb-3">
            <div class="trans-reference-title">
                <i class="bi bi-eye me-1"></i> ES (referencia)
            </div>
            <template x-for="field in transFields" :key="'ref-' + field">
                <div class="trans-reference-item">
                    <span class="trans-reference-label" x-text="transLabels[field] || field"></span>
                    <span class="trans-reference-value"
                          :class="{ 'empty': !transDefaults[field] }"
                          x-text="transDefaults[field] || 'Sin contenido'"></span>
                </div>
            </template>
        </div>

        <!-- Tabs de idiomas secundarios -->
        <template x-if="transLocales.length > 0">
            <div class="trans-tabs">
                <div class="trans-tabs-nav">
                    <template x-for="locale in transLocales" :key="locale.code">
                        <button type="button" class="trans-tab-btn"
                                :class="{ active: transActiveTab === locale.code }"
                                @click="transActiveTab = locale.code">
                            <span x-text="locale.code.toUpperCase()"></span>
                            <span class="tab-dot" :class="getTransTabDotClass(locale.code)"></span>
                        </button>
                    </template>
                </div>

                <template x-for="locale in transLocales" :key="'panel-' + locale.code">
                    <div class="trans-tab-panel" x-show="transActiveTab === locale.code">
                        <template x-for="field in transFields" :key="locale.code + '-' + field">
                            <div class="mb-3">
                                <label class="form-label" x-text="transLabels[field] || field"></label>
                                <template x-if="transTextareaFields.includes(field)">
                                    <textarea class="form-control" rows="3"
                                              x-model="transForm[locale.code][field]"
                                              :placeholder="transDefaults[field] || ''"></textarea>
                                </template>
                                <template x-if="!transTextareaFields.includes(field)">
                                    <input type="text" class="form-control"
                                           x-model="transForm[locale.code][field]"
                                           :placeholder="transDefaults[field] || ''">
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>

    </div>
    <div class="drawer-footer">
        <button type="button" class="btn btn-outline-secondary" @click="transDrawerOpen = false">Cancelar</button>
        <button type="button" class="btn btn-primary" @click="saveTranslations()" :disabled="transSaving">
            <span x-show="!transSaving">
                <i class="bi bi-check-lg me-1"></i>Guardar traducciones
            </span>
            <span x-show="transSaving">
                <span class="spinner-border spinner-border-sm me-1"></span>Guardando...
            </span>
        </button>
    </div>
</div>
