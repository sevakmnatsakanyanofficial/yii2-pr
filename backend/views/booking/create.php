<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Booking */

$title = Yii::t('app', 'Create Booking');
$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bookings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $title;
?>
<div class="booking-create">

    <h1><?= Html::encode($title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
