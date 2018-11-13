<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Booking */

$title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Booking',
]) . $model->id;
$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="booking-update">

    <h1><?= Html::encode($title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
