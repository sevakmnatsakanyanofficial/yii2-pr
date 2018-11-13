<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */
/* @var $provider boolean */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$title = Yii::t('app', 'Create Provider');

if (!$provider) {
    $title = Yii::t('app', 'Create Customer');
}

$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
?>
<div class="user-create">
    <h1><?= Html::encode($title) ?></h1>

    <p>Please fill out the following fields to create new user:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['autocomplete' => 'off']]); ?>

                <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
