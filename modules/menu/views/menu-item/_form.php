<?php
/**
 * @var $model MenuItem
 */
use yii\easyii\modules\menu\models\MenuItem;
use kuzmiand\behaviors\multilanguage\input_widget\MultiLanguageActiveField;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$items = MenuItem::find()->where(['menu_id' => $model->menu_id, 'status'=>1])->all();
$array_items = [];
if(isset($items) && !empty($items)){
    foreach($items as $item){
        $array_items[$item->menu_item_id] = '#'.$item->menu_item_id . ' ' . $item->label . ' (status'. $item->status . ') ';
    }
}
?>

<?php $form = ActiveForm::begin(
    ['id' => 'menu_item_form']
); ?>
<?= $form->field($model, 'label')->widget(MultiLanguageActiveField::className()) ?>
<?= $form->field($model, 'path') ?>
<?//= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::merge(['NULL' => 'None (make root)'], ArrayHelper::map(MenuItem::find()->where(['menu_id' => $model->menu_id, 'status'=>1])->all(), 'menu_item_id', 'menu_item_id' , 'label'))) ?>
<?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::merge(['NULL' => 'None (make root)'], $array_items)) ?>
<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
