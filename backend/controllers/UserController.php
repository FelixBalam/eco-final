<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers; 
use yii\filters\AccessControl;    

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            // Se restringen TODAS las acciones operativas del CRUD de personal
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'], // Obligatorio haber iniciado sesión
                            'matchCallback' => function ($rule, $action) {
                                // CORREGIDO: Usando el método nativo existente en tu PermisosHelpers
                                return PermisosHelpers::requerirMinimoRol('SuperUsuario')
                                    && PermisosHelpers::requerirEstado('Activo');
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model with Native Password Hashing (Corregido sin propiedad status).
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $postData = $this->request->post();
                
                // Capturar el campo personalizado de la contraseña desde el formulario
                $passwordPlano = isset($postData['password_plano']) ? trim($postData['password_plano']) : '';

                if (!empty($passwordPlano)) {
                    // Encriptar contraseña y generar los tokens obligatorios de Yii2
                    $model->setPassword($passwordPlano);
                    $model->generateAuthKey();
                    
                    // Marcas de tiempo de creación y actualización para control interno
                    $model->created_at = time();
                    $model->updated_at = time();

                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    // Mensaje de error manual en el modelo si se envía vacío
                    $model->addError('username', 'Debe asignar una contraseña válida para el acceso.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $postData = $this->request->post();
            $passwordPlano = isset($postData['password_plano']) ? trim($postData['password_plano']) : '';
            
            // Si deciden escribir una contraseña nueva en el formulario, se actualiza el hash
            if (!empty($passwordPlano)) {
                $model->setPassword($passwordPlano);
                $model->generateAuthKey();
            }
            
            $model->updated_at = time();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}