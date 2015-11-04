<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\Redactor;
use yii\easyii\widgets\SeoForm;

use kuzmiand\behaviors\multilanguage\input_widget\MultiLanguageActiveField;
use yii\easyii\widgets\RedactorMultiLanguage\RedactorMultiLanguageInput;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>

<?= $form->field($model, 'title')->widget(MultiLanguageActiveField::className()) ?>

<?/*= $form->field($model, 'text')->widget(Redactor::className(),[
    'options' => [
        'minHeight' => 400,
        'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'pages']),
        'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'pages']),
        'plugins' => ['fullscreen']
    ]
]) */?>

<?= RedactorMultiLanguageInput::widget($model, 'text', ['options' => [
    'minHeight' => 400,
    'imageUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'news']),
    'fileUpload' => Url::to(['/admin/redactor/upload', 'dir' => 'news']),
    'plugins' => ['fullscreen']
]]); ?>

<?php if(IS_ROOT) : ?>
    <?= $form->field($model, 'slug') ?>
    <?= SeoForm::widget(['model' => $model]) ?>
<?php endif; ?>

<?= Html::submitButton(Yii::t('easyii','Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>