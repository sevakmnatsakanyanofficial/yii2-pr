<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$title = 'Login';
$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = $title;
?>
<div class="site-login">
    <h1><?= Html::encode($title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['autocomplete' => 'off']]); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
