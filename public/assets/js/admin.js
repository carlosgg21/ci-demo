/* ============================================
   ADMIN PANEL - Core JavaScript
   Vanilla JS - No jQuery
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // --- Sidebar Toggle (full <-> mini) ---
    const toggleBtn = document.getElementById('sidebar-toggle');
    const body = document.body;

    // Restore saved state
    if (localStorage.getItem('sidebar-mini') === 'true') {
        body.classList.add('sidebar-mini');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            body.classList.toggle('sidebar-mini');
            localStorage.setItem('sidebar-mini', body.classList.contains('sidebar-mini'));
        });
    }

    // --- Mobile Sidebar ---
    const mobileToggle = document.getElementById('mobile-sidebar-toggle');
    const sidebar = document.querySelector('.app-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    // --- Dark Mode Toggle ---
    const darkToggle = document.getElementById('dark-mode-toggle');

    // Restore saved theme
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        updateDarkIcon(savedTheme === 'dark');
    }

    if (darkToggle) {
        darkToggle.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateDarkIcon(!isDark);
        });
    }

    function updateDarkIcon(isDark) {
        const icon = document.querySelector('#dark-mode-toggle i');
        if (icon) {
            icon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }
    }

    // --- Sidebar Submenu Toggle (custom, no Bootstrap collapse) ---
    document.querySelectorAll('.sidebar-menu > .menu-item > .menu-link[data-submenu]').forEach(link => {
        const targetId = link.getAttribute('data-submenu');
        const submenu = document.getElementById(targetId);
        if (!submenu) return;

        // Si ya está abierto
        if (submenu.classList.contains('show')) {
            link.setAttribute('aria-expanded', 'true');
        }

        link.addEventListener('click', (e) => {
            e.preventDefault();

            // En modo mini, el flyout funciona con CSS :hover, no hacer nada con JS
            if (document.body.classList.contains('sidebar-mini')) return;

            const isOpen = submenu.classList.contains('show');

            // Accordion: cerrar los demás
            document.querySelectorAll('.sidebar-menu .submenu.show').forEach(openSub => {
                if (openSub !== submenu) {
                    openSub.classList.remove('show');
                    const parentLink = openSub.closest('.menu-item')?.querySelector('.menu-link[data-submenu]');
                    if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
                }
            });

            submenu.classList.toggle('show');
            link.setAttribute('aria-expanded', !isOpen);
        });
    });

    // --- Page Loader ---
    const loader = document.querySelector('.page-loader');
    if (loader) {
        setTimeout(() => loader.classList.add('loaded'), 300);
    }

    // --- Tooltips Init ---
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

    // --- Toast Helper ---
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const icons = {
            success: 'bi-check-circle-fill',
            danger: 'bi-x-circle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        };

        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${icons[type] || icons.info} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>`;
        container.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
        bsToast.show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    };
});
