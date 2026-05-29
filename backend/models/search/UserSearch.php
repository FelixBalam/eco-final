<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the
 * search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * Attributes
     *
     * @var mixed
     */
    public $rolNombre;
    public $tipoUsuarioNombre;
    public $tipo_usuario_nombre;
    public $tipo_usuario_id;
    public $estadoNombre;
    public $perfilId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rol_id', 'estado_id', 'tipo_usuario_id'], 'integer'],

            [[
                'username',
                'email',
                'created_at',
                'updated_at',
                'rolNombre',
                'estadoNombre',
                'tipoUsuarioNombre',
                'perfilId',
                'tipo_usuario_nombre'
            ], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /**
         * Setup sorting attributes
         */
        $dataProvider->setSort([
            'attributes' => [

                'id',

                'userIdLink' => [
                    'asc' => ['user.id' => SORT_ASC],
                    'desc' => ['user.id' => SORT_DESC],
                    'label' => 'User',
                ],

                'userLink' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                    'label' => 'User',
                ],

                'perfilLink' => [
                    'asc' => ['perfil.id' => SORT_ASC],
                    'desc' => ['perfil.id' => SORT_DESC],
                    'label' => 'Perfil',
                ],

                'rolNombre' => [
                    'asc' => ['rol.rol_nombre' => SORT_ASC],
                    'desc' => ['rol.rol_nombre' => SORT_DESC],
                    'label' => 'Rol',
                ],

                'estadoNombre' => [
                    'asc' => ['estado.estado_nombre' => SORT_ASC],
                    'desc' => ['estado.estado_nombre' => SORT_DESC],
                    'label' => 'Estado',
                ],

                'tipoUsuarioNombre' => [
                    'asc' => ['tipo_usuario.tipo_usuario_nombre' => SORT_ASC],
                    'desc' => ['tipo_usuario.tipo_usuario_nombre' => SORT_DESC],
                    'label' => 'Tipo Usuario',
                ],

                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'label' => 'Created At',
                ],

                'email' => [
                    'asc' => ['email' => SORT_ASC],
                    'desc' => ['email' => SORT_DESC],
                    'label' => 'Email',
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {

            $query->joinWith(['rol'])
                ->joinWith(['estado'])
                ->joinWith(['perfil'])
                ->joinWith(['tipoUsuario']);

            return $dataProvider;
        }

        // filtros principales
        $this->addSearchParameter($query, 'id');
        $this->addSearchParameter($query, 'username', true);
        $this->addSearchParameter($query, 'email', true);
        $this->addSearchParameter($query, 'rol_id');
        $this->addSearchParameter($query, 'estado_id');
        $this->addSearchParameter($query, 'tipo_usuario_id');
        $this->addSearchParameter($query, 'created_at');
        $this->addSearchParameter($query, 'updated_at');

        // filter by role
        $query->joinWith(['rol' => function ($q) {

            $q->andFilterWhere([
                '=',
                'rol.rol_nombre',
                $this->rolNombre
            ]);

        }])

        // filter by estado
        ->joinWith(['estado' => function ($q) {

            $q->andFilterWhere([
                '=',
                'estado.estado_nombre',
                $this->estadoNombre
            ]);

        }])

        // filter by user type
        ->joinWith(['tipoUsuario' => function ($q) {

            $q->andFilterWhere([
                '=',
                'tipo_usuario.tipo_usuario_nombre',
                $this->tipoUsuarioNombre
            ]);

        }])

        // filter by perfil
        ->joinWith(['perfil' => function ($q) {

            $q->andFilterWhere([
                '=',
                'perfil.id',
                $this->perfilId
            ]);

        }]);

        return $dataProvider;
    }

    /**
     * Adds search parameters to query
     *
     * @param $query
     * @param $attribute
     * @param bool $partialMatch
     */
    protected function addSearchParameter($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }

        // evita error trim(null) en PHP 8+
        $value = $this->$modelAttribute ?? '';

        // si está vacío no filtra
        if (trim((string)$value) === '') {
            return;
        }

        /*
         * Right aliasing of columns
         */
        $attribute = "user.$attribute";

        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}