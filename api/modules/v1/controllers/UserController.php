<?php
namespace api\modules\v1\controllers;


use Yii;
use api\modules\v1\models\User;
use yii\web\ForbiddenHttpException;


/**
 * Box controller
 */
class UserController extends \api\controllers\ApiController
{
    public $modelClass = 'api\modules\v1\models\User';

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['index'], $actions['delete']);

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
        if ($action === 'update') {
            if ((int)Yii::$app->request->get('id') !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('Can not update not your data');
            }

            // update works for phone or email
            foreach (Yii::$app->request->bodyParams as $key => $value) {
                switch ($key) {
                    case 'id':
                    case 'auth_key':
                    case 'password_hash':
                    case 'password_reset_token':
                    case 'account_activation_short_code':
                    case 'access_token':
                    case 'phone':
                    case 'status':
                    case 'created_at':
                    case 'updated_at':
                        throw new ForbiddenHttpException('Incorrect data');
                        break;
                }
            }
        } elseif ($action === 'view') {
            if ((int)Yii::$app->request->get('id') !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('Can not receive not your data');
            }
        } elseif ($action === 'delete') {
            if ((int)Yii::$app->request->get('id') !== Yii::$app->user->id) {
                throw new ForbiddenHttpException('Can not deactivate not your account');
            }
        }
    }

    /**
     * Deactivate current user
     * @return array
     */
    public function actionDelete()
    {
        $user = User::find()
            ->where('[[id]]=:id', [':id' => Yii::$app->user->id])
            ->one();

        $this->checkAccess('delete', $user);
        if ($user) {
            $user->status = User::STATUS_DELETED;
            if ($user->save()) {
                return [
                    'success' => true,
                ];
            }
        }
        return [
            'success' => false,
        ];
    }
}
