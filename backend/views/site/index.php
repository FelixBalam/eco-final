<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'EcoSort Admin';

// --- PROCESAMIENTO DINÁMICO DE DATOS EN TIEMPO REAL ---
$ultimoPlastico = 0;
$ultimoMetal = 0;
$ultimoOtros = 0;

$encontradoPlastico = false;
$encontradoMetal = false;
$encontradoOtros = false;

$totalReportesCount = count($reportes);

foreach ($reportes as $r) {
    if ($r['contenedor'] === 'Plástico' && !$encontradoPlastico) {
        $ultimoPlastico = (int)$r['nivel'];
        $encontradoPlastico = true;
    }
    if ($r['contenedor'] === 'Metal' && !$encontradoMetal) {
        $ultimoMetal = (int)$r['nivel'];
        $encontradoMetal = true;
    }
    if ($r['contenedor'] === 'Otros' && !$encontradoOtros) {
        $ultimoOtros = (int)$r['nivel'];
        $encontradoOtros = true;
    }
}

$alertasCriticas = 0;
if ($ultimoPlastico >= 85) $alertasCriticas++;
if ($ultimoMetal >= 85) $alertasCriticas++;
if ($ultimoOtros >= 85) $alertasCriticas++;

function obtenerColorPorcentaje($nivel) {
    if ($nivel >= 85) return 'text-danger';
    if ($nivel >= 50) return 'text-warning';
    return 'text-success';
}

function obtenerBgProgreso($nivel) {
    if ($nivel >= 85) return 'bg-danger';
    if ($nivel >= 50) return 'bg-warning';
    return 'bg-success';
}
?>

