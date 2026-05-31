<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;

// INTERCEPCIÓN ABSOLUTA: Validamos por el objeto excepción, el código de estado, o si el título contiene 'Forbidden'
$esProhibido = false;

if (isset($exception) && method_exists($exception, 'statusCode') && $exception->statusCode == 403) {
    $esProhibido = true;
} elseif (isset($name) && strpos(strtolower($name), 'forbidden') !== false) {
    $esProhibido = true;
}

if ($esProhibido) {
    $mensajeFinal = "Disculpa, estás intentando hacer algo que solo un dios puede hacer, ponte en contacto con los amos y señores del sistema.<br><br><strong>Contacto:</strong> diosito";
} else {
    // Si es un 404 u otro error, se queda el texto original en limpio
    $mensajeFinal = nl2br(Html::encode($message));
}
?>
<div class="site-error container-fluid p-0">
    
    <div class="card border-0 shadow-sm mx-auto mt-5" style="border-radius: 16px; max-width: 650px; overflow: hidden;">
        
        <div class="card-header bg-danger text-white py-3 px-4 d-flex align-items-center gap-2">
            <span class="fs-4">⚠️</span>
            <h5 class="mb-0 fw-bold fs-6"><?= Html::encode($this->title) ?></h5>
        </div>
        
        <div class="card-body p-4 bg-white text-center">
            
            <div class="alert alert-danger border-0 p-4 mb-4 text-center" style="border-radius: 12px; background-color: #fff5f5; color: #dc3545; font-size: 16px; font-weight: 500; line-height: 1.6;">
                <?= $mensajeFinal ?>
            </div>

            <p class="text-secondary small">
                The above error occurred while the Web server was processing your request.
            </p>
            <p class="text-muted small mb-4">
                Please contact us if you think this is a server error. Thank you.
            </p>

            <div class="d-flex justify-content-center">
                <?= Html::a('🏠 Volver al Dashboard Principal', ['site/index'], [
                    'class' => 'btn btn-success fw-bold px-4 py-2 shadow-sm',
                    'style' => 'border-radius: 10px;'
                ]) ?>
            </div>
            
        </div>
    </div>

</div>