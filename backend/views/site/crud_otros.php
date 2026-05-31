<?php
use yii\helpers\Html;

$this->title = 'EcoSort - Módulo Otros';
?>
<div class="container-fluid p-0">
    <div class="col-md-10 offset-md-2 bg-light min-vh-100 p-4" style="padding-top: 80px !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-warning fw-bold m-0">🗑️ Gestión de Residuos Generales (Otros)</h2>
                <p class="text-muted m-0 small">Desarrollador Responsable: <strong>Omar</strong></p>
            </div>
            <?= Html::a('← Volver', ['site/index'], ['class' => 'btn btn-outline-secondary fw-bold']) ?>
        </div>

        <div class="card border-0 shadow-sm p-4">
            <div class="py-5 text-center text-muted border border-dashed rounded">
                <i class="bi bi-plus-circle fs-1 text-warning d-block mb-2"></i>
                <p class="m-0">Espacio preparado para el CRUD de Otros de Omar.</p>
            </div>
            </div>
    </div>
</div>