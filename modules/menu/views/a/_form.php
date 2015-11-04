<?php
use kuzmiand\behaviors\multilanguage\input_widget\MultiLanguageActiveField;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$module = $this->context->module->id;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data', 'class' => 'model-form']
]); ?>

<?= $form->field($model, 'slug') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
