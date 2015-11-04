<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kuzmiand\behaviors\multilanguage\input_widget\MultiLanguageActiveField;
use yii\easyii\widgets\RedactorMultiLanguage\RedactorMultiLanguageInput;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'options' => ['class' => 'model-form']
]); ?>

<?= $form->field($model, 'title') ?>

<?= $form->field($model, 'slug') ?>

<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>