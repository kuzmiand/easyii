<?php
namespace yii\easyii\modules\carousels\models;

use Yii;
use yii\easyii\behaviors\CacheFlush;
use yii\easyii\behaviors\SortableModel;

use kuzmiand\behaviors\multilanguage\MultiLanguageBehavior;
use kuzmiand\behaviors\multilanguage\MultiLanguageTrait;

class ItemCarousel extends \yii\easyii\components\ActiveRecord
{
    use MultiLanguageTrait;

    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    const CACHE_KEY = 'easyii_carousels_items';

    public static function tableName()
    {
        return 'easyii_carousels_items';
    }

    public function rules()
    {
        return [
            ['image', 'image'],
            [['title', 'text', 'link'], 'trim'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => Yii::t('easyii', 'Image'),
            'link' =>  Yii::t('easyii', 'Link'),
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            SortableModel::className(),
            'mlBehavior' => [
                'class' => MultiLanguageBehavior::className(),
                'mlConfig' => [
                    'db_table' => 'translations_with_string',
                    'attributes' => ['title', 'short', 'text'],
                    'admin_routes' => [
                        'admin/*'
                    ],
                ],
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        @unlink(Yii::getAlias('@webroot').$this->image);
    }
}