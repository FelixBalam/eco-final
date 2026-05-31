<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\PermisosHelpers;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'index', 
                            'crud-plastico', 
                            'crud-metal', 
                            'crud-otros',
                            'estadisticas',
                            'alertas-simulador',
                            'catalogo-residuos'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermisosHelpers::requerirMinimoRol('Admin') 
                                && PermisosHelpers::requerirEstado('Activo');
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Dashboard Principal - Procesador de Monitoreo Físico con Redirección Estricta Anti-Duplicados
     */
    public function actionIndex()
    {
        $firebase = new \backend\components\FirebaseService();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            
            if (isset($post['accion_tipo'])) {
                if ($post['accion_tipo'] == 'ajustar' && isset($post['contenedor'], $post['nivel'])) {
                    $firebase->createReporte($post['contenedor'], $post['nivel'], 'Aumento Manual Web');
                } 
                elseif ($post['accion_tipo'] == 'vaciar' && isset($post['contenedor'])) {
                    $firebase->createReporte($post['contenedor'], 0, 'Contenedor vaciado Web');
                } 
                elseif ($post['accion_tipo'] == 'manual' && isset($post['nuevo_nombre'], $post['nuevo_nivel'])) {
                    $firebase->createReporte($post['nuevo_nombre'], $post['nuevo_nivel'], 'Ingreso Manual Web');
                }
                
                // CONTROL DE SEGURIDAD EXTREMA: Limpia la memoria del buffer de salida de Yii
                Yii::$app->response->clearOutputBuffers();
                
                // Redirección absoluta que destruye los datos POST guardados por el navegador
                return $this->redirect(['site/index'])->send();
            }
        }

        $reportes = $firebase->getReportes();

        return $this->render('index', [
            'reportes' => $reportes
        ]);
    }

    /**
     * Módulo del Contenedor de Plástico - Asignado a Jafet
     */
    public function actionCrudPlastico()
    {
        return $this->render('crud_plastico');
    }

    /**
     * Módulo del Contenedor de Metal - Asignado a Alejandra
     */
    public function actionCrudMetal()
    {
        return $this->render('crud_metal');
    }

    /**
     * Módulo del Contenedor de Otros - Asignado a Omar
     */
    public function actionCrudOtros()
    {
        return $this->render('crud_otros');
    }

    /**
     * Módulo de Analítica y Estadísticas con Chart.js
     */
    public function actionEstadisticas()
    {
        return $this->render('estadisticas');
    }

    /**
     * Centro de Alertas Críticas y Avisos de los Contenedores
     */
    public function actionAlertasSimulador()
    {
        return $this->render('alertas_simulador');
    }

    /**
     * Muestra la vista estética del Catálogo de Residuos (Solo Vista para Exposición)
     */
    public function actionCatalogoResiduos()
    {
        return $this->render('catalogo_residuos');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->loginAdmin()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}