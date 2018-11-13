<?php
namespace frontend\controllers;

use common\models\CarType;
use common\models\Booking;
use common\models\Box;
use common\models\Carwash;
use common\models\CarwashService;
use common\models\ServiceType;
use common\models\User;
use Yii;
use frontend\models\ContactForm;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays terms-conditions page
     *
     * @return string
     */
    public function actionTermsConditions()
    {
        return $this->renderPartial('terms-conditions');
    }

    /**
     * Displays privacy-policy page
     *
     * @return string
     */
    public function actionPrivacyPolicy()
    {
        return $this->renderPartial('privacy-policy');
    }
}
