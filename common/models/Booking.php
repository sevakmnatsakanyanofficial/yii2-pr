<?php

namespace common\models;

use common\behaviors\TranslationBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "{{%booking}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $box_id
 * @property integer $total_amount
 * @property integer $decimal_part
 * @property integer $rated
 *
 * @property Box $box
 * @property User $user
 */
class Booking extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_BLOCK = 'block';
    const SCENARIO_RATED = 'rated';

    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_CANCELED = 'canceled';
    const STATUS_BLOCKED = 'blocked';
    const STATUS_COMPLETED = 'completed';

    const NOT_RATED = 0;
    const RATED = 10;

    /**
     * It is used for get price for each service
     * @var array
     */
    private $_total_amount = 0;
    private $_services_duration = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%booking}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'start_date', 'box_id'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'start_date', 'end_date', 'total_amount', 'decimal_part', 'rated'], 'integer'],
            [['phone'], 'string'],
            [['phone'], 'trim'],
            [['phone'], 'match', 'pattern' => '/^374[0-9]{8,8}$/'],
            [['status'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACCEPTED],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_ACCEPTED, self::STATUS_CANCELED, self::STATUS_BLOCKED, self::STATUS_COMPLETED]],
            ['user_id', 'default', 'value' => function () {
//                if (!Yii::$app->user->id) {
//                    throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
//                }
                return Yii::$app->user->id;
            }],
            ['decimal_part', 'default', 'value' => 100],
            ['rated', 'default', 'value' => self::NOT_RATED],
            ['rated', 'in', 'range' => [self::NOT_RATED, self::RATED]],
            ['start_date', function ($attribute, $params) {
                // validation for 5 minute multiple
                $date = $this->$attribute;
//                $date -= $date % 60;
                if ($date%300 !== 0) {
                    $this->addError($attribute, 'Incorrect booking date');
                }
            }],
            [['box_id'], 'exist', 'skipOnError' => true, 'targetClass' => Box::className(), 'targetAttribute' => ['box_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'decimal_part' => Yii::t('app', 'Decimal Part'),
            'rated' => Yii::t('app', 'Rated'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $result = parent::scenarios();
        $result[self::SCENARIO_BLOCK] = $result[self::SCENARIO_DEFAULT];
        $result[self::SCENARIO_RATED] = $result[self::SCENARIO_DEFAULT];
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingServices()
    {
        return $this->hasMany(BookingService::className(), ['booking_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\queries\BookingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\BookingQuery(get_called_class());
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->_total_amount;
    }

    /**
     * @param $amount
     */
    public function setTotalAmount($amount)
    {
        $this->_total_amount = $amount;
    }

    /**
     * @return int
     */
    public function getServicesDuration()
    {
        return $this->_services_duration;
    }

    /**
     * @param $duration
     */
    public function setServicesDuration($duration)
    {
        $this->_services_duration = $duration;
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function beforeSave($insert)
    {
        $result = parent::beforeSave($insert);
        if ($insert) {
            if ($this->scenario !== self::SCENARIO_BLOCK) {
                $queryResult = (new \yii\db\Query())
                    ->select(['id', 'price', 'time_minutes'])
                    ->from(Table::tableName())
                    ->all();

                if ($queryResult) {
                    //some colculations
                } else {
                    throw new ForbiddenHttpException('Incorrect data');
                }
            }
        }
        if ($this->scenario !== self::SCENARIO_RATED) {
            if ($this->status === self::STATUS_PENDING || $this->status === self::STATUS_ACCEPTED) {
                if (!self::isDateRangeValid(//params)) {
                    throw new ForbiddenHttpException('Incorrect data');
                }
            }
        }
        return $result;
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool|false|int
     * @throws \Exception
     * @throws \Throwable
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = self::getDb()->beginTransaction();
        try {
            $isNewRecord = $this->getIsNewRecord();
            if ($isNewRecord) {
                $result = $this->insert($runValidation);
            } else {
                $result = $this->update($runValidation);
            }

            if ($result === false) {
                $transaction->rollBack();
            } else {
                if ($isNewRecord) {
                    if ($this->scenario !== self::SCENARIO_BLOCK) {
                        $innerTransaction = BookingService::getDb()->beginTransaction();
                        //
                    }
                    $transaction->commit();
                } else {
                    if ($this->status === self::STATUS_CANCELED) {
                        $innerTransaction = Table::getDb()->beginTransaction();
                        try {
                            
                        } catch (\Exception $e) {
                            $innerTransaction->rollBack();
                            throw $e;
                        } catch (\Throwable $e) {
                            $innerTransaction->rollBack();
                            throw $e;
                        }
                        $innerTransaction->commit();
                    }
                    $transaction->commit();
                }
            }

            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Checking for not repeat date range
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public static function isDateRangeValid(//params)
    {
        //

        return true;
    }

    /**
     * Return available times for booking
     * @param $date
     * @param int $duration
     * @return mixed
     */
    public static function getAvailableTimes(//params)
    {
        // Get Current Date
        $currentDate = new \DateTime();

        $beginOfCurrentDay = clone $currentDate;

        $beginOfCurrentDay->modify('today');

        // Get Booking Date
        $bookingDate = new \DateTime();
        $bookingDate->setTimestamp($date);

        $beginOfBookingDay = clone $bookingDate;

        $beginOfBookingDay->modify('today');

        $endOfBookingDay = clone $beginOfBookingDay;
        $endOfBookingDay->modify('tomorrow');
        $endOfBookingDay->modify('1 second ago');

        // Get Timestamps
        $currentDateTimestamp = $currentDate->getTimestamp();
        $beginOfCurrentDayTimestamp = $beginOfCurrentDay->getTimestamp();
        $beginOfBookingDayTimestamp = $beginOfBookingDay->getTimestamp();
        $endOfBookingDayTimestamp = $endOfBookingDay->getTimestamp();

        //
		//
		//

        // Get available times
        $availableTimes = array_diff($fullTimes, $bookingTimes);

        return array_values($availableTimes);
    }

    /**
     * get status to show for user and do not show dev status
     * @param $status
     * @return string
     */
    public static function getStatusForShow($status)
    {
        $result = '';
        switch ($status) {
            case self::STATUS_PENDING:
                $result = Yii::t('app', 'Pending');
                break;
            case self::STATUS_ACCEPTED:
                $result = Yii::t('app', 'Accepted');
                break;
            case self::STATUS_COMPLETED:
                $result = Yii::t('app', 'Completed');
                break;
            case self::STATUS_BLOCKED:
                $result = Yii::t('app', 'Blocked');
                break;
            case self::STATUS_CANCELED:
                $result = Yii::t('app', 'Canceled');
                break;
        }
        return $result;
    }
}
