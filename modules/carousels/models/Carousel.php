<?php
namespace yii\easyii\modules\carousels\models;

use Yii;
use yii\behaviors\SluggableBehavior;


class Carousel extends \yii\easyii\components\ActiveRecord
{

    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static function tableName()
    {
        return 'easyii_carousels';
    }

    public function rules()
    {
        return [
            [['title', 'slug'], 'required'],
            ['title', 'trim'],
            ['title', 'string', 'max' => 128],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'slug' => Yii::t('easyii', 'Slug'),
        ];
    }

    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ]
        ];
    }

    public function getItems()
    {
        return $this->hasMany(ItemCarousel::className(), ['carousel_id' => 'carousel_id']);
    }

    public function afterDelete()
    {
        parent::afterDelete();

        foreach ($this->getItems()->all() as $item) {
            $item->delete();
        }
    }
}