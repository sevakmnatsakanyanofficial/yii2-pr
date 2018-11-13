<?php

namespace api\models;


class Booking extends \common\models\Booking
{
    /**
     * @inheritdoc
     * @return \api\models\queries\BookingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \api\models\queries\BookingQuery(get_called_class());
    }
}