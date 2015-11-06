<?php
namespace yii\easyii\modules\feedback\api;

use Yii;
use yii\easyii\modules\feedback\models\Feedback as FeedbackModel;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\easyii\widgets\ReCaptcha;

use yii\easyii\modules\text\api\Text;


/**
 * Feedback module API
 * @package yii\easyii\modules\feedback\api
 *
 * @method static string form(array $options = []) Returns fully worked standalone html form.
 * @method static array save(array $attributes) If you using your own form, this function will be useful for manual saving feedback's.
 */

class Feedback extends \yii\easyii\components\API
{
    const SENT_VAR = 'feedback_sent';

    private $_defaultFormOptions = [
        'errorUrl' => '',
        'successUrl' => ''
    ];

    public function api_form($options = [])
    {
        $model = new FeedbackModel;
        $settings = Yii::$app->getModule('admin')->activeModules['feedback']->settings;
        $options = array_merge($this->_defaultFormOptions, $options);

        ob_start();
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'action' => Url::to(['/admin/feedback/send']),
            'options'=>['class'=>'col form']
        ]);

        echo '<p class="caption">'.Text::get('contact-page-leave-us-a-message').'</p>';

        echo Html::hiddenInput('errorUrl', $options['errorUrl'] ? $options['errorUrl'] : Url::current([self::SENT_VAR => 0]));
        echo Html::hiddenInput('successUrl', $options['successUrl'] ? $options['successUrl'] : Url::current([self::SENT_VAR => 1]));

        echo $form->field($model, 'name', ['options'=>['tag'=>'fieldset'], 'errorOptions' => ['class' => 'msg-error', 'tag'=>'p'], 'template' => '{input}{error}', 'selectors' => ['input' => '#input-001']])->input('text', ['id'=>'input-001', 'placeholder'=>Yii::t( 'all', 'Name')]);

        echo $form->field($model, 'email', ['options'=>['tag'=>'fieldset'], 'errorOptions' => ['class' => 'msg-error', 'tag'=>'p'], 'template' => '{input}{error}', 'selectors' => ['input' => '#input-002']])->input('email', ['id'=>'input-002', 'placeholder'=>Yii::t( 'all', 'Your e-mail')]);


        if($settings['enablePhone']) echo $form->field($model, 'phone');
        if($settings['enableTitle']) echo $form->field($model, 'title');

        echo $form->field($model, 'text', ['options'=>['tag'=>'fieldset'], 'errorOptions' => ['class' => 'msg-error', 'tag'=>'p'], 'template' => '{input}{error}', 'selectors' => ['input' => '#input-005']])->textArea(['rows' => '6','id'=>'input-005', 'placeholder'=>Yii::t( 'all', 'Message text')]);

        if($settings['enableCaptcha']) echo $form->field($model, 'reCaptcha')->widget(ReCaptcha::className());

        echo Html::submitButton(Yii::t('all', 'send a message'), ['class' => 'btn btn-primary']);

        ActiveForm::end();

        return ob_get_clean();
    }

    public function api_save($data)
    {
        $model = new FeedbackModel($data);
        if($model->save()){
            return ['result' => 'success'];
        } else {
            return ['result' => 'error', 'error' => $model->getErrors()];
        }
    }
}