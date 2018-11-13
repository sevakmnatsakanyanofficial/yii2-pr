<?php

namespace api\modules\v1\models;


use yii\helpers\Url;
use yii\web\Linkable;

class Booking extends \api\models\Booking implements Linkable
{
    public function getLinks()
    {
        $links = [];
        if ($this->canCanceled()) {
            return [
                'cancel' => Url::toRoute('bookings/'.$this->id.'/cancel', true),
            ];
        }

        return $links;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingServices()
    {
        
    }

    public function canCanceled()
    {
        if ($this->status === Booking::STATUS_PENDING || $this->status === Booking::STATUS_ACCEPTED) {
            $currentDate = new \DateTime();
            if ($this->start_date > $currentDate->getTimestamp()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     * @return \api\modules\v1\models\queries\BookingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \api\modules\v1\models\queries\BookingQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function extraFields()
    {
        return [];
    }
}