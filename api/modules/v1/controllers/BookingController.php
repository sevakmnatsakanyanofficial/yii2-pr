<?php
namespace api\modules\v1\controllers;


use Yii;
use api\modules\v1\models\Booking;
use yii\web\ForbiddenHttpException;
use api\modules\v1\models\BookingSearch;


/**
 * Booking controller
 */
class BookingController extends \api\controllers\ApiController
{
    public $modelClass = 'api\modules\v1\models\Booking';

    public $createScenario = Booking::SCENARIO_CREATE;

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        
        unset($actions['view'], $actions['delete'], $actions['update']);

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
        if ($action === 'create') {

            foreach (Yii::$app->request->bodyParams as $key => $value) {
                switch ($key) {
                    case 'id':
                    case 'status':
                    case 'end_date':
                    case 'total_amount':
                    case 'decimal_part':
                    case 'created_at':
                    case 'updated_at':
                    case 'rated':
                        throw new ForbiddenHttpException('Incorrect data');
                        break;
                }
            }
        } elseif ($action === 'available-times') {

        } elseif ($action === 'cancel') {
            if (!$model || $model->user_id !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('You can not update not your data');
            }
        }
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $searchModel = new BookingSearch();
        return $searchModel->search(Yii::$app->request->queryParams, true);
    }

    /**
     * @return null|static
     */
    public function actionCancel()
    {
        $booking = Booking::find()
            ->where('[[id]]=:id', [':id' => Yii::$app->request->get('id')])
            ->one();
        $this->checkAccess('cancel', $booking);
        $booking->status = Booking::STATUS_CANCELED;
        $booking->save();
        return $booking;
    }

    /**
     * 
     */
    public function actionAvailableTimes(//params)
    {
        
    }
}