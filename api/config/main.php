<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
//                'text/html' => yii\web\Response::FORMAT_JSON,
                'application/json' => yii\web\Response::FORMAT_JSON
            ],
            'languages' => [
                'en',
                'ru',
                'hy',
            ],
        ],
    ],
//    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        /*'errorHandler' => [
            'errorAction' => 'site/error',
        ],*/
        'urlManager' => [
            'baseUrl' => '/api',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                /*********************************************** V 1 **************************************************/
//                'OPTIONS <module:v1>/signup' => '<module>/site/options',
//                'POST <module:v1>/signup' => '<module>/site/signup',

                'OPTIONS <module:v1>/login' => '<module>/site/options',
                'POST <module:v1>/login' => '<module>/site/login',

                'OPTIONS <module:v1>/verify-sms-token' => '<module>/site/options',
                'POST <module:v1>/verify-sms-token' => '<module>/site/verify-sms-token',

                'OPTIONS <module:v1>/resend-verification-sms' => '<module>/site/options',
                'POST <module:v1>/resend-verification-sms' => '<module>/site/resend-verification-sms',

                'OPTIONS <module:v1>/<controller:user>s/<id:\d+>' => '<module>/<controller>/options',
                'GET <module:v1>/<controller:user>s/<id:\d+>' => '<module>/<controller>/view',
//                'POST <module:v1>/<controller:user>s' => '<module>/<controller>/create',
                'PUT,PATCH <module:v1>/<controller:user>s/<id:\d+>' => '<module>/<controller>/update',
                'DELETE <module:v1>/<controller:user>s/<id:\d+>' => '<module>/<controller>/delete',
                /******************************************************************************************************/
            ],
        ],
    ],
    'params' => $params,
];
