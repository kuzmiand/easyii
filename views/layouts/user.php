<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\easyii\assets\AdminAsset;

$asset = AdminAsset::register($this);
$moduleName = $this->context->module->id;
?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::t('easyii', 'Control Panel') ?> - <?= Html::encode($this->title) ?></title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= $asset->baseUrl ?>/favicon.ico" type="image/x-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="admin-body">
    <div  style="width: auto; min-width: 1200px">
        <div class="wrapper">
            <div class="header">
                <div class="logo">
                    <img src="<?= $asset->baseUrl ?>/img/logo_20.png">
                    CASEXE CMS
                </div>
                <div class="nav">
                    <a href="<?= Url::to(['/']) ?>" class="pull-left"><i class="glyphicon glyphicon-home"></i> <?= Yii::t('easyii', 'Open site') ?></a>
                    <?php if(!Yii::$app->user->isGuest) { ?>
                        <a href="<?= Url::to(['/logout']) ?>" class="pull-right"><i class="glyphicon glyphicon-log-out"></i> <?= Yii::t('easyii', 'Logout') ?></a>
                        <a href="<?= Url::to(['/user/admin/view', 'id'=>Yii::$app->user->id]) ?>" style="float: right; margin-right: 20px"><i class="glyphicon glyphicon-user"></i> <?= Yii::$app->user->identity->username ?></a>
                    <?php } else{ ?>
                        <a href="<?= Url::to(['/login']) ?>" class="pull-right"><i class="glyphicon glyphicon-log-in"></i> <?= Yii::t('easyii', 'Login') ?></a>
                    <?php } ?>
                </div>
            </div>
            <div class="main">
                <div class="box sidebar">
                    <?php if(Yii::$app->user->identity->isSuperadmin) : ?>
                        <a href="<?= Url::to(['/admin/modules']) ?>" class="menu-item">
                            <i class="glyphicon glyphicon-folder-close"></i>
                            <?= Yii::t('easyii', 'Module CMS') ?>
                        </a>
                        <a href="<?= Url::to(['/user/admin/']) ?>" class="menu-item <?= ($moduleName == 'admin' && $this->context->id == 'admins') ? 'active' :'' ?>">
                            <i class="glyphicon glyphicon-user"></i>
                            <?= Yii::t('easyii', 'Users') ?>
                        </a>
                        <a href="<?= Url::to(['/user/role']) ?>" class="menu-item">
                            <i class="glyphicon glyphicon-knight"></i>
                            <?= Yii::t('easyii', 'Role') ?>
                        </a>
                        <a href="<?= Url::to(['/user/permission']) ?>" class="menu-item">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            <?= Yii::t('easyii', 'Permissions') ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="box content">
                    <div class="page-title">
                        <?= $this->title ?>
                    </div>
                    <div class="container-fluid">
                        <?php foreach(Yii::$app->session->getAllFlashes() as $key => $message) : ?>
                            <div class="alert alert-<?= $key ?>"><?= $message ?></div>
                        <?php endforeach; ?>
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
