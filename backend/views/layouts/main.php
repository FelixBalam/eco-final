<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

// Detectar la acción actual para iluminar la opción correcta en el menú
$accionActual = Yii::$app->controller->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            font-size:11px;
            text-transform:uppercase;
            margin:20px 10px 8px;
            letter-spacing:1px;
            font-weight: 700;
        }

        .sidebar-link{
            display:block;
            padding:12px 16px;
            color:#d1d5db;
            border-radius:12px;
            margin-bottom:6px;
            transition:.3s;
            font-size:14px;
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
            font-size:26px;
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

<div class="sidebar">

    <div class="logo">
        ♻ EcoSort
    </div>

    <div class="logo-text">
        Sistema Inteligente
    </div>

    <div class="menu-title">
        Monitoreo y Control
    </div>

    <?= Html::a('🏠 Dashboard Principal', ['/site/index'], [
        'class' => 'sidebar-link' . ($accionActual === 'index' ? ' active' : '')
    ]) ?>

    <div class="menu-title">
        Analítica de Datos
    </div>

    <?= Html::a('📈 Estadísticas Globales', ['/site/estadisticas'], [
        'class' => 'sidebar-link' . ($accionActual === 'estadisticas' ? ' active' : '')
    ]) ?>

    <?= Html::a('🚨 Centro de Alertas', ['/site/alertas-simulador'], [
        'class' => 'sidebar-link' . ($accionActual === 'alertas-simulador' ? ' active' : '')
    ]) ?>

    <div class="menu-title">
        Gestión Individual
    </div>

    <?= Html::a('🥤 Módulo Plástico', ['/site/crud-plastico'], [
        'class' => 'sidebar-link' . ($accionActual === 'crud-plastico' ? ' active' : '')
    ]) ?>

    <?= Html::a('🥫 Módulo Metal', ['/site/crud-metal'], [
        'class' => 'sidebar-link' . ($accionActual === 'crud-metal' ? ' active' : '')
    ]) ?>

    <?= Html::a('🗑️ Módulo Otros', ['/site/crud-otros'], [
        'class' => 'sidebar-link' . ($accionActual === 'crud-otros' ? ' active' : '')
    ]) ?>

    <div class="menu-title">
        Administración
    </div>

    <?= Html::a('👤 Usuarios del Sistema', ['/user/index'], [
        'class' => 'sidebar-link' . ($accionActual === 'index' && Yii::$app->controller->id === 'user' ? ' active' : '')
    ]) ?>

    <?= Html::a('♻️ Catálogo Residuos', ['/site/catalogo-residuos'], [
        'class' => 'sidebar-link' . ($accionActual === 'catalogo-residuos' ? ' active' : '')
    ]) ?>

</div>

<div class="main-content">

    <div class="topbar">
        <div class="topbar-title">
            <?= Html::encode($this->title) ?>
        </div>

        <div>
            <?php if (!Yii::$app->user->isGuest): ?>
                <span style="margin-right:15px;color:#6b7280; font-weight:500;">
                    📅 <?= date('d/m/Y') ?>
                </span>
                <?= Html::a(
                    'Cerrar Sesión (' . Yii::$app->user->identity->username . ')',
                    ['/site/logout'],
                    [
                        'data-method' => 'post',
                        'class' => 'btn btn-sm btn-success fw-bold px-3 py-2',
                        'style' => 'border-radius:10px;'
                    ]
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <?= $content ?>

    <div class="footer">
        © PHANTOMS <?= date('Y') ?> | EcoSort Admin
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>