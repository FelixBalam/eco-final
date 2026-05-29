<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- ESTILOS -->
    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f1f5f9;
            font-family:'Poppins', sans-serif;
            overflow-x:hidden;
        }

        a{
            text-decoration:none !important;
        }

        /* SIDEBAR */
        .sidebar{
            width:260px;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            background:linear-gradient(180deg,#111827,#1f2937);
            padding:25px 15px;
            overflow-y:auto;
            box-shadow:4px 0 20px rgba(0,0,0,.08);
            z-index:999;
        }

        /* LOGO */
        .logo{
            color:#22c55e;
            font-size:36px;
            font-weight:700;
        }

        .logo-text{
            color:white;
            font-size:15px;
            margin-top:5px;
            opacity:.8;
        }

        /* MENU */
        .menu-title{
            color:#9ca3af;
            font-size:12px;
            text-transform:uppercase;
            margin:25px 10px 10px;
            letter-spacing:1px;
        }

        .sidebar-link{
            display:block;
            padding:14px 18px;
            color:#d1d5db;
            border-radius:14px;
            margin-bottom:8px;
            transition:.3s;
            font-size:15px;
            font-weight:500;
        }

        .sidebar-link:hover{
            background:#22c55e;
            color:white;
            transform:translateX(5px);
        }

        .sidebar-link.active{
            background:#16a34a;
            color:white;
        }

        /* MAIN */
        .main-content{
            margin-left:260px;
            padding:30px;
            min-height:100vh;
        }

        /* TOPBAR */
        .topbar{
            background:white;
            border-radius:20px;
            padding:20px 30px;
            margin-bottom:30px;
            box-shadow:0 4px 15px rgba(0,0,0,.05);
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .topbar-title{
            font-size:28px;
            font-weight:700;
            color:#16a34a;
        }

        /* FOOTER */
        .footer{
            text-align:center;
            margin-top:40px;
            color:#6b7280;
            font-size:14px;
        }

        /* SCROLL */
        ::-webkit-scrollbar{
            width:8px;
        }

        ::-webkit-scrollbar-thumb{
            background:#22c55e;
            border-radius:20px;
        }

    </style>

    <?php $this->head() ?>

</head>

<body>

<?php $this->beginBody() ?>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        ♻ EcoSort
    </div>

    <div class="logo-text">
        Sistema Inteligente
    </div>

    <div class="menu-title">
        Principal
    </div>

    <?= Html::a('🏠 Dashboard', ['/site/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('♻ Tipos de Residuos', ['/tipo-residuo/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('🤖 Sensores', ['/sensor/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('📦 Contenedores', ['/contenedor/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('🚛 Recolección', ['/ruta/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('🔔 Alertas', ['/alerta/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('👷 Empleados', ['/empleado/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('📊 Reportes', ['/reporte/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <div class="menu-title">
        Administración
    </div>

    <?= Html::a('👤 Usuarios', ['/user/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('🛡 Roles', ['/rol/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('📁 Perfiles', ['/perfil/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('⚙ Tipos de Usuario', ['/tipo-usuario/index'], [
        'class' => 'sidebar-link'
    ]) ?>

    <?= Html::a('🔄 Estados', ['/estado/index'], [
        'class' => 'sidebar-link'
    ]) ?>

</div>

<!-- CONTENIDO -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">

        <div class="topbar-title">
            Dashboard Principal
        </div>

        <div>

            <?php if (!Yii::$app->user->isGuest): ?>

                <span style="margin-right:15px;color:#6b7280;">
                    <?= date('d/m/Y') ?>
                </span>

                <?= Html::a(
                    'Cerrar Sesión (' .
                    Yii::$app->user->identity->username .
                    ')',
                    ['/site/logout'],
                    [
                        'data-method' => 'post',
                        'class' => 'btn btn-success'
                    ]
                ) ?>

            <?php endif; ?>

        </div>

    </div>

    <!-- CONTENIDO DINÁMICO -->
    <?= $content ?>

    <!-- FOOTER -->
    <div class="footer">
        © PHANTOMS <?= date('Y') ?> | EcoSort Admin
    </div>

</div>

<?php $this->endBody() ?>

</body>

</html>

<?php $this->endPage() ?>