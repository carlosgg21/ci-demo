/**
 * Global confirm modal — simple Sí / No.
 * Requires #globalConfirmModal in the layout.
 *
 * Usage:
 *   if (await confirmAction({ title: '¿Seguro?', message: 'Detalle...' })) { ... }
 */
(function () {
    window.confirmAction = function ({
        title        = '¿Estás seguro?',
        message      = '',
        confirmText  = 'Sí',
        confirmClass = 'btn-danger',
        cancelText   = 'No',
        icon         = 'bi-exclamation-triangle-fill text-warning',
    } = {}) {
        return new Promise((resolve) => {
            const modal = document.getElementById('globalConfirmModal');
            if (!modal) { resolve(false); return; }

            // Populate content
            modal.querySelector('.confirm-icon').className = 'confirm-icon bi ' + icon;
            modal.querySelector('.confirm-icon').style.fontSize = '2.5rem';
            modal.querySelector('.confirm-title').textContent = title;
            modal.querySelector('.confirm-message').textContent = message;

            // Clone OK button to strip all previous listeners
            const oldBtn = modal.querySelector('.confirm-btn-ok');
            const btnOk  = oldBtn.cloneNode(true);
            btnOk.textContent = confirmText;
            btnOk.className   = 'btn btn-sm confirm-btn-ok ' + confirmClass;
            oldBtn.replaceWith(btnOk);

            modal.querySelector('.confirm-btn-cancel').textContent = cancelText;

            const bsModal = bootstrap.Modal.getOrCreateInstance(modal);
            let answered = false;

            btnOk.addEventListener('click', () => {
                answered = true;
                bsModal.hide();
                resolve(true);
            }, { once: true });

            modal.addEventListener('hidden.bs.modal', () => {
                if (!answered) resolve(false);
            }, { once: true });

            bsModal.show();
        });
    };
})();
