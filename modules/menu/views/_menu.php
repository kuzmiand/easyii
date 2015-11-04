<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$controller = $this->context->id;
$module = $this->context->module->id;
?>

<ul class="nav nav-pills">
    <li <?= ($controller === 'a' && $action === 'index') ? 'class="active"' : '' ?>>
        <a href="<?= Url::to(['a/index']) ?>">
            <?php if($controller === 'a' && $action === 'edit'): ?>
                <i class="glyphicon glyphicon-chevron-left font-12"></i>
            <?php endif; ?>
            <?= Yii::t('easyii', 'List') ?>
        </a>
    </li>
    <li <?= ($controller === 'a' && $action === 'create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/'.$module.'/a/create']) ?>"><?= Yii::t('easyii', 'Create') ?></a></li>
</ul>
<br/>