<?php
use yii\easyii\modules\cooperation\models\Cooperation;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('site', 'Menu');

$module = $this->context->module->id;
?>

<?= $this->render('../_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <?php if(IS_ROOT) : ?>
                <th width="50">#</th>
            <?php endif; ?>
            <th><?= Yii::t('easyii', 'Title') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data->models as $item) : ?>
            <tr data-id="<?= $item->primaryKey ?>">
                <?php if(IS_ROOT) : ?>
                    <td><?= $item->primaryKey ?></td>
                <?php endif; ?>
                <td><a href="<?= Url::to(['/admin/'.$module.'/a/edit/', 'id' => $item->primaryKey]) ?>"><?= $item->slug ?></a></td>
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