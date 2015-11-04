<?php
/**
 * @var $model \app\easyii\modules\menu\models\Menu
 */

use yii\easyii\modules\menu\models\MenuItem;
use yii\easyii\modules\menu\widgets\MenuItemForm\MenuItemForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->name;

$module = $this->context->module->id;
?>
<?= $this->render('../_menu') ?>

<h2><?= Yii::t("site", "Edit menu"); ?></h2>
<?= $this->render('_form', ['model' => $model]) ?>

<hr/>

<a class="btn btn-primary" href="<?= Url::to(['/admin/'.$module.'/menu-item/create', 'menu_id' => $model->menu_id]) ?>">
    <?= Yii::t("site", "Add menu item"); ?>
</a>

<?php $items = MenuItem::find()->where(['menu_id' => $model->primaryKey, 'parent_id' => 'NULL'])->orderBy(["order_num" => SORT_ASC])->all(); ?>

<h2><?= Yii::t("site", "Menu items"); ?></h2>
<?php if(!$items): ?>
    <p><?= Yii::t("site", "No results"); ?></p>
<?php else: ?>
    <div class="menu-tree-view">
    <?php
        $printTree = function($items) use (&$printTree, &$module) {
            echo '<ul>';
            foreach($items as $item) {
                $children = $item->getChildren()->all();
                echo '<li>
                    <strong>'.$item->primaryKey.'</strong>:'
                    .'<a href="'.Url::to(['/admin/'.$module.'/menu-item/edit', 'id' => $item->primaryKey]).'">'.$item->label.'</a>'.
                    '<span class="text text-muted">('.$item->path.')</span>'
                    .'<div class="btn-group btn-group-sm" role="group">
                        <a href="'.Url::to(['/admin/'.$module.'/a/up', 'id' => $item->primaryKey]).'" class="btn btn-default move-up" title="'.Yii::t('easyii', 'Move up').'"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a href="'.Url::to(['/admin/'.$module.'/a/down', 'id' => $item->primaryKey]).'" class="btn btn-default move-down" title="'.Yii::t('easyii', 'Move down').'"><span class="glyphicon glyphicon-arrow-down"></span></a>
                        <a href="'.Url::to(['/admin/'.$module.'/menu-item/delete', 'id' => $item->primaryKey]).'" class="btn btn-default confirm-delete" title="'.Yii::t('easyii', 'Delete item').'"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>'
                    .Html::checkbox('', $item->status == MenuItem::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item->primaryKey,
                        'data-link' => Url::to(['/admin/'.$module.'/a']),
                    ]).
                '
                </li>';
                $printTree($children);
            }
            echo '</ul>';
        };

        $printTree($items);
    ?>
    </div>
<?php endif ?>



