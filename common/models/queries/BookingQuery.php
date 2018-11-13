<?php

namespace common\models\queries;

use common\models\Booking;
use Yii;

/**
 * This is the ActiveQuery class for [[\common\models\Booking]].
 *
 * @see \common\models\Booking
 */
class BookingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function pending() {
        return $this->andWhere('[[booking.status]]=:status', [':status' => Booking::STATUS_PENDING]);
    }

    public function accepted() {
        return $this->andWhere('[[booking.status]]=:status', [':status' => Booking::STATUS_ACCEPTED]);
    }

    public function canceled() {
        return $this->andWhere('[[booking.status]]=:status', [':status' => Booking::STATUS_CANCELED]);
    }

    public function blocked() {
        return $this->andWhere('[[booking.status]]=:status', [':status' => Booking::STATUS_BLOCKED]);
    }

    public function completed() {
        return $this->andWhere('[[booking.status]]=:status', [':status' => Booking::STATUS_COMPLETED]);
    }

    public function rated() {
        return $this->andWhere(['booking.rated' => Booking::RATED]);
    }

    public function notRated() {
        return $this->andWhere(['booking.rated' => Booking::NOT_RATED]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Booking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Booking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
