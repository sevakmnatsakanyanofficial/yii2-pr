<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'en',
    'sourceLanguage' => 'en',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'keyPrefix' => 'someprefix_',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            // 'db' => 'mydb',
            // 'sessionTable' => 'my_session',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en',
//                    'fileMap' => [
//                        'app' => 'app.php',
//                        'app/error' => 'error.php',
//                    ],
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en'
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i:s',
            'timeFormat' => 'php:H:i:s',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'AMD',
            //'nullDisplay' => '',
            'locale' => 'hy',
            'timeZone' => 'Asia/Yerevan',
            'defaultTimeZone' => 'Asia/Yerevan',
        ],
        'assetManager' => [
            'appendTimestamp' => true, // it will add timestamp to resource for update browser cache /assets/5515a87c/yii.js?v=1423448645"
//            'linkAssets' => true, // it will add links and now copy resource to webroot directory
            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'sourcePath' => null,   // не опубликовывать комплект
//                    'js' => [
//                        '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
//                    ]
//                ],
//                'yii\web\YiiAsset' => [],
//                'yii\web\JqueryAsset' => [],
//                'yii\bootstrap\BootstrapAsset' => [],
//                'yii\bootstrap\BootstrapPluginAsset' => [],
//                'yii\jui\JuiAsset' => []
            ],
        ],
    ],
];
