<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kartik\daterange\DateRangeBehavior;

/**
 * TaskSearch represents the model behind the search form of `common\models\Task`.
 */
class TaskSearch extends Task
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
            [['id', 'user_id'], 'integer'],
            [['title', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Task::find();

        if (!User::isAdmin()){
            $query->andWhere(['user_id' => Yii::$app->user->id]);
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
            $query->andFilterWhere(['between',"UNIX_TIMESTAMP(STR_TO_DATE(created_at, '%Y-%m-%d'))",$this->dateCreatedStart,$this->dateCreatedEnd]);
        }

        if ($this->updated_at){
            $query->andFilterWhere(['between',"UNIX_TIMESTAMP(STR_TO_DATE(updated_at, '%Y-%m-%d'))",$this->dateUpdatedStart,$this->dateUpdatedEnd]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
