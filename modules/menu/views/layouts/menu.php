<?php
/**
 * @var $this \yii\web\View
 */

use yii\easyii\modules\menu\assets\MenuAsset;

MenuAsset::register($this);

$this->beginContent('@easyii/views/layouts/main.php'); ?>

<?= $content ?>

<?php $this->endContent();