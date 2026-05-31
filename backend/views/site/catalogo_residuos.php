<?php
use yii\helpers\Html;

$this->title = 'Catálogo de Residuos Soportados';
?>

<div class="container-fluid p-0">
    <div class="bg-light min-vh-100 p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-success fw-bold m-0">📚 Catálogo Técnico de Residuos</h2>
                <p class="text-muted m-0 small">Especificaciones, propiedades y tiempos de degradación del ecosistema EcoSort</p>
            </div>
            <button class="btn btn-success fw-bold shadow-sm px-3" style="border-radius: 10px;" onclick="alert('Simulación: Abriendo formulario de alta homologada.');">
                ➕ Agregar Nuevo Residuo
            </button>
        </div>

        <div class="row">
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header bg-success text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold fs-6">🥤 Residuos Plásticos (PET / HDPE)</h5>
                            <span class="badge bg-white text-success fw-bold">RES-PET-01</span>
                        </div>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block text-uppercase">Instrucciones de Separación</label>
                            <span class="small text-dark">Retirar etiquetas, aplastar firmemente y asegurar que no contenga líquidos antes del depósito.</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1">
                                <span class="text-muted">Tiempo de Degradación:</span>
                                <span class="text-danger">450 Años</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 10px;">
                                <div class="progress-bar bg-danger" style="width: 90%"></div>
                            </div>
                        </div>

                        <hr class="opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block small">Recompensa</small>
                                <strong class="text-success">15 pts / Kg</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary py-1 px-2 border-0" onclick="alert('Visualización: Editar propiedades de Plástico.');">✏️</button>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2 border-0" onclick="alert('Visualización: Eliminar Plástico del catálogo.');">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold fs-6">🥫 Latas y Aluminio (Metales)</h5>
                            <span class="badge bg-white text-primary fw-bold">RES-ALU-02</span>
                        </div>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block text-uppercase">Instrucciones de Separación</label>
                            <span class="small text-dark">Lavar ligeramente para remover residuos orgánicos internos. Aplastar de ser posible.</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1">
                                <span class="text-muted">Tiempo de Degradación:</span>
                                <span class="text-warning">100 Años</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 10px;">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>

                        <hr class="opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block small">Recompensa</small>
                                <strong class="text-primary">25 pts / Kg</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary py-1 px-2 border-0">✏️</button>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2 border-0">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header bg-warning text-dark py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold fs-6 text-dark">🗑️ Basura General / Orgánicos</h5>
                            <span class="badge bg-dark text-warning fw-bold">RES-GEN-03</span>
                        </div>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="text-muted small fw-bold d-block text-uppercase">Instrucciones de Separación</label>
                            <span class="small text-dark">Todo desecho que el actuador y los sensores descarten como no reciclable.</span>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1">
                                <span class="text-muted">Tiempo de Degradación:</span>
                                <span class="text-success">4 Semanas</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 10px;">
                                <div class="progress-bar bg-success" style="width: 10%"></div>
                            </div>
                        </div>

                        <hr class="opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block small">Recompensa</small>
                                <strong class="text-dark">2 pts / Kg</strong>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn btn-sm btn-outline-primary py-1 px-2 border-0">✏️</button>
                                <button class="btn btn-sm btn-outline-danger py-1 px-2 border-0">🗑️</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>