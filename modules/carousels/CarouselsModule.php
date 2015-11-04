<?php
namespace yii\easyii\modules\carousels;

class CarouselsModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableTitle' => true,
        'enableText' => true,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Carousels',
            'ru' => 'Карусель',
        ],
        'icon' => 'picture',
        'order_num' => 40,
    ];
}