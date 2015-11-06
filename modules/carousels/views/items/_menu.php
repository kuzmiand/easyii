<?php
use yii\helpers\Url;

$action = $this->context->action->id;
$module = $this->context->module->id;

?>
<ul class="nav nav-pills">
    <li <?= ($action === 'index') ? 'class="active"' : '' ?>>

        <?php if($action === 'index') { ?>
            <a href="<?= Url::toRoute(['/admin/'.$module.'/a/index']) ?>">
                <?= Yii::t('easyii', 'List') ?>
            </a>
        <?php }else { ?>
            <a href="<?= $this->context->getReturnUrl(['/admin/'.$module]) ?>">
                <?php if($action === 'edit') : ?>
                    <i class="glyphicon glyphicon-chevron-left font-12"></i>
                <?php endif; ?>
                <?= Yii::t('easyii', 'List') ?>
            </a>
        <?php } ?>

    </li>
    <li <?= ($action === 'create') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/'.$module.'/items/create', 'id'=>$model->carousel_id]) ?>"><?= Yii::t('easyii', 'Create') ?></a></li>
</ul>
<br/>