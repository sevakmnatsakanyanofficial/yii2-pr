<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'languagepicker'],
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'dashboard/index',
    'modules' => [],
    'components' => [
        'request' => [
            'baseUrl' => '/backend',
            'csrfParam' => '_csrf-backend',
            'csrfCookie' => [
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', /*'httpOnly' => true, 'secure' => true*/],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
            'cookieParams' => [
//                'httpOnly' => true,
//                'secure' => true
            ]
        ],
        'cookies' => [
            'class' => 'yii\web\Cookie',
//            'httpOnly' => true,
//            'secure' => true
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => '/staff',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',

            // List of available languages (icons only) (or 'en' => 'English', 'de' => 'Deutsch', 'fr' => 'Français')
            'languages' => [
                'en'=>'EN',
                'ru'=>'RU',
                'hy'=>'HY',
            ],
            'cookieName' => 'language',                          // Name of the cookie.
            'expireDays' => 64,                                  // The expiration time of the cookie is 64 days.
            
        ],
    ],
    'params' => $params,
];
