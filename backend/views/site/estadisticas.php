<?php
use yii\helpers\Html;

$this->title = 'Estadísticas Analíticas Globales';

$firebase = new \backend\components\FirebaseService();
$reportes = $firebase->getReportes();

// Variables de conteo y acumuladores para analítica
$sumaPlastico = 0; $conteoPlastico = 0;
$sumaMetal = 0;    $conteoMetal = 0;
$sumaOtros = 0;    $conteoOtros = 0;

foreach ($reportes as $r) {
    if ($r['contenedor'] === 'Plástico') {
        $sumaPlastico += $r['nivel'];
        $conteoPlastico++;
    } elseif ($r['contenedor'] === 'Metal') {
        $sumaMetal += $r['nivel'];
        $conteoMetal++;
    } elseif ($r['contenedor'] === 'Otros') {
        $sumaOtros += $r['nivel'];
        $conteoConteoOtros = isset($conteoOtros) ? $conteoOtros : 0; // Asegurar consistencia
        $sumaOtros += $r['nivel'];
        $conteoOtros++;
    }
}

// Calcular promedios evitando divisiones por cero
$promedioPlastico = $conteoPlastico > 0 ? round($sumaPlastico / $conteoPlastico) : 0;
$promedioMetal = $conteoMetal > 0 ? round($sumaMetal / $conteoMetal) : 0;
$promedioOtros = $conteoOtros > 0 ? round($sumaOtros / $conteoOtros) : 0;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase m-0">Registros Plásticos</h6>
                        <h2 class="fw-bold text-success mt-2 mb-0"><?= $conteoPlastico ?></h2>
                    </div>
                    <span class="fs-1 opacity-50">🥤</span>
                </div>
                <div class="text-muted small mt-2">Promedio histórico: <strong><?= $promedioPlastico ?>%</strong></div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase m-0">Registros Metálicos</h6>
                        <h2 class="fw-bold text-primary mt-2 mb-0"><?= $conteoMetal ?></h2>
                    </div>
                    <span class="fs-1 opacity-50">🥫</span>
                </div>
                <div class="text-muted small mt-2">Promedio histórico: <strong><?= $promedioMetal ?>%</strong></div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-secondary small fw-bold text-uppercase m-0">Registros Otros</h6>
                        <h2 class="fw-bold text-warning mt-2 mb-0"><?= $conteoOtros ?></h2>
                    </div>
                    <span class="fs-1 opacity-50">🗑️</span>
                </div>
                <div class="text-muted small mt-2">Promedio histórico: <strong><?= $promedioOtros ?>%</strong></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold fs-6">📈 Capacidad Promedio por Tipo de Contenedor</h5>
                </div>
                <div class="card-body p-4 bg-white" style="position: relative; height:340px;">
                    <canvas id="canvasBarras"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold fs-6">🥧 Distribución Operativa de Entradas</h5>
                </div>
                <div class="card-body p-4 bg-white d-flex align-items-center justify-content-center" style="position: relative; height:340px;">
                    <div style="width:260px; height:260px;">
                        <canvas id="canvasPastel"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const promedios = [<?= $promedioPlastico ?>, <?= $promedioMetal ?>, <?= $promedioOtros ?>];
const conteos = [<?= $conteoPlastico ?>, <?= $conteoMetal ?>, <?= $conteoOtros ?>];

// 1. Inicialización Gráfica de Barras
new Chart(document.getElementById('canvasBarras'), {
    type: 'bar',
    data: {
        labels: ['Plástico (🥤)', 'Metal (🥫)', 'Otros (🗑️)'],
        datasets: [{
            label: 'Nivel Promedio (%)',
            data: promedios,
            backgroundColor: ['rgba(40, 167, 69, 0.8)', 'rgba(0, 123, 255, 0.8)', 'rgba(255, 193, 7, 0.8)'],
            borderColor: ['#28a745', '#007bff', '#ffc107'],
            borderWidth: 1.5,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true, max: 100, ticks: { callback: function(v){ return v+'%'; } } } }
    }
});

// 2. Inicialización Gráfica de Pastel
new Chart(document.getElementById('canvasPastel'), {
    type: 'pie',
    data: {
        labels: ['Plástico', 'Metal', 'Otros'],
        datasets: [{
            data: conteos,
            backgroundColor: ['#28a745', '#007bff', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>