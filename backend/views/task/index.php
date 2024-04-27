<?php

use common\models\Task;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">
    <div class="card">
        <div class="card-body">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['timeout'=>0]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'created_at',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'convertFormat'  => false,
                    'presetDropdown' => true,
                    'pluginOptions'  => [
                        'format'    => 'd.m.Y',
                        'autoclose' => true,
                    ]
                ],
                'value' => function($model){
                    return date('d.m.Y',strtotime($model->created_at));
                }
            ],
            [
                'attribute' => 'updated_at',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'convertFormat'  => false,
                    'presetDropdown' => true,
                    'pluginOptions'  => [
                        'format'    => 'd.m.Y',
                        'autoclose' => true,
                    ]
                ],
                'value' => function($model){
                    return date('d.m.Y',strtotime($model->updated_at));
                }
            ],
            [
                'label' => 'Владелец',
                'attribute' => 'user.username',
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

        </div>
    </div>
</div>
