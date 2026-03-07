<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Clientes</div>
                    <div class="fs-4 fw-bold"><?= number_format($totalClientes) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                    <i class="bi bi-kanban-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Proyectos Activos</div>
                    <div class="fs-4 fw-bold"><?= $proyectosActivos ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div>
                    <div class="text-muted small">Cotizaciones Pend.</div>
                    <div class="fs-4 fw-bold"><?= $cotizacionesPend ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stats-card">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div>
                    <div class="text-muted small">Ingresos Mes</div>
                    <div class="fs-4 fw-bold">$<?= number_format($ingresosMes) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Placeholder -->
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0 fw-bold">Ingresos Mensuales</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card stats-card">
            <div class="card-header bg-transparent border-0">
                <h6 class="mb-0 fw-bold">Actividad Reciente</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-3 py-2">
                        <span class="badge bg-success me-2">&bull;</span>
                        <span class="small">Cotización #045 aprobada</span>
                        <div class="text-muted ps-4" style="font-size:0.75rem;">Hace 2 horas</div>
                    </div>
                    <div class="list-group-item border-0 px-3 py-2">
                        <span class="badge bg-primary me-2">&bull;</span>
                        <span class="small">Nuevo cliente registrado</span>
                        <div class="text-muted ps-4" style="font-size:0.75rem;">Hace 4 horas</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('vendor/chartjs/chart.umd.js') ?>"></script>
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        datasets: [{
            label: 'Ingresos ($)',
            data: [42000,38000,55000,47000,61000,58000,72000,69000,84000,78000,91000,84520],
            backgroundColor: 'rgba(67, 94, 190, 0.7)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
<?= $this->endSection() ?>
