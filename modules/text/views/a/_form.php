<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kuzmiand\behaviors\multilanguage\input_widget\MultiLanguageActiveField;
use yii\easyii\widgets\RedactorMultiLanguage\RedactorMultiLanguageInput;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>

<?= $form->field($model, 'text')->textarea()->widget(MultiLanguageActiveField::className(), ['inputType' => 'textArea', 'inputOptions'=>['rows' => '10', 'style'=>['width'=>'100%']]]) ?>

<?/*= RedactorMultiLanguageInput::widget($model, 'text', ['options' => [
    'minHeight' => 400,
    'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'text']),
    'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'text']),
    'plugins' => ['fullscreen']
]]); */?>

<?= (IS_ROOT) ? $form->field($model, 'slug') : '' ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>