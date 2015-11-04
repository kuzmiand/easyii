<?php
namespace yii\easyii\modules\menu\assets;
use yii\web\AssetBundle;

/**
 * Front site assets package
 *
 * @package app\assets
 */
class MenuAsset extends AssetBundle
{
    public $sourcePath = __DIR__;

    public $css = [
        'tree-view.css',
    ];

    public $js = [
        'main.js'
    ];

    public $depends = [
        'yii\easyii\assets\AdminAsset'
    ];
}
