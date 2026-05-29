<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Iniciar Sesión';

?>

<style>

    body{
        background: linear-gradient(135deg,#0f172a,#1e293b);
        min-height:100vh;
        font-family:'Poppins', sans-serif;
    }

    .login-container{
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:20px;
    }

    .login-card{
        width:100%;
        max-width:450px;
        background:white;
        border-radius:25px;
        padding:45px;
        box-shadow:0 20px 40px rgba(0,0,0,.25);
        animation:fadeIn .7s ease;
    }

    @keyframes fadeIn{
        from{
            opacity:0;
            transform:translateY(20px);
        }
        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .logo{
        font-size:70px;
        text-align:center;
        margin-bottom:10px;
    }

    .title{
        text-align:center;
        font-size:36px;
        font-weight:700;
        color:#16a34a;
        margin-bottom:5px;
    }

    .subtitle{
        text-align:center;
        color:#6b7280;
        margin-bottom:35px;
    }

    .form-control{
        border-radius:12px;
        padding:14px;
        border:1px solid #d1d5db;
        box-shadow:none !important;
    }

    .form-control:focus{
        border-color:#16a34a;
        box-shadow:0 0 0 0.2rem rgba(22,163,74,.15) !important;
    }

    .form-check-input:checked{
        background-color:#16a34a;
        border-color:#16a34a;
    }

    .btn-login{
        width:100%;
        padding:14px;
        border:none;
        border-radius:12px;
        background:#16a34a;
        color:white;
        font-size:16px;
        font-weight:600;
        transition:.3s;
    }

    .btn-login:hover{
        background:#15803d;
        transform:translateY(-2px);
    }

    .footer-text{
        text-align:center;
        margin-top:25px;
        color:#9ca3af;
        font-size:14px;
    }

</style>

<div class="login-container">

    <div class="login-card">

        <!-- LOGO -->
        <div class="logo">
            ♻
        </div>

        <!-- TITULO -->
        <div class="title">
            EcoSort
        </div>

        <div class="subtitle">
            Sistema Inteligente de Separación de Basura
        </div>

        <!-- FORMULARIO -->
        <?php $form = ActiveForm::begin([
            'id' => 'login-form'
        ]); ?>

            <?= $form->field($model, 'username')
                ->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Ingrese su usuario'
                ]) ?>

            <?= $form->field($model, 'password')
                ->passwordInput([
                    'placeholder' => 'Ingrese su contraseña'
                ]) ?>

            <?= $form->field($model, 'rememberMe')
                ->checkbox([
                    'template' => "
                        <div class='form-check'>
                            {input}
                            <label class='form-check-label'>
                                Recordarme
                            </label>
                        </div>
                        {error}
                    "
                ]) ?>

            <div class="mt-4">

                <?= Html::submitButton(
                    'Iniciar Sesión',
                    [
                        'class' => 'btn-login',
                        'name' => 'login-button'
                    ]
                ) ?>

            </div>

        <?php ActiveForm::end(); ?>

        <!-- FOOTER -->
        <div class="footer-text">

            © <?= date('Y') ?> PHANTOMS | EcoSort Admin

        </div>

    </div>

</div>