<?php

use yii\helpers\Url;

$this->title = 'EcoSort Enterprise Platform';

?>

<style>

:root{
    --eco-green:#16a34a;
    --eco-dark:#0f172a;
    --eco-light:#f8fafc;
    --eco-gray:#64748b;
}

body{
    background:#f1f5f9;
}

.hero-section{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    border-radius:25px;
    overflow:hidden;
    position:relative;
    color:white;
    box-shadow:0 20px 50px rgba(0,0,0,.15);
}

.hero-section::before{
    content:'';
    position:absolute;
    width:500px;
    height:500px;
    border-radius:50%;
    background:rgba(34,197,94,.15);
    top:-150px;
    right:-150px;
}

.hero-section::after{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    border-radius:50%;
    background:rgba(34,197,94,.10);
    bottom:-100px;
    left:-100px;
}

.kpi-card{
    background:white;
    border:none;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    transition:.3s;
}

.kpi-card:hover{
    transform:translateY(-5px);
}

.module-card{
    border:none;
    border-radius:18px;
    overflow:hidden;
    transition:.3s;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.module-card:hover{
    transform:translateY(-8px);
}

.module-icon{
    font-size:45px;
}

.status-dot{
    width:12px;
    height:12px;
    background:#22c55e;
    border-radius:50%;
    display:inline-block;
}

.section-title{
    font-weight:700;
    color:#0f172a;
}

.tech-badge{
    padding:12px 20px;
    border-radius:30px;
    background:#e2e8f0;
    margin:5px;
    display:inline-block;
    font-weight:600;
}

.quick-btn{
    border-radius:12px;
    padding:12px 20px;
    font-weight:600;
}

</style>

<div class="container-fluid">

```
<div class="hero-section p-5 mb-5">

    <div class="row align-items-center">

        <div class="col-lg-7">

            <span class="badge bg-success mb-3">
                SISTEMA OPERATIVO
            </span>

            <h1 class="display-3 fw-bold">
                ♻ EcoSort
            </h1>

            <h3 class="mb-4">
                Plataforma Inteligente de Clasificación de Residuos
            </h3>

            <p class="lead text-light">

                Solución empresarial para monitoreo IoT,
                clasificación automática, analítica avanzada
                y gestión de residuos en tiempo real.

            </p>

            <div class="mt-4">

                <a href="<?= Url::to(['/site/login']) ?>"
                   class="btn btn-success btn-lg quick-btn">

                    Ingresar al Sistema
                </a>

                <a href="<?= Url::to(['/site/estadisticas']) ?>"
                   class="btn btn-outline-light btn-lg quick-btn">

                    Ver Estadísticas
                </a>

            </div>

        </div>

        <div class="col-lg-5 text-center">

            <img
            src="https://cdn-icons-png.flaticon.com/512/4341/4341134.png"
            class="img-fluid"
            style="max-height:320px;">

        </div>

    </div>

</div>

<div class="row g-4 mb-5">

    <div class="col-md-3">
        <div class="card kpi-card">
            <div class="card-body text-center">
                <h1 class="text-success">3</h1>
                <p>Sensores Activos</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card kpi-card">
            <div class="card-body text-center">
                <h1 class="text-primary">79</h1>
                <p>Eventos Registrados</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card kpi-card">
            <div class="card-body text-center">
                <h1 class="text-warning">99.9%</h1>
                <p>Disponibilidad</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card kpi-card">
            <div class="card-body text-center">
                <h1 class="text-danger">0</h1>
                <p>Alertas Críticas</p>
            </div>
        </div>
    </div>

</div>

<h2 class="section-title mb-4">
    Módulos Operativos
</h2>

<div class="row g-4 mb-5">

    <div class="col-lg-4">
        <div class="card module-card">
            <div class="card-body text-center p-4">

                <div class="module-icon">
                    🥤
                </div>

                <h4>Gestión de Plástico</h4>

                <p>
                    Administración y monitoreo de residuos plásticos.
                </p>

                <a href="<?= Url::to(['/site/crud-plastico']) ?>"
                   class="btn btn-success">

                    Administrar
                </a>

            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card module-card">
            <div class="card-body text-center p-4">

                <div class="module-icon">
                    🔩
                </div>

                <h4>Gestión de Metal</h4>

                <p>
                    Control de residuos metálicos y reciclables.
                </p>

                <a href="<?= Url::to(['/site/crud-metal']) ?>"
                   class="btn btn-success">

                    Administrar
                </a>

            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card module-card">
            <div class="card-body text-center p-4">

                <div class="module-icon">
                    🗑️
                </div>

                <h4>Otros Residuos</h4>

                <p>
                    Gestión integral de residuos generales.
                </p>

                <a href="<?= Url::to(['/site/crud-otros']) ?>"
                   class="btn btn-success">

                    Administrar
                </a>

            </div>
        </div>
    </div>

</div>

<div class="card border-0 shadow-lg">

    <div class="card-header bg-success text-white">

        <h4 class="mb-0">
            Estado de la Plataforma
        </h4>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3">
                <span class="status-dot"></span>
                Firebase Online
            </div>

            <div class="col-md-3">
                <span class="status-dot"></span>
                API Operativa
            </div>

            <div class="col-md-3">
                <span class="status-dot"></span>
                Sensores Conectados
            </div>

            <div class="col-md-3">
                <span class="status-dot"></span>
                Base de Datos Activa
            </div>

        </div>

    </div>

</div>

<div class="text-center mt-5">

    <h2 class="section-title">
        Tecnologías Utilizadas
    </h2>

    <div class="mt-3">

        <span class="tech-badge">Yii2 Advanced</span>
        <span class="tech-badge">Firebase</span>
        <span class="tech-badge">MariaDB</span>
        <span class="tech-badge">Bootstrap 5</span>
        <span class="tech-badge">Chart.js</span>
        <span class="tech-badge">IoT</span>
        <span class="tech-badge">PHP 8</span>

    </div>

</div>
```

</div>
