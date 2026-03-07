<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">

        <!-- Header actions -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="<?= base_url('currencies') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
            <div class="d-flex gap-2">
                <a href="<?= base_url('currencies/' . $currency->id . '/edit') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>Editar
                </a>
            </div>
        </div>

        <!-- Card detalle -->
        <div class="card">
            <div class="card-body p-4">

                <!-- Avatar + nombre -->
                <div class="d-flex align-items-center mb-4">
                    <div class="user-avatar me-3" style="width:48px;height:48px;font-size:1.1rem;">
                        <?= strtoupper(substr($currency->acronym, 0, 2)) ?>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= esc($currency->acronym) ?></h5>
                        <div class="text-muted small"><?= esc($currency->name) ?></div>
                    </div>
                    <?php if ($currency->flag): ?>
                    <span class="<?= esc($currency->flag) ?> ms-auto" style="font-size:2rem;"></span>
                    <?php endif; ?>
                </div>

                <hr>

                <!-- Campos -->
                <dl class="row mb-0">
                    <dt class="col-5 text-muted fw-normal small">Símbolo</dt>
                    <dd class="col-7 fw-semibold"><?= esc($currency->sign) ?></dd>

                    <dt class="col-5 text-muted fw-normal small">ISO Numérico</dt>
                    <dd class="col-7"><?= $currency->iso_numeric ?? '—' ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Código Interno</dt>
                    <dd class="col-7"><?= $currency->internal_code ?? '—' ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Estado</dt>
                    <dd class="col-7"><?= $currency->getStatusBadge() ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Creado</dt>
                    <dd class="col-7 small"><?= $currency->created_at?->format('d/m/Y H:i') ?? '—' ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Actualizado</dt>
                    <dd class="col-7 small"><?= $currency->updated_at?->format('d/m/Y H:i') ?? '—' ?></dd>
                </dl>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
