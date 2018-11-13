<?php

namespace common\behaviors;

use common\models\Booking;
use Symfony\Component\Debug\Tests\Fixtures\ClassAlias;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

/**
 * Class TranslationBehavior
 */
class TranslationBehavior extends \yii\base\Behavior
{
    public $translationRelationMethod;
    public $translationRelationName;
    public $language;
    public $attributes = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function init()
    {
        parent::init();
        if (!$this->language) {
            if (Yii::$app->language) {
                $this->language = Yii::$app->language;
            } else {
                $this->language = 'en';
            }
        }

        if (empty($this->attributes)) {
            $this->attributes = ['name'];
        } elseif (is_string($this->attributes)) {
            $this->attributes = [$this->attributes];
        }
    }

    public function afterFind($event)
    {
        $this->initRelations();
        $model = $this->owner;
        if ($model->hasMethod($this->translationRelationMethod)) {
            foreach ($this->attributes as $attribute) {
                $translationModel = $model->getRelation($this->translationRelationName)
                    ->andWhere(['language' => $this->language])
                    ->one();
                if ($translationModel) {
                    $model->{$attribute} = $translationModel->{$attribute};
                }
            }
        }
    }

    private function initRelations()
    {
        $reflect = new \ReflectionClass($this->owner);
        if (!$this->translationRelationMethod) {
            $this->translationRelationMethod = 'get'.$reflect->getShortName().'Translations';
        }

        if (!$this->translationRelationName) {
            $this->translationRelationName = lcfirst ($reflect->getShortName().'Translations');
        }
    }
}