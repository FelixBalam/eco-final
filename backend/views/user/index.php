<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Panel de Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body{
        background: #f4f6f9;
    }

    .page-title{
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .page-subtitle{
        color: #6b7280;
        font-size: 0.95rem;
    }

    .main-card{
        border: none;
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,.08);
    }

    .main-card-header{
        background: linear-gradient(135deg, #0f172a, #1e293b);
        padding: 25px 30px;
        border: none;
    }

    .main-card-header h3{
        color: white;
        margin: 0;
        font-weight: 700;
    }

    .main-card-header p{
        color: rgba(255,255,255,.7);
        margin: 5px 0 0;
    }

    .btn-modern{
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 600;
        transition: .2s ease;
    }

    .btn-modern:hover{
        transform: translateY(-2px);
    }

    .search-card{
        border: none;
        border-radius: 14px;
        background: #f9fafb;
    }

    .table{
        margin-bottom: 0;
    }

    .table thead{
        background: #111827;
        color: white;
    }

    .table thead th{
        border: none !important;
        font-size: .9rem;
        font-weight: 600;
        padding: 16px;
        vertical-align: middle;
    }

    .table td{
        padding: 16px;
        vertical-align: middle;
        border-color: #eef2f7;
    }

    .table-hover tbody tr:hover{
        background: #f8fafc;
        transition: .2s;
    }

    .badge-role{
        background: #2563eb;
        color: white;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: .8rem;
        font-weight: 600;
    }

    .badge-status{
        background: #10b981;
        color: white;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: .8rem;
        font-weight: 600;
    }

    .user-link{
        color: #111827;
        font-weight: 600;
        text-decoration: none;
    }

    .user-link:hover{
        color: #2563eb;
    }

    .action-buttons .btn{
        border-radius: 10px;
        margin-right: 5px;
        padding: 6px 10px;
    }

    .summary{
        padding: 15px 0;
        color: #6b7280;
        font-weight: 500;
    }

    .pagination li a,
    .pagination li span{
        border-radius: 10px !important;
        margin: 0 3px;
        border: none !important;
        color: #374151;
    }

    .pagination .active a{
        background: #2563eb !important;
    }

</style>

<div class="container-fluid py-4">

    <!-- TITULO -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <div class="page-title">
                <?= Html::encode($this->title) ?>
            </div>

            <div class="page-subtitle">
                Administración corporativa de usuarios y accesos del sistema
            </div>
        </div>

        <div>
            <?= Html::a(
                '<i class="fa fa-plus"></i> Nuevo Usuario',
                ['create'],
                [
                    'class' => 'btn btn-primary btn-modern'
                ]
            ) ?>
        </div>

    </div>

    <!-- CARD PRINCIPAL -->
    <div class="card main-card">

        <!-- HEADER -->
        <div class="main-card-header d-flex justify-content-between align-items-center">

            <div>
                <h3>
                    Gestión de Usuarios
                </h3>

                <p>
                    Visualización, control y administración del personal registrado
                </p>
            </div>

            <div>
                <button class="btn btn-light btn-modern"
                        data-bs-toggle="collapse"
                        data-bs-target="#searchPanel">

                    <i class="fa fa-search"></i>
                    Filtros Avanzados
                </button>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-4">

            <!-- BUSQUEDA -->
            <div class="collapse mb-4" id="searchPanel">

                <div class="card search-card">

                    <div class="card-body">

                        <?= $this->render('_search', [
                            'model' => $searchModel
                        ]) ?>

                    </div>

                </div>

            </div>

            <?php Pjax::begin(); ?>

            <!-- TABLA -->
            <div class="table-responsive">

                <?= GridView::widget([

                    'dataProvider' => $dataProvider,
                    'filterModel' => null,

                    'tableOptions' => [
                        'class' => 'table table-hover align-middle'
                    ],

                    'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-end'>{pager}</div>",

                    'columns' => [

                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => '#',
                        ],

                        [
                            'attribute' => 'userLink',
                            'label' => 'Usuario',
                            'format' => 'raw',

                            'value' => function ($model) {

                                return '
                                    <div>
                                        <div class="fw-bold">
                                            '.$model->username.'
                                        </div>

                                        <small class="text-muted">
                                            ID: '.$model->id.'
                                        </small>
                                    </div>
                                ';
                            }
                        ],

                        [
                            'attribute' => 'email',
                            'label' => 'Correo Electrónico',
                            'format' => 'raw',

                            'value' => function ($model) {

                                return '
                                    <div>
                                        <i class="fa fa-envelope text-primary"></i>
                                        '.$model->email.'
                                    </div>
                                ';
                            }
                        ],

                        [
                            'label' => 'Rol',
                            'format' => 'raw',

                            'value' => function ($model) {

                                $rol = $model->rol
                                    ? $model->rol->rol_nombre
                                    : 'Sin Rol';

                                return '
                                    <span class="badge-role">
                                        '.$rol.'
                                    </span>
                                ';
                            }
                        ],

                        [
                            'label' => 'Estado',
                            'format' => 'raw',

                            'value' => function ($model) {

                                $estado = $model->estado
                                    ? $model->estado->estado_nombre
                                    : 'Sin Estado';

                                return '
                                    <span class="badge-status">
                                        '.$estado.'
                                    </span>
                                ';
                            }
                        ],

                        [
                            'attribute' => 'created_at',
                            'label' => 'Registro',

                            'format' => ['datetime'],
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',

                            'header' => 'Acciones',

                            'contentOptions' => [
                                'class' => 'action-buttons'
                            ],

                            'template' => '{view} {update} {delete}',

                            'buttons' => [

                                'view' => function ($url) {

                                    return Html::a(
                                        '<i class="fa fa-eye"></i>',
                                        $url,
                                        [
                                            'class' => 'btn btn-info btn-sm',
                                            'title' => 'Ver'
                                        ]
                                    );
                                },

                                'update' => function ($url) {

                                    return Html::a(
                                        '<i class="fa fa-pen"></i>',
                                        $url,
                                        [
                                            'class' => 'btn btn-warning btn-sm',
                                            'title' => 'Editar'
                                        ]
                                    );
                                },

                                'delete' => function ($url) {

                                    return Html::a(
                                        '<i class="fa fa-trash"></i>',
                                        $url,
                                        [
                                            'class' => 'btn btn-danger btn-sm',
                                            'title' => 'Eliminar',

                                            'data-confirm' =>
                                                '¿Deseas eliminar este usuario?',

                                            'data-method' => 'post',
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>

            </div>

            <?php Pjax::end(); ?>

        </div>

    </div>

</div>