<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">

        <!-- Header actions -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="<?= base_url('service-types') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Volver
            </a>
            <div class="d-flex gap-2">
                <a href="<?= base_url('service-types/' . $item->id . '/edit') ?>" class="btn btn-primary btn-sm">
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
                        <?= strtoupper(substr($item->denomination, 0, 2)) ?>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold"><?= esc($item->denomination) ?></h5>
                    </div>
                </div>

                <hr>

                <!-- Campos -->
                <dl class="row mb-0">
                    <dt class="col-5 text-muted fw-normal small">Denominación</dt>
                    <dd class="col-7 fw-semibold"><?= esc($item->denomination) ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Descripción</dt>
                    <dd class="col-7"><?= $item->description ? esc($item->description) : '—' ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Estado</dt>
                    <dd class="col-7">
                        <span class="badge <?= $item->is_active ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>">
                            <?= $item->is_active ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </dd>

                    <dt class="col-5 text-muted fw-normal small">Creado</dt>
                    <dd class="col-7 small"><?= $item->created_at?->format('d/m/Y H:i') ?? '—' ?></dd>

                    <dt class="col-5 text-muted fw-normal small">Actualizado</dt>
                    <dd class="col-7 small"><?= $item->updated_at?->format('d/m/Y H:i') ?? '—' ?></dd>
                </dl>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
