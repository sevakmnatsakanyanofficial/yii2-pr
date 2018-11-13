<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $account_activation_short_code
 * @property string $access_token
 * @property string $email
 * @property string $phone
 * @property string $device_token
 * @property string $authy_id
 * @property integer $verified
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Booking[] $bookings
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const NOT_VERIFIED = 0;
    const VERIFIED = 10;

    /**
     * These are used for rbac controller, user controller in console or other case
     */
    const ROLE_some = some;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'phone'], 'required'],
            [['account_activation_short_code', 'status', 'verified', 'created_at', 'updated_at'], 'integer'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'access_token', 'email', 'device_token', 'authy_id'], 'string', 'max' => 255],
            [['phone'], 'string'],
            [['phone'], 'trim'],
            [['phone'], 'match', 'pattern' => '/^374[0-9]{8,8}$/', 'message' => 'The phone number must learn how to c 374 and contain another 8 digits.'],
            [['phone'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['account_activation_short_code'], 'unique'],
            [['access_token'], 'unique'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['device_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_DELETED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['verified', 'default', 'value' => self::NOT_VERIFIED],
            ['verified', 'in', 'range' => [self::VERIFIED, self::NOT_VERIFIED]],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'account_activation_short_code' => Yii::t('app', 'Account Activation Short Code'),
            'access_token' => Yii::t('app', 'Access Token'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'device_token' => Yii::t('app', 'Device Token'),
            'authy_id' => Yii::t('app', 'Authy ID'),
            'verified' => Yii::t('app', 'Verified'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\queries\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()
            ->where('[[id]]=:id', [':id' => $id])
            ->active()
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->where('[[access_token]]=:access_token', [':access_token' => $token])
            ->active()
            ->one();
    }

    /**
     * Finds user by username
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::find()
            ->where('[[phone]]=:phone', [':phone' => $phone])
            ->active()
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()
            ->where('[[password_reset_token]]=:password_reset_token', [':password_reset_token' => $token])
            ->active()
            ->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function getAccessToken()
    {
        //
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAccessToken($accessToken)
    {
        return $this->getAccessToken() === $accessToken;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates access token key
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . $this->id;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
