<?php
namespace api\controllers;


use api\models\User;
use Authy\AuthyApi;
use Yii;
use yii\web\BadRequestHttpException;
use api\models\LoginForm;
use api\models\SignupForm;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends ApiController
{
    public $modelClass = '';

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->checkAccess('login');
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->bodyParams, '') && ($user = $model->login())) {
            $userRoles = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('customer', $userRoles)) {
                return [
                    'success' => true,
                    'data' => [
                        'accessToken' => $user->access_token,
                        'userId' => $user->id,
                    ]
                ];
            } else {
                return [
                    'success' => false,
                ];
            }
        } else {
            return $model;
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->checkAccess('signup');
        $model = new SignupForm();
        $model->scenario = SignupForm::SCENARIO_CUSTOMER;

        $apiKey = Yii::$app->params['twilio']['applicationApiKey'];
        $authyApi = new \Authy_Api($apiKey);

        return [
            'success' => true,
        ];

		// some staps for sms and sign up
    }

    /**
     * Verify user by code from sms and provide access to use the app
     */
    public function actionVerifySmsToken()
    {
        
    }

    /**
     * Resend verification sms if user did not receive
     */
    public function actionResendVerificationSms()
    {
        
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
		
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
		
    }
}
