<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\helpers\Url;

use kuzmiand\behaviors\multilanguage\input_widget\MultiLanguageActiveField;
use yii\easyii\widgets\RedactorMultiLanguage\RedactorMultiLanguageInput;

?>
<?php $form = ActiveForm::begin([
    'options' => ['class' => 'model-form']
]); ?>

<?= $form->field($model, 'question')->textarea()->widget(MultiLanguageActiveField::className(), ['inputType' => 'textArea', 'inputOptions'=>['rows' => '10', 'style'=>['width'=>'100%']]]) ?>

<?= $form->field($model, 'answer')->textarea()->widget(MultiLanguageActiveField::className(), ['inputType' => 'textArea', 'inputOptions'=>['rows' => '10', 'style'=>['width'=>'100%']]]) ?>


<?/*= $form->field($model, 'question')->widget(Redactor::className(),[
    'options' => [
        'minHeight' => 300,
        'buttons' => ['bold', 'italic', 'unorderedlist', 'link'],
        'linebreaks' => true
    ]
]) */?><!--
--><?/*= $form->field($model, 'answer')->widget(Redactor::className(),[
    'options' => [
        'minHeight' => 300,
        'buttons' => ['bold', 'italic', 'unorderedlist', 'link'],
        'linebreaks' => true
    ]
]) */?>

<?= Html::submitButton(Yii::t('easyii','Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>