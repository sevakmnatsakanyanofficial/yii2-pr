<?php
namespace api\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends \common\models\LoginForm
{
    public $rememberMe = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // phone and password are both required
            [['phone', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool|User|null
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user) {
                $user->generateAccessToken();
                if ($user->save()) {
                    return $user;
                }
            }
        }

        return false;
    }
}
