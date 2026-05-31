<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form card border-0 shadow-sm p-4 bg-white" style="border-radius: 16px; max-width: 600px;">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'username')->textInput([
            'maxlength' => 255,
            'class' => 'form-control',
            'placeholder' => 'Ej. ervin_balam',
            'style' => 'border-radius:10px;'
        ])->label('Nombre de Usuario (Login)') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'email')->textInput([
            'maxlength' => 255,
            'class' => 'form-control',
            'placeholder' => 'ejemplo@correo.com',
            'style' => 'border-radius:10px;'
        ])->label('Correo Electrónico') ?>
    </div>

    <div class="mb-3">
        <label class="form-label text-dark fw-bold" style="font-size:14px;">
            <?= $model->isNewRecord ? 'Asignar Contraseña de Acceso' : 'Cambiar Contraseña (Dejar vacío para mantener la actual)' ?>
        </label>
        <?= Html::passwordInput('password_plano', '', [
            'class' => 'form-control',
            'placeholder' => $model->isNewRecord ? 'Mínimo 6 caracteres (Obligatorio)' : 'Escribe una nueva contraseña solo si deseas cambiarla',
            'required' => $model->isNewRecord ? true : false, // Obligatorio solo al crear uno nuevo
            'style' => 'border-radius:10px;'
        ]) ?>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'rol_id')->dropDownList($model->rolLista, [ 
                'prompt' => 'Por Favor Elija Uno',
                'class' => 'form-select',
                'style' => 'border-radius:10px;'
            ])->label('Rol de Permisos') ?>
        </div>

        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'estado_id')->dropDownList($model->estadoLista, [ 
                'prompt' => 'Por Favor Elija Uno',
                'class' => 'form-select',
                'style' => 'border-radius:10px;'
            ])->label('Estado de Cuenta') ?>
        </div>
            
        <div class="col-md-4 mb-3">
            <?= $form->field($model, 'tipo_usuario_id')->dropDownList($model->tipoUsuarioLista, [ 
                'prompt' => 'Por Favor Elija Uno',
                'class' => 'form-select',
                'style' => 'border-radius:10px;'
            ])->label('Tipo de Usuario') ?>
        </div>
    </div>

    <div class="form-group mt-3 d-flex gap-2">
        <?= Html::submitButton($model->isNewRecord ? '➕ Crear Usuario con Clave' : '💾 Guardar Cambios', [
            'class' => $model->isNewRecord ? 'btn btn-success fw-bold px-4 py-2' : 'btn btn-primary fw-bold px-4 py-2',
            'style' => 'border-radius:10px;'
        ]) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-light border px-4 py-2', 'style' => 'border-radius:10px;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>