<?php

namespace yii\easyii\modules\menu\models;

use Yii;
use yii\easyii\behaviors\SortableModel;
use yii\easyii\components\ActiveRecord;
use yii\validators\BooleanValidator;
use yii\validators\NumberValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use kuzmiand\behaviors\multilanguage\MultiLanguageBehavior;
use kuzmiand\behaviors\multilanguage\MultiLanguageTrait;

/**
 * Menu item model
 * @package app\easyii\modules\menu\models
 *
 * @property int $menu_id
 * @property string $label
 * @property string $path
 */
class MenuItem extends ActiveRecord
{
    use MultiLanguageTrait;

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "easyii_menu_item";
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['parent_id', 'validateParent'],
            ['label', StringValidator::className()],
            ['label', RequiredValidator::className()],
            ['path', StringValidator::className()],
            ['status', BooleanValidator::className()],
            ['order_num', NumberValidator::className()]
        ];
    }

    /**
     * Parent validator
     * @param $attribute string
     */
    public function validateParent($attribute)
    {
        $val = $this->$attribute;
        if($val == $this->menu_item_id) $this->addError($attribute, Yii::t("site", "Recursion")); // check recursion (simple)
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'sortable' => SortableModel::className(),
            'mlBehavior' => [
                'class' => MultiLanguageBehavior::className(),
                'mlConfig' => [
                    'db_table' => 'translations_with_string',
                    'attributes' => ['label'],
                    'admin_routes' => [
                        'admin/*',
                    ]
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'label' => Yii::t("site", "label")
        ];
    }

    /**
     * Get associated menu
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['menu_id' => 'menu_id']);
    }

    /**
     * Get direct children
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'menu_item_id'])->orderBy(["order_num" => SORT_ASC]);
    }

    /**
     * Recalculates order of elements in a node
     * @param int $parent_id
     * @param $menu_id
     */
    public static function fixOrder($parent_id, $menu_id)
    {
        if($parent_id) {
            $row = self::find()->where(['menu_id' => $menu_id, 'parent_id' => $parent_id])->orderBy(["order_num" => SORT_ASC])->all();
        } else {
            $row = self::find()->where(['menu_id' => $menu_id, 'parent_id' => 0])->orderBy(["order_num" => SORT_ASC])->all();
        }

        $i = 0;
        $str = "Fixing order: \n";
        foreach($row as $item) {
            $str .= "(" . $item->primaryKey . "): " . $item->order_num . " -> " . $i. ", \n";
            $item->order_num = $i;
            $i++;
            $item->save(false);
        }

        Yii::trace($str);
    }

    /**
     * Moves an item down one level
     * @param int $pk item primary key
     */
    public static function moveDown($pk)
    {
        /** @var MenuItem $curr */
        $curr = self::findOne($pk);

        self::fixOrder($curr->parent_id, $curr->menu_id);

        /** @var MenuItem $next */
        $next = self::find()->where([
            'menu_id' => $curr->menu_id,
            'parent_id' => $curr->parent_id,
            'order_num' => ($curr->order_num + 1)
        ])->one();

        Yii::trace("next: " . $next->primaryKey . "curr: " . $curr->primaryKey);

        if($curr && $next) {
            $next->order_num = ($next->order_num - 1);
            $curr->order_num = ($curr->order_num + 1);
            $next->save(false);
            $curr->save(false);
        }

    }

    /**
     * Moves an item up one level
     * @param int $pk item primary key
     */
    public static function moveUp($pk)
    {
        /** @var MenuItem $curr */
        $curr = self::findOne($pk);

        self::fixOrder($curr->parent_id, $curr->menu_id);

        /** @var MenuItem $next */
        $next = self::find()->where([
            'parent_id' => $curr->parent_id,
            'order_num' => ($curr->order_num - 1)
        ])->one();


        if($curr && $next) {
            $next->order_num = $next->order_num + 1;
            $curr->order_num = $curr->order_num - 1;
            $next->save(false);
            $curr->save(false);
        }

    }
}