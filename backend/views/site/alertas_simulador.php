<?php
use yii\helpers\Html;

$this->title = 'Centro de Alertas Críticas y Avisos';

$firebase = new \backend\components\FirebaseService();

// --- PROCESADOR DE ACCIÓN DE VACIADO MANUAL DE EMERGENCIA ---
if (Yii::$app->request->isPost) {
    $post = Yii::$app->request->post();
    if (isset($post['action']) && $post['action'] === 'vaciar_emergencia') {
        // Registra una ÚNICA entrada en 0% para resetear el contenedor
        $firebase->createReporte($post['contenedor'], 0, 'Vaciado Manual por Alerta/Aviso');
        return Yii::$app->controller->refresh();
    }
}

$reportes = $firebase->getReportes();

// --- EXTRAER EL ÚLTIMO ESTADO EN TIEMPO REAL DE CADA CONTENEDOR ---
$ultimoPlastico = null;
$ultimoMetal = null;
$ultimoOtros = null;

foreach ($reportes as $r) {
    if ($r['contenedor'] === 'Plástico' && $ultimoPlastico === null) {
        $ultimoPlastico = $r;
    }
    if ($r['contenedor'] === 'Metal' && $ultimoMetal === null) {
        $ultimoMetal = $r;
    }
    if ($r['contenedor'] === 'Otros' && $ultimoOtros === null) {
        $ultimoOtros = $r;
    }
}

$nivelP = $ultimoPlastico ? $ultimoPlastico['nivel'] : 0;
$nivelM = $ultimoMetal ? $ultimoMetal['nivel'] : 0;
$nivelO = $ultimoOtros ? $ultimoOtros['nivel'] : 0;

// Aquí consolidamos tanto alertas críticas como avisos preventivos
$alertasActivas = [];

// Evaluación para Plástico
if ($nivelP >= 85) {
    $alertasActivas[] = [
        'nombre_puro' => 'Plástico',
        'contenedor' => 'Plástico 🥤',
        'nivel' => $nivelP,
        'fecha' => $ultimoPlastico['fechaFormateada'],
        'tipo' => 'critico',
        'clase_css' => 'alert-danger border-left-danger animate-pulse',
        'badge_css' => 'bg-danger',
        'titulo' => 'Saturación Crítica',
        'mensaje' => 'El volumen actual impide que los sensores registren nuevas entradas. Requiere vaciado manual inmediato.'
    ];
} elseif ($nivelP >= 50 && $nivelP <= 84) {
    $alertasActivas[] = [
        'nombre_puro' => 'Plástico',
        'contenedor' => 'Plástico 🥤',
        'nivel' => $nivelP,
        'fecha' => $ultimoPlastico['fechaFormateada'],
        'tipo' => 'preventivo',
        'clase_css' => 'alert-warning border-left-warning text-dark',
        'badge_css' => 'bg-warning text-dark',
        'titulo' => 'Aviso de Llenado',
        'mensaje' => 'El contenedor ha superado la mitad de su capacidad. Monitorear para programar próximo vaciado.'
    ];
}

// Evaluación para Metal
if ($nivelM >= 85) {
    $alertasActivas[] = [
        'nombre_puro' => 'Metal',
        'contenedor' => 'Metal 🥫',
        'nivel' => $nivelM,
        'fecha' => $ultimoMetal['fechaFormateada'],
        'tipo' => 'critico',
        'clase_css' => 'alert-danger border-left-danger animate-pulse',
        'badge_css' => 'bg-danger',
        'titulo' => 'Saturación Crítica',
        'mensaje' => 'El volumen actual impide que los sensores registren nuevas entradas. Requiere vaciado manual inmediato.'
    ];
} elseif ($nivelM >= 50 && $nivelM <= 84) {
    $alertasActivas[] = [
        'nombre_puro' => 'Metal',
        'contenedor' => 'Metal 🥫',
        'nivel' => $nivelM,
        'fecha' => $ultimoMetal['fechaFormateada'],
        'tipo' => 'preventivo',
        'clase_css' => 'alert-warning border-left-warning text-dark',
        'badge_css' => 'bg-warning text-dark',
        'titulo' => 'Aviso de Llenado',
        'mensaje' => 'El contenedor ha superado la mitad de su capacidad. Monitorear para programar próximo vaciado.'
    ];
}

// Evaluación para Otros
if ($nivelO >= 85) {
    $alertasActivas[] = [
        'nombre_puro' => 'Otros',
        'contenedor' => 'Otros 🗑️',
        'nivel' => $nivelO,
        'fecha' => $ultimoOtros['fechaFormateada'],
        'tipo' => 'critico',
        'clase_css' => 'alert-danger border-left-danger animate-pulse',
        'badge_css' => 'bg-danger',
        'titulo' => 'Saturación Crítica',
        'mensaje' => 'El volumen actual impide que los sensores registren nuevas entradas. Requiere vaciado manual inmediato.'
    ];
} elseif ($nivelO >= 50 && $nivelO <= 84) {
    $alertasActivas[] = [
        'nombre_puro' => 'Otros',
        'contenedor' => 'Otros 🗑️',
        'nivel' => $nivelO,
        'fecha' => $ultimoOtros['fechaFormateada'],
        'tipo' => 'preventivo',
        'clase_css' => 'alert-warning border-left-warning text-dark',
        'badge_css' => 'bg-warning text-dark',
        'titulo' => 'Aviso de Llenado',
        'mensaje' => 'El contenedor ha superado la mitad de su capacidad. Monitorear para programar próximo vaciado.'
    ];
}
?>

