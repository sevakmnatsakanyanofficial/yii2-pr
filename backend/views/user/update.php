<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . $model->id;
$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
