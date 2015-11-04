<?php

use yii\db\Migration;

use yii\db\Schema;
use yii\easyii\models;

use yii\easyii\modules\carousels\models\Carousel as Carousels;
use yii\easyii\modules\carousels\models\ItemCarousel;

class m151104_143306_create_news_modules_carousels extends Migration
{
    const VERSION = 0.9;

    public $engine = 'ENGINE=MyISAM DEFAULT CHARSET=utf8';

    public function up()
    {
        $this->createTable(Carousels::tableName(), [
            'carousel_id' => 'pk',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'slug' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);

        $this->createTable(ItemCarousel::tableName(), [
            'item_id'=>'pk',
            'carousel_id' => Schema::TYPE_INTEGER,
            'image' => Schema::TYPE_STRING . '(128) NOT NULL',
            'link' => Schema::TYPE_STRING . '(255) NOT NULL',
            'title' => Schema::TYPE_STRING . '(128) DEFAULT NULL',
            'text' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'order_num' => Schema::TYPE_INTEGER,
            'status' => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ], $this->engine);
    }

    public function down()
    {
        $this->dropTable(Carousels::tableName());
        $this->dropTable(ItemCarousel::tableName());
    }

}
