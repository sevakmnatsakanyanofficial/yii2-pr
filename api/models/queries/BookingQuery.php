<?php

namespace api\models\queries;

use Yii;

/**
 * This is the ActiveQuery class for [[\api\models\Booking]].
 *
 * @see \api\models\Booking
 */
class BookingQuery extends \common\models\queries\BookingQuery
{
    public function own() {
        return $this->andWhere('[[user_id]]=:userId', [':userId' => Yii::$app->user->id]);
    }
}
