<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$title = Yii::t('app', 'Users');
$this->title = $title . ' - ' . Yii::$app->params['slogan'];
$this->params['breadcrumbs'][] = $title;
?>
<div class="user-index">

    <h1><?= Html::encode($title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Provider'), ['create-provider'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Create Customer'), ['create-customer'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                 'email:email',
                 'phone',
                 'status',
                 'created_at',
                 'updated_at',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'delete' => function($url, $model, $key) {

                            if ($model->status === User::STATUS_ACTIVE) {
                                return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                    'title' => 'Deactivate',
                                    'aria-label' => 'Deactivate',
                                    'data-pjax' => '0',
                                    'data-confirm' => 'Are you sure you want to deactivate this user?',
                                    'data-method' => 'post',
                                ]);
                            }
                        }
                    ],
                    'template' => '{view} {update} {delete}'
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
