<?php

use yii\helpers\Html;

$this->title = 'Логин';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-6 mx-auto mt-5">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Логин</p>

                <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

                <?= $form->field($model, 'email', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

                <?= $form->field($model, 'password', [
                    'options' => ['class' => 'form-group has-feedback'],
                    'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                    'template' => '{beginWrapper}{input}{error}{endWrapper}',
                    'wrapperOptions' => ['class' => 'input-group mb-3']
                ])
                    ->label(false)
                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

                <div class="row">
                    <div class="col-8">
                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => '<div class="icheck-primary">{input}{label}</div>',
                            'labelOptions' => [
                                'class' => ''
                            ],
                            'uncheck' => null
                        ]) ?>
                    </div>
                    <div class="col-4">
                        <?= Html::submitButton('Логин', ['class' => 'btn btn-primary btn-block']) ?>
                    </div>
                </div>

                <?php \yii\bootstrap4\ActiveForm::end(); ?>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>
