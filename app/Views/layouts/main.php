<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - AdminPanel</title>
    <meta name="X-CSRF-TOKEN" content="<?= csrf_hash() ?>">

    <!-- Bootstrap 5 (local) -->
    <link href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Bootstrap Icons (local) -->
    <link href="<?= base_url('vendor/bootstrap-icons/bootstrap-icons.min.css') ?>" rel="stylesheet">
    <!-- Flag Icons (local) -->
    <link href="<?= base_url('vendor/flag-icons/css/flag-icons.min.css') ?>" rel="stylesheet">
    <!-- Simple-DataTables CSS -->
    <link href="<?= base_url('vendor/simple-datatables/style.css') ?>" rel="stylesheet">
    <!-- Admin CSS -->
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
    <!-- Alpine.js (local) -->
    <script defer src="<?= base_url('vendor/alpinejs/cdn.min.js') ?>"></script>

    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Page Loader -->
<div class="page-loader">
    <div class="dot-loader"></div>
</div>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay"></div>

<!-- Sidebar -->
<?= $this->include('partials/sidebar') ?>

<!-- Top Navbar -->
<?= $this->include('partials/navbar') ?>

<!-- Main Content -->
<main class="app-main">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <h3><?= $pageTitle ?? $title ?? 'Dashboard' ?></h3>
            <?php if (isset($breadcrumb)): ?>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                    <?php foreach ($breadcrumb as $label => $url): ?>
                        <?php if ($url): ?>
                            <li class="breadcrumb-item"><a href="<?= $url ?>"><?= $label ?></a></li>
                        <?php else: ?>
                            <li class="breadcrumb-item active"><?= $label ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>
            <?php endif; ?>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i><?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($validationErrors = session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-1">
                    <?php foreach ((array) $validationErrors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <?= $this->renderSection('content') ?>

    </div>


</main>

<!-- Toast Container -->
<div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1090;"></div>

<!-- Global Confirm Modal -->
<div class="modal fade" id="globalConfirmModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <i class="confirm-icon bi bi-exclamation-triangle-fill text-warning" style="font-size:2.5rem;"></i>
                <h5 class="confirm-title mt-3 mb-2"></h5>
                <p class="confirm-message text-muted small mb-0"></p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm confirm-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-sm confirm-btn-ok">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (local) -->
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- Simple-DataTables JS -->
<script src="<?= base_url('vendor/simple-datatables/simple-datatables.js') ?>"></script>
<!-- Global Utils -->
<script src="<?= base_url('assets/js/utils/toast.js') ?>"></script>
<script src="<?= base_url('assets/js/utils/confirm-modal.js') ?>"></script>
<!-- CRUD Page Base Component -->
<script src="<?= base_url('assets/js/components/crud-page.js') ?>"></script>
<!-- Admin JS -->
<script src="<?= base_url('assets/js/admin.js') ?>"></script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