<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<div class="container-fluid p-0">
    <div class="bg-light min-vh-100">

        <div class="container-fluid p-4">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-bold text-success">♻ Sistema Inteligente de Separación de Basura</h1>
                            <p class="lead text-secondary mt-3">Plataforma empresarial para la administración, monitoreo y classification automática de residuos reciclables mediante sensores inteligentes.</p>
                            <div class="mt-4">
                                <?= Html::a('Administrar Residuos', '#monitoreo-ancla', ['class' => 'btn btn-success btn-lg me-2', 'style' => 'border-radius:12px; font-weight:600;']) ?>
                                <?= Html::a('Ver Reportes', ['site/estadisticas'], ['class' => 'btn btn-outline-dark btn-lg', 'style' => 'border-radius:12px; font-weight:600;']) ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="bi bi-recycle" style="font-size: 140px; color:#198754;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <h5 id="monitoreo-ancla" class="fw-bold text-dark mb-3" style="scroll-margin-top: 100px;">Monitoreo Físico de Contenedores</h5>
            <div class="row mb-4">
                
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100 p-2" style="border-radius:16px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-secondary m-0 fw-bold">Contenedor Plástico 🥤</h6>
                                    <h2 class="fw-bold mt-2 <?= obtenerColorPorcentaje($ultimoPlastico) ?>"><?= $ultimoPlastico ?>%</h2>
                                </div>
                                <span class="fs-2">📊</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px; border-radius:10px;">
                                <div class="progress-bar <?= obtenerBgProgreso($ultimoPlastico) ?>" style="width: <?= $ultimoPlastico ?>%"></div>
                            </div>
                            
                            <div class="mt-3 d-flex gap-2 align-items-center flex-wrap">
                                <?= Html::beginForm(['site/index'], 'post', ['class' => 'd-inline m-0']) ?>
                                    <input type="hidden" name="accion_tipo" value="ajustar">
                                    <input type="hidden" name="contenedor" value="Plástico">
                                    <input type="hidden" name="nivel" value="<?= min(100, $ultimoPlastico + 10) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2 fs-7" style="border-radius:8px; font-weight:500;">+10%</button>
                                <?= Html::endForm() ?>

                                <?= Html::beginForm(['site/index'], 'post', ['class' => 'd-inline m-0']) ?>
                                    <input type="hidden" name="accion_tipo" value="vaciar">
                                    <input type="hidden" name="contenedor" value="Plástico">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-1 px-2 fs-7" style="border-radius:8px; font-weight:500;">Vaciar</button>
                                <?= Html::endForm() ?>

                                <?= Html::a('GESTIONAR PLÁSTICO', ['site/crud-plastico'], ['class' => 'btn btn-sm btn-outline-dark py-1 px-2 fs-7', 'style' => 'border-radius:8px; font-weight:500;']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100 p-2" style="border-radius:16px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-secondary m-0 fw-bold">Contenedor Metal 🥫</h6>
                                    <h2 class="fw-bold mt-2 <?= obtenerColorPorcentaje($ultimoMetal) ?>"><?= $ultimoMetal ?>%</h2>
                                </div>
                                <span class="fs-2">📊</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px; border-radius:10px;">
                                <div class="progress-bar <?= obtenerBgProgreso($ultimoMetal) ?>" style="width: <?= $ultimoMetal ?>%"></div>
                            </div>
                            <div class="mt-3 d-flex gap-2 align-items-center flex-wrap">
                                <?= Html::beginForm(['site/index'], 'post', ['class' => 'd-inline m-0']) ?>
                                    <input type="hidden" name="accion_tipo" value="ajustar">
                                    <input type="hidden" name="contenedor" value="Metal">
                                    <input type="hidden" name="nivel" value="<?= min(100, $ultimoMetal + 10) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2 fs-7" style="border-radius:8px; font-weight:500;">+10%</button>
                                <?= Html::endForm() ?>

                                <?= Html::beginForm(['site/index'], 'post', ['class' => 'd-inline m-0']) ?>
                                    <input type="hidden" name="accion_tipo" value="vaciar">
                                    <input type="hidden" name="contenedor" value="Metal">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-1 px-2 fs-7" style="border-radius:8px; font-weight:500;">Vaciar</button>
                                <?= Html::endForm() ?>

                                <?= Html::a('GESTIONAR METAL', ['site/crud-metal'], ['class' => 'btn btn-sm btn-outline-dark py-1 px-2 fs-7', 'style' => 'border-radius:8px; font-weight:500;']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100 p-2" style="border-radius:16px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-secondary m-0 fw-bold">Contenedor Otros 🗑️</h6>
                                    <h2 class="fw-bold mt-2 <?= obtenerColorPorcentaje($ultimoOtros) ?>"><?= $ultimoOtros ?>%</h2>
                                </div>
                                <span class="fs-2">📊</span>
                            </div>
                            <div class="progress mt-2" style="height: 6px; border-radius:10px;">
                                <div class="progress-bar <?= obtenerBgProgreso($ultimoOtros) ?>" style="width: <?= $ultimoOtros ?>%"></div>
                            </div>
                            <div class="mt-3 d-flex gap-2 align-items-center flex-wrap">
                                <?= Html::beginForm(['site/index'], 'post', ['class' => 'd-inline m-0']) ?>
                                    <input type="hidden" name="accion_tipo" value="ajustar">
                                    <input type="hidden" name="contenedor" value="Otros">
                                    <input type="hidden" name="nivel" value="<?= min(100, $ultimoOtros + 10) ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2 fs-7" style="border-radius:8px; font-weight:500;">+10%</button>
                                <?= Html::endForm() ?>

                                <?= Html::beginForm(['site/index'], 'post', ['class' => 'd-inline m-0']) ?>
                                    <input type="hidden" name="accion_tipo" value="vaciar">
                                    <input type="hidden" name="contenedor" value="Otros">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary py-1 px-2 fs-7" style="border-radius:8px; font-weight:500;">Vaciar</button>
                                <?= Html::endForm() ?>

                                <?= Html::a('GESTIONAR OTROS', ['site/crud-otros'], ['class' => 'btn btn-sm btn-outline-dark py-1 px-2 fs-7', 'style' => 'border-radius:8px; font-weight:500;']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-secondary small m-0 fw-bold">Historial Logs</h6>
                                    <h2 class="fw-bold text-success mt-1 mb-0"><?= $totalReportesCount ?></h2>
                                </div>
                                <i class="bi bi-recycle" style="font-size: 40px; color:#198754;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-secondary small m-0 fw-bold">Sensores Activos</h6>
                                    <h2 class="fw-bold text-primary mt-1 mb-0">3</h2>
                                </div>
                                <i class="bi bi-cpu" style="font-size: 40px; color:#0d6efd;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-secondary small m-0 fw-bold">Zonas Enlace</h6>
                                    <h2 class="fw-bold text-warning mt-1 mb-0">Firebase</h2>
                                </div>
                                <i class="bi bi-trash3" style="font-size: 40px; color:#ffc107;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-secondary small m-0 fw-bold">Críticos (Llenos)</h6>
                                    <h2 class="fw-bold text-danger mt-1 mb-0"><?= $alertasCriticas ?></h2>
                                </div>
                                <i class="bi bi-bell" style="font-size: 40px; color:#dc3545;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px; overflow:hidden;">
                        <div class="card-header bg-dark text-white py-3">
                            <h5 class="mb-0 fw-bold fs-6">Ingreso Manual</h5>
                        </div>
                        <div class="card-body p-4 bg-white">
                            <?= Html::beginForm(['site/index'], 'post') ?>
                                <input type="hidden" name="accion_tipo" value="manual">
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Nombre del Residuo</label>
                                    <input type="text" name="nuevo_nombre" class="form-control" placeholder="Ej. Cartón o Vidrio" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted small fw-bold">Nivel de Entrada (%)</label>
                                    <input type="number" name="nuevo_nivel" class="form-control" min="0" max="100" placeholder="0 - 100" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm mt-2" style="border-radius:10px; py:2px;">GUARDAR</button>
                            <?= Html::endForm() ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px; overflow:hidden;">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0 fw-bold fs-6">Actividad Reciente (Firestore Live Logs)</h5>
                        </div>
                        <div class="card-body p-0 bg-white">
                            <div class="table-responsive" style="max-height: 330px; overflow-y: auto;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th class="px-4">Contenedor</th>
                                            <th>Nivel</th>
                                            <th>Operación Ejecutada</th>
                                            <th class="px-4">Fecha Evento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($reportes)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">No se detectaron registros en reportes_reciclaje.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach (array_slice($reportes, 0, 15) as $log): ?>
                                                <tr>
                                                    <td class="px-4 fw-bold text-dark"><?= Html::encode($log['contenedor']) ?></td>
                                                    <td>
                                                        <span class="badge <?= (int)$log['nivel'] >= 85 ? 'bg-danger' : ((int)$log['nivel'] >= 50 ? 'bg-warning text-dark' : 'bg-success') ?>">
                                                            <?= $log['nivel'] ?>%
                                                        </span>
                                                    </td>
                                                    <td class="text-secondary small"><?= Html::encode($log['tipo_accion']) ?></td>
                                                    <td class="px-4 small text-muted"><?= $log['fechaFormateada'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>