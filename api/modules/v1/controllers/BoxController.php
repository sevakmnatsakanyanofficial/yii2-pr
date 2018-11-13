<?php
namespace api\modules\v1\controllers;


use Yii;
use api\modules\v1\models\BoxSearch;


/**
 * Box controller
 */
class BoxController extends \api\controllers\ApiController
{
    public $modelClass = 'api\modules\v1\models\Box';

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['view'], $actions['update'] , $actions['delete']);

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new BoxSearch();
        return $searchModel->search(Yii::$app->request->queryParams, false);
    }
}
