<?php
use yii\helpers\Html;

$this->title = 'EcoSort - Módulo Metal';

$firebase = new \backend\components\FirebaseService();

// PROCESADOR DEL CRUD POST PARA ALEJANDRA (CON RETORNO Y MANEJO DE ACTUALIZACIONES)
if (Yii::$app->request->isPost) {
    $post = Yii::$app->request->post();
    if (isset($post['action'])) {
        if ($post['action'] === 'create') {
            $firebase->createReporte('Metal', $post['nivel'], $post['tipo_accion']);
            return Yii::$app->controller->refresh();
        } elseif ($post['action'] === 'update') {
            $firebase->updateReporte($post['id'], 'Metal', $post['nivel'], $post['tipo_accion']);
            return Yii::$app->controller->refresh();
        } elseif ($post['action'] === 'delete') {
            $firebase->deleteReporte($post['id']);
            return Yii::$app->controller->refresh();
        }
    }
}

// OBTENER Y FILTRAR SOLO REPORTE DE METAL
$todos = $firebase->getReportes();
$reportesFiltrados = [];
foreach ($todos as $r) {
    if ($r['contenedor'] === 'Metal') {
        $reportesFiltrados[] = $r;
    }
}
?>
<div class="container-fluid p-0">
    <div class="col-md-10 offset-md-2 bg-light min-vh-100 p-4" style="padding-top: 80px !important;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-primary fw-bold m-0">🥫 Gestión de Residuos de Metal</h2>
                <p class="text-muted m-0 small">Desarrolladora Responsable: <strong>Alejandra</strong></p>
            </div>
            <?= Html::a('← Volver al Dashboard', ['site/index'], ['class' => 'btn btn-outline-secondary fw-bold shadow-sm']) ?>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                
                <div id="panel-crear" class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold fs-6">Nuevo Registro Manual</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= Html::beginForm(['site/crud-metal'], 'post') ?>
                            <input type="hidden" name="action" value="create">
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Nivel de Llenado (%)</label>
                                <input type="number" name="nivel" class="form-control" min="0" max="100" placeholder="Ej. 50" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Operación / Acción</label>
                                <input type="text" name="tipo_accion" class="form-control" placeholder="Ej. Ingreso Manual CRUD" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">Guardar en Firestore</button>
                        <?= Html::endForm() ?>
                    </div>
                </div>

                <div id="panel-editar" class="card border-0 shadow-lg d-none">
                    <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold fs-6">✏️ Editar Registro Seleccionado</h5>
                        <button type="button" class="btn-close btn-close-white" onclick="cancelarEdicion()"></button>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <?= Html::beginForm(['site/crud-metal'], 'post') ?>
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" id="edit-id">
                            
                            <div class="mb-3">
                                <label class="form-label text-primary small fw-bold">Modificar Nivel de Llenado (%)</label>
                                <input type="number" name="nivel" id="edit-nivel" class="form-control border-primary" min="0" max="100" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-primary small fw-bold">Modificar Operación / Acción</label>
                                <input type="text" name="tipo_accion" id="edit-accion" class="form-control border-primary" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-light w-50 fw-bold border" onclick="cancelarEdicion()">Cancelar</button>
                                <button type="submit" class="btn btn-sm btn-primary w-50 fw-bold shadow-sm">Actualizar</button>
                            </div>
                        <?= Html::endForm() ?>
                    </div>
                </div>

            </div>

            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white py-3">
                        <h5 class="mb-0 fw-bold fs-6">Historial Específico (Metal Logs)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="px-4">Nivel</th>
                                        <th>Acción Ejecutada</th>
                                        <th>Fecha Evento</th>
                                        <th class="text-center px-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($reportesFiltrados)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No hay logs de Metal en la base de datos.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($reportesFiltrados as $log): ?>
                                            <tr id="fila-<?= Html::encode($log['id']) ?>">
                                                <td class="px-4">
                                                    <span class="badge <?= $log['nivel'] >= 85 ? 'bg-danger' : ($log['nivel'] >= 50 ? 'bg-warning text-dark' : 'bg-success') ?>">
                                                        <?= $log['nivel'] ?>%
                                                    </span>
                                                </td>
                                                <td class="text-secondary small"><?= Html::encode($log['tipo_accion']) ?></td>
                                                <td class="small text-muted"><?= $log['fechaFormateada'] ?></td>
                                                <td class="text-center px-4">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        
                                                        <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" 
                                                                onclick="cargarFormularioEdicion('<?= $log['id'] ?>', '<?= $log['nivel'] ?>', '<?= Html::encode($log['tipo_accion']) ?>')">
                                                            ✏️
                                                        </button>
                                                        
                                                        <?= Html::beginForm(['site/crud-metal'], 'post', ['class' => 'm-0', 'onsubmit' => 'return confirm("¿Seguro que quieres borrar este registro de Firestore?");']) ?>
                                                            <input type="hidden" name="action" value="delete">
                                                            <input type="hidden" name="id" value="<?= $log['id'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">🗑️</button>
                                                        <?= Html::endForm() ?>
                                                    </div>
                                                </td>
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

<script>
function cargarFormularioEdicion(id, nivel, accion) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nivel').value = nivel;
    document.getElementById('edit-accion').value = accion;

    document.getElementById('panel-crear').classList.add('d-none');
    document.getElementById('panel-editar').classList.remove('d-none');
    
    document.getElementById('panel-editar').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function cancelarEdicion() {
    document.getElementById('panel-editar').classList.add('d-none');
    document.getElementById('panel-crear').classList.remove('d-none');
}
</script>