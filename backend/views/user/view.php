<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermisosHelpers;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;

$show_this_nav = PermisosHelpers::requerirMinimoRol('SuperUsuario');

$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view container-fluid">

    <div class="card shadow-sm border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

            <div>
                <h3 class="mb-0">
                    <i class="glyphicon glyphicon-user"></i>
                    <?= Html::encode($this->title) ?>
                </h3>

                <small>
                    Información detallada del usuario
                </small>
            </div>

            <?php if (!Yii::$app->user->isGuest && $show_this_nav): ?>

                <div>

                    <?= Html::a(
                        '<i class="glyphicon glyphicon-pencil"></i> Editar',
                        ['update', 'id' => $model->id],
                        ['class' => 'btn btn-light btn-sm']
                    ) ?>

                    <?= Html::a(
                        '<i class="glyphicon glyphicon-trash"></i> Eliminar',
                        ['delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Seguro que deseas eliminar este usuario?',
                                'method' => 'post',
                            ],
                        ]
                    ) ?>

                </div>

            <?php endif; ?>

        </div>

        <!-- BODY -->
        <div class="card-body">

            <?= DetailView::widget([
                'model' => $model,
                'options' => [
                    'class' => 'table table-striped table-hover detail-view'
                ],

                'attributes' => [

                    [
                        'attribute' => 'perfilLink',
                        'label' => 'Perfil',
                        'format' => 'raw',
                        'value' => $model->getPerfilLink(),
                    ],

                    [
                        'attribute' => 'email',
                        'format' => 'email',
                        'label' => 'Correo Electrónico',
                    ],

                    [
                        'attribute' => 'rolNombre',
                        'label' => 'Rol',
                        'format' => 'raw',
                        'value' =>
                            '<span class="badge bg-primary text-white p-2">'
                            . Html::encode($model->getRolNombre()) .
                            '</span>',
                    ],

                    [
                        'attribute' => 'estadoNombre',
                        'label' => 'Estado',
                        'format' => 'raw',
                        'value' =>
                            '<span class="badge bg-success text-white p-2">'
                            . Html::encode($model->getEstadoNombre()) .
                            '</span>',
                    ],

                    [
                        'attribute' => 'tipoUsuarioNombre',
                        'label' => 'Tipo Usuario',
                        'format' => 'raw',
                        'value' =>
                            '<span class="badge bg-info text-dark p-2">'
                            . Html::encode($model->getTipoUsuarioNombre()) .
                            '</span>',
                    ],

                    [
                        'attribute' => 'created_at',
                        'label' => 'Fecha de Creación',
                        'format' => ['datetime'],
                    ],

                    [
                        'attribute' => 'updated_at',
                        'label' => 'Última Actualización',
                        'format' => ['datetime'],
                    ],

                    [
                        'attribute' => 'id',
                        'label' => 'ID Usuario',
                    ],

                ],
            ]) ?>

        </div>

    </div>

</div>