<div class="container-fluid p-0">
    <div class="row">
        <!-- SECCIÓN DE NOTIFICACIONES EN VIVO -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold fs-6">🚨 Panel de Incidentes y Avisos Activos</h5>
                    <span class="badge bg-primary fw-bold px-2.5 py-1.5"><?= count($alertasActivas) ?> Eventos detectados</span>
                </div>
                <div class="card-body p-4 bg-white">
                    
                    <?php if (empty($alertasActivas)): ?>
                        <!-- ESTADO SEGURO -->
                        <div class="text-center py-5">
                            <div class="display-1 text-success mb-3">🛡️</div>
                            <h4 class="fw-bold text-success">Sistemas Fuera de Peligro</h4>
                            <p class="text-secondary mx-auto small" style="max-width: 460px;">
                                Los sensores inteligentes reportan capacidades estables (menos del 50%) en todos los contenedores de EcoSort. No se requiere mantenimiento manual por el momento.
                            </p>
                        </div>
                    <?php else: ?>
                        <!-- LISTADO COMBINADO DE ALERTAS Y AVISOS -->
                        <p class="text-muted small mb-3">Estado actual de la periferia: Monitoree los contenedores amarillos y atienda con prioridad los rojos.</p>
                        
                        <?php foreach ($alertasActivas as $alerta): ?>
                            <div class="alert <?= $alerta['clase_css'] ?> border-0 shadow-sm p-4 rounded-3 mb-3 d-flex align-items-start gap-3">
                                <div class="fs-2"><?= $alerta['tipo'] === 'critico' ? '⚠️' : '🔔' ?></div>
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h5 class="fw-bold m-0"><?= $alerta['titulo'] ?>: Contenedor <?= $alerta['contenedor'] ?></h5>
                                        <span class="badge <?= $alerta['badge_css'] ?> fs-6 fw-bold"><?= $alerta['nivel'] ?>%</span>
                                    </div>
                                    <p class="m-0 mt-2 small opacity-90">
                                        <?= $alerta['mensaje'] ?>
                                    </p>
                                    <hr class="my-2 opacity-25 text-dark">
                                    <div class="d-flex justify-content-between align-items-center small opacity-75">
                                        <span>Reportado el: <strong><?= $alerta['fecha'] ?></strong></span>
                                        <span class="fw-bold small">Estado: <?= $alerta['tipo'] === 'critico' ? 'Urgente' : 'Monitoreo Preventivo' ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- SECCIÓN DE RESPUESTA OPERATIVA EN SITIO -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold fs-6">🛠️ Control de Operación Manual</h5>
                </div>
                <div class="card-body p-4 bg-white text-center">
                    <h6 class="text-secondary fw-bold text-start small text-uppercase mb-3">Protocolo de Limpieza</h6>
                    
                    <?php if (!empty($alertasActivas)): ?>
                        <p class="text-muted text-start small mb-4">
                            Seleccione el contenedor que ha sido vaciado o limpiado físicamente en el sitio para restablecer su nivel a 0% en la base de datos.
                        </p>
                        
                        <!-- Generar un botón de vaciado para cualquier contenedor en Alerta o Aviso -->
                        <?php foreach ($alertasActivas as $alerta): ?>
                            <?= Html::beginForm(['site/alertas-simulador'], 'post', ['class' => 'mb-2']) ?>
                                <input type="hidden" name="action" value="vaciar_emergencia">
                                <input type="hidden" name="contenedor" value="<?= $alerta['nombre_puro'] ?>">
                                <button type="submit" class="btn btn-sm <?= $alerta['tipo'] === 'critico' ? 'btn-outline-danger' : 'btn-outline-warning text-dark' ?> w-100 fw-bold py-2">
                                    🔄 Marcar <?= $alerta['nombre_puro'] ?> como Vaciado (0%)
                                </button>
                            <?= Html::endForm() ?>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p class="text-muted text-start small">
                            Todos los contenedores se encuentran en niveles óptimos de espacio. No se requieren acciones de mantenimiento por el momento.
                        </p>
                        <button type="button" class="btn btn-outline-secondary w-100 fw-bold py-2" disabled>
                            Mantenimiento en Espera
                        </button>
                    <?php endif; ?>
                    
                    <hr class="my-4 opacity-50">
                    <h6 class="text-secondary fw-bold text-start small text-uppercase mb-2">Umbrales de Capacidad</h6>
                    <ul class="list-group list-group-flush text-start small">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">Estado Seguro:</span>
                            <span class="text-success fw-bold">0% - 49%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">Estado Llenado:</span>
                            <span class="text-warning fw-bold">50% - 84%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted">Estado Crítico:</span>
                            <span class="text-danger fw-bold">&gt;= 85%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}
.animate-pulse {
    animation: pulse 2s infinite;
}
.border-left-danger {
    border-left: 5px solid #dc3545 !important;
}
.border-left-warning {
    border-left: 5px solid #ffc107 !important;
}
</style>