<?php
namespace api\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\ContentNegotiator;

/**
 * Api controller
 */
class ApiController extends ActiveController
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ]
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['login', 'signup'],
            'authMethods' => [
                HttpBearerAuth::className(),
            ],
        ];

        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
//        $behaviors['authenticator']['except'] = ['options'];

        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
//            'text/html' => Response::FORMAT_JSON
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['login', 'signup'],
            'rules' => [
                [
                    'actions' => ['signup'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['login'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ]
        ];

        return $behaviors;
    }

    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws \Exception
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        parent::checkAccess($action, $model, $params);
        if (Yii::$app->request->headers->get('X-Api-Validation-Key') !== Yii::$app->params['apiValidationKey']) {
            throw new ForbiddenHttpException('Api Validation Error');
        }
    }
}
