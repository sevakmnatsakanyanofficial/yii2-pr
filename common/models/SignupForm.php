<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const SCENARIO_PROVIDER = 'provider';
    const SCENARIO_CUSTOMER = 'customer';

    public $phone;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            [['phone'], 'string'],
            [['phone'], 'trim'],
            [['phone'], 'match', 'pattern' => '/^374[0-9]{8,8}$/', 'message' => 'The phone number must learn how to c 374 and contain another 8 digits.'],
            [['phone'], 'unique', 'targetClass' => '\common\models\User', 'message' => 'This phone number has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PROVIDER] = ['phone', 'password'];
        $scenarios[self::SCENARIO_CUSTOMER] = ['phone', 'password'];
        $scenarios[self::SCENARIO_STAFF] = ['phone', 'password'];
        return $scenarios;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = Yii::$app->db->beginTransaction();

        $user = new User();
        $user->status = User::STATUS_DELETED;
        $user->verified = User::NOT_VERIFIED;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            // add roles for user customer
            $auth = Yii::$app->authManager;
            if ($this->getScenario() == self::SCENARIO_CUSTOMER) {
                $customerRole = $auth->getRole('customer');
            } elseif ($this->getScenario() == self::SCENARIO_PROVIDER) {
                $customerRole = $auth->getRole('provider');
            } else {
                $transaction->rollBack();
                return null;
            }

            $auth->assign($customerRole, $user->getId());

            $transaction->commit();
            return $user;
        } else {
            $transaction->rollBack();
            return null;
        }
    }
}
