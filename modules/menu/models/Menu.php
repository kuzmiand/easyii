<?php

namespace yii\easyii\modules\menu\models;

use Yii;
use yii\easyii\components\ActiveRecord;
use yii\validators\StringValidator;

/**
 * Menu model. Consists of menu itemss
 * @package app\easyii\modules\menu\models
 *
 * @property int $menu_id
 * @property string $name
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "easyii_menu";
    }

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t("site", "Name")
        ];
    }

    public function rules()
    {
        return [
            ['name', StringValidator::className()],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique'],
        ];
    }

    public function behaviors()
    {
        return [
           // behaviors
        ];
    }

    /**
     * Retrieve menu items
     * @return mixed
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['item_id' => 'menu_id'])->sort();
    }

}