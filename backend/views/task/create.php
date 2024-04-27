<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">
    <div class="card">
        <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>
</div>
