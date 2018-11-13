<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = Yii::t('app', 'Bookings');
$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = $title;
?>
<div class="booking-index">

    <h1><?= Html::encode($title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Booking'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'phone',
            'status',
            // 'created_at',
            // 'updated_at',
            // 'start_date',
            // 'end_date',
            // 'total_amount',
            // 'decimal_part',
            // 'rated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
