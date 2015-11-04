<?php
/**
 * @var $model MenuItem
 */
use yii\easyii\modules\menu\models\MenuItem;
use yii\helpers\Url;

?>

<ul class="nav nav-pills">
    <li>
        <a href="<?= Url::to(['a/edit', 'id' => $model->menu_id]) ?>">
            <?= Yii::t('easyii', 'Back to menu') ?>
        </a>
    </li>
</ul>
<br/>

<?= $this->render('_form', ['model' => $model]) ?>