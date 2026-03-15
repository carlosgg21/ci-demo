/**
 * Global toast notification utility.
 * Uses #toast-container (top-right, in layout).
 *
 * Usage:
 *   showToast('Moneda actualizada');                    // success (default)
 *   showToast('Algo salió mal', 'error');               // error
 *   showToast('Cuidado', 'warning');                    // warning
 *   showToast('Info aquí', 'info');                     // info
 */
(function () {
    const icons = {
        success: 'bi-check-circle-fill',
        error:   'bi-x-circle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info:    'bi-info-circle-fill',
    };

    const colors = {
        success: 'text-success',
        error:   'text-danger',
        warning: 'text-warning',
        info:    'text-primary',
    };

    window.showToast = function (message, type = 'success', delay = 3500) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const id = 'toast-' + Date.now();
        const html = `
            <div id="${id}" class="toast align-items-center border-0 shadow-sm app-toast" role="alert">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="bi ${icons[type] || icons.info} ${colors[type] || colors.info}" style="font-size:1.1rem;"></i>
                        <span>${message}</span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>`;

        container.insertAdjacentHTML('beforeend', html);

        const el = document.getElementById(id);

        // Animate in
        requestAnimationFrame(() => el.classList.add('show'));

        // Auto-hide after delay
        const hideTimer = setTimeout(() => dismiss(), delay);

        // Manual dismiss via close button
        el.querySelector('.btn-close').addEventListener('click', () => {
            clearTimeout(hideTimer);
            dismiss();
        });

        function dismiss() {
            el.classList.remove('show');
            el.classList.add('hiding');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
            // Fallback removal if transitionend doesn't fire
            setTimeout(() => el.remove(), 500);
        }
    };
})();
