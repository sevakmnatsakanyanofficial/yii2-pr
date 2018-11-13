<?php

namespace provider\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use \yii\web\Controller;

class ProviderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // deny all POST requests
                    [
                        'controllers' => ['dashboard'],
                        'allow' => true,
                        'roles' => ['provider']
                    ],
                    [
//                        'controllers' => ['dashboard'],
                        'allow' => true,
                        'roles' => ['provider']
                    ],
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
