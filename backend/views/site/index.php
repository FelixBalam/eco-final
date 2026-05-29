<?php


use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'EcoSort Admin';

?>

<div class="container-fluid p-0">

    

        <!-- CONTENIDO -->
        <div class="col-md-10 offset-md-2 bg-light min-vh-100">

            <!-- NAVBAR SUPERIOR -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">

                <div class="container-fluid">

                    <span class="navbar-brand fw-bold text-success">
                        Dashboard Principal
                    </span>

                    <div class="d-flex align-items-center">

                        <div class="me-3 text-secondary">
                            <?= date('d/m/Y') ?>
                        </div>

                        <div class="dropdown">

                            <button class="btn btn-outline-success dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">

                                <?= Yii::$app->user->identity->username ?? 'Invitado' ?>

                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <?= Html::a(
                                        'Perfil',
                                        ['perfil/index'],
                                        ['class' => 'dropdown-item']
                                    ) ?>
                                </li>

                                <li><hr class="dropdown-divider"></li>

                                <li>
                                    <?= Html::a(
                                        'Cerrar Sesión',
                                        ['site/logout'],
                                        [
                                            'class' => 'dropdown-item',
                                            'data-method' => 'post'
                                        ]
                                    ) ?>
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </nav>

            <!-- CONTENIDO -->
            <div class="container-fluid p-4">

                <!-- BIENVENIDA -->
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body p-5">

                        <div class="row align-items-center">

                            <div class="col-md-8">

                                <h1 class="display-5 fw-bold text-success">
                                    ♻ Sistema Inteligente de Separación de Basura
                                </h1>

                                <p class="lead text-secondary mt-3">

                                    Plataforma empresarial para la administración,
                                    monitoreo y clasificación automática de residuos
                                    reciclables mediante sensores inteligentes.

                                </p>

                                <div class="mt-4">

                                    <?= Html::a(
                                        'Administrar Residuos',
                                        ['tipo-residuo/index'],
                                        [
                                            'class' => 'btn btn-success btn-lg me-2'
                                        ]
                                    ) ?>

                                    <?= Html::a(
                                        'Ver Reportes',
                                        ['reporte/index'],
                                        [
                                            'class' => 'btn btn-outline-dark btn-lg'
                                        ]
                                    ) ?>

                                </div>

                            </div>

                            <div class="col-md-4 text-center">

                                <i class="bi bi-recycle"
                                   style="font-size: 140px; color:#198754;">
                                </i>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- TARJETAS -->
                <div class="row">

                    <div class="col-md-3 mb-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-secondary">
                                            Residuos Procesados
                                        </h6>

                                        <h2 class="fw-bold text-success">
                                            1,245
                                        </h2>

                                    </div>

                                    <div>

                                        <i class="bi bi-recycle"
                                           style="font-size: 45px; color:#198754;">
                                        </i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 mb-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-secondary">
                                            Sensores Activos
                                        </h6>

                                        <h2 class="fw-bold text-primary">
                                            58
                                        </h2>

                                    </div>

                                    <div>

                                        <i class="bi bi-cpu"
                                           style="font-size: 45px; color:#0d6efd;">
                                        </i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 mb-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-secondary">
                                            Contenedores
                                        </h6>

                                        <h2 class="fw-bold text-warning">
                                            132
                                        </h2>

                                    </div>

                                    <div>

                                        <i class="bi bi-trash3"
                                           style="font-size: 45px; color:#ffc107;">
                                        </i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 mb-4">

                        <div class="card border-0 shadow-sm">

                            <div class="card-body">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <h6 class="text-secondary">
                                            Alertas
                                        </h6>

                                        <h2 class="fw-bold text-danger">
                                            4
                                        </h2>

                                    </div>

                                    <div>

                                        <i class="bi bi-bell"
                                           style="font-size: 45px; color:#dc3545;">
                                        </i>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- TABLA -->
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-success text-white">

                        <h5 class="mb-0">
                            Actividad Reciente
                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Ubicación</th>
                                    <th>Fecha</th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr>
                                    <td>#001</td>
                                    <td>Plástico</td>
                                    <td>
                                        <span class="badge bg-success">
                                            Procesado
                                        </span>
                                    </td>
                                    <td>Mérida Centro</td>
                                    <td>26/05/2026</td>
                                </tr>

                                <tr>
                                    <td>#002</td>
                                    <td>Metal</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            Pendiente
                                        </span>
                                    </td>
                                    <td>Zona Norte</td>
                                    <td>26/05/2026</td>
                                </tr>

                                <tr>
                                    <td>#003</td>
                                    <td>Orgánico</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            Clasificado
                                        </span>
                                    </td>
                                    <td>Planta Industrial</td>
                                    <td>26/05/2026</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>