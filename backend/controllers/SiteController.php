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
                        'actions' => ['index', 'crud-plastico', 'crud-metal', 'crud-otros'],
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

    public function actionIndex()
    {
        $firebase = new \backend\components\FirebaseService();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            
            if (isset($post['accion_tipo'])) {
                if ($post['accion_tipo'] == 'ajustar') {
                    $firebase->createReporte($post['contenedor'], $post['nivel'], 'Aumento Manual Web');
                } 
                elseif ($post['accion_tipo'] == 'vaciar') {
                    $firebase->createReporte($post['contenedor'], 0, 'Contenedor vaciado Web');
                } 
                elseif ($post['accion_tipo'] == 'manual') {
                    $firebase->createReporte($post['nuevo_nombre'], $post['nuevo_nivel'], 'Ingreso Manual Web');
                }
                
                return $this->refresh();
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