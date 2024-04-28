<?php

namespace common\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kartik\daterange\DateRangeBehavior;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
    public $dateCreatedStart,$dateCreatedEnd;
    public $dateUpdatedStart,$dateUpdatedEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'created_at',
                'dateStartAttribute' => 'dateCreatedStart',
                'dateEndAttribute' => 'dateCreatedEnd',
            ],
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'updated_at',
                'dateStartAttribute' => 'dateUpdatedStart',
                'dateEndAttribute' => 'dateUpdatedEnd',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        if (!User::isAdmin()){
            $query->andWhere(['id' => Yii::$app->user->id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_at){
            $query->andFilterWhere(['between','created_at',
                strtotime(date('Y-m-d 00:00:00',$this->dateCreatedStart)),
                strtotime(date('Y-m-d 23:59:59',$this->dateCreatedEnd))
            ]);
        }

        if ($this->updated_at){
            $query->andFilterWhere(['between','updated_at',
                strtotime(date('Y-m-d 00:00:00',$this->dateUpdatedStart)),
                strtotime(date('Y-m-d 23:59:59',$this->dateUpdatedEnd))
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
