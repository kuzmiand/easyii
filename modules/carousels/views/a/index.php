<?php
use yii\easyii\modules\carousels\models\Carousel;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('easyii/carousel', 'Carousel');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <?php if(IS_ROOT) : ?>
                    <th width="50">#</th>
                <?php endif; ?>
                <th><?= Yii::t('easyii', 'Title') ?></th>
                <th><?= Yii::t('easyii', 'Slug')?></th>
                <th><?= Yii::t('easyii', 'Status') ?></th>
                <th width="60"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data->models as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/admin/'.$module.'/items/index', 'id' => $item->primaryKey]) ?>"><?= $item->title ?></a></td>
                <td><?= $item->slug ?></td>

                <td>
                    <?= Html::checkbox('', $item->status == Carousel::STATUS_ON, [
                        'class' => 'switch',
                        'data-id' => $item->primaryKey,
                        'data-link' => Url::to(['/admin/'.$module.'/a/']),
                    ]) ?>
                </td>
                <td>
                    <a href="<?= Url::to(['/admin/'.$module.'/a/edit', 'id' => $item->primaryKey]) ?>" class="glyphicon glyphicon-edit" title="<?= Yii::t('easyii', 'Edit item')?>"></a>
                    <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="glyphicon glyphicon-remove confirm-delete" title="<?= Yii::t('easyii', 'Delete item')?>"></a>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>