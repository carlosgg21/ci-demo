<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/bootstrap-icons/bootstrap-icons.min.css') ?>" rel="stylesheet">
    <style>
        body { background: #f2f7ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { max-width: 420px; width: 100%; border: none; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .brand-icon { width: 48px; height: 48px; background: #435ebe; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 1.25rem; }
    </style>
</head>
<body>

<?= $this->renderSection('content') ?>

</body>
</html>
