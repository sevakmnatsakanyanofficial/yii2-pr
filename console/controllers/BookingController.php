<?php

namespace console\controllers;

use common\models\Booking;
use console\models\Notification;
use Yii;
use yii\console\Controller;

class BookingController extends Controller
{
    /**
     * Set booking to completed which end date is lost date
     * And Send push notification for completed bookings
     */
    public function actionSetCompleted()
    {
        
    }

    /**
     * Send reminder every 5 minutes
     */
    public function actionSendReminder()
    {
        // via google cloud messaging
    }
}