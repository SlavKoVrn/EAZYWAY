<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="card">
        <div class="card-body">

    <p>
        <?php // Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['timeout'=>0]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            //'status',
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date('d.m.Y',strtotime($model->created_at));
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date('d.m.Y',strtotime($model->updated_at));
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        // Return false to hide the view button
                        return true;
                    },
                    'update' => function ($model, $key, $index) {
                        // Return false to hide the view button
                        return User::isAdmin();
                    },
                    'delete' => function ($model, $key, $index) {
                        // Return false to hide the view button
                        return User::isAdmin();
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

        </div>
    </div>
</div>
