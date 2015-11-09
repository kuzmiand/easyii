<?php
namespace yii\easyii\modules\file\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\SortableModel;

use kuzmiand\behaviors\multilanguage\MultiLanguageBehavior;
use kuzmiand\behaviors\multilanguage\MultiLanguageTrait;

class File extends \yii\easyii\components\ActiveRecord
{
    use MultiLanguageTrait;

    public static function tableName()
    {
        return 'easyii_files';
    }

    public function rules()
    {
        return [
            [['file', 'file_ru', 'file_it', 'file_sp'], 'file'],
            ['title', 'required'],
            ['title', 'string', 'max' => 128],
            ['title', 'trim'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            [['downloads', 'size'], 'integer'],
            ['time', 'default', 'value' => time()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'file' => Yii::t('easyii', 'File'),
            'slug' => Yii::t('easyii', 'Slug')
        ];
    }

    public function behaviors()
    {
        return [
            SortableModel::className(),
            'seoBehavior' => SeoBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
            'mlBehavior' => [
                'class'    => MultiLanguageBehavior::className(),
                'mlConfig' => [
                    'db_table'         => 'translations_with_string',
                    'attributes'       => ['title', 'file', 'image'],
                    'admin_routes' => [
                        'admin/*',
                    ]
                ],
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert && $this->file !== $this->oldAttributes['file']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['file']);
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        //@unlink(Yii::getAlias('@webroot').$this->file);

        foreach(array_keys(Yii::$app->params['mlConfig']['languages']) as $lang) {
            $file_lang = ($lang != Yii::$app->params['mlConfig']['default_language']) ? 'file_' . $lang : 'file';
            @unlink(Yii::getAlias('@webroot').$this->{$file_lang});
        }
    }
}