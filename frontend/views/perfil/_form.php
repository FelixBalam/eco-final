<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perfil */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'nombre')->textInput(['maxlength' => 45]) ?>

<?= $form->field($model, 'apellido')->textInput(['maxlength' => 45]) ?>

<?= $form->field($model, 'fecha_nacimiento')->input('date') ?>

<?= $form->field($model, 'genero_id')->dropDownList(
    $model->generoLista,
    ['prompt' => 'Por favor Seleccione Uno']
); ?>

<div class="form-group">
    <?= Html::submitButton(
        $model->isNewRecord ? 'Create' : 'Update',
        [
            'class' => $model->isNewRecord
                ? 'btn btn-success'
                : 'btn btn-primary'
        ]
    ) ?>
</div>

<?php ActiveForm::end(); ?>

</div>