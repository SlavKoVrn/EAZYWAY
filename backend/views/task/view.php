<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">
    <div class="card">
        <div class="card-body">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user.username',
            'title',
            'description:ntext',
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
        ],
    ]) ?>

        </div>
    </div>
</div>
