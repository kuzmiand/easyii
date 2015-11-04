<?php
namespace yii\easyii\modules\carousels\api;

use Yii;
use yii\easyii\components\API;
use yii\easyii\helpers\Data;
use yii\easyii\modules\carousels\models\Carousels as CarouselsModel;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Carousels module API
 * @package yii\easyii\modules\carousels\api
 * @method static string widget(int $width, int $height, array $clientOptions = []) Bootstrap carousels widget
 * @method static array items() array of all Carousels items as CarouselsObject objects. Useful to create carousels on other widgets.
 */

class Carousels extends API
{
    public $clientOptions = ['interval' => 5000];

    private $_items = [];

    public function init()
    {
        parent::init();

        /*$this->_items = Data::cache(CarouselsModel::CACHE_KEY, 3600, function(){
            $items = [];
            foreach(CarouselsModel::find()->status(CarouselsModel::STATUS_ON)->sort()->all() as $item){
                $items[] = new CarouselsObject($item);
            }
            return $items;
        });*/

        $items = [];
        foreach(CarouselsModel::find()->status(CarouselsModel::STATUS_ON)->sort()->all() as $item){
            $items[] = new CarouselsObject($item);
        }
        $this->_items = $items;
    }

    public function api_widget($width, $height, $clientOptions = [])
    {
        if(!count($this->_items)){
            return LIVE_EDIT ? Html::a(Yii::t('easyii/carousels/api', 'Create carousels'), ['/admin/carousels/a/create'], ['target' => '_blank']) : '';
        }
        if(count($clientOptions)){
            $this->clientOptions = array_merge($this->clientOptions, $clientOptions);
        }

        $items = [];
        foreach($this->_items as $item){
            $temp = [
                'content' => Html::img($item->thumb($width, $height)),
                'caption' => ''
            ];
            if($item->link) {
                $temp['content'] = Html::a($temp['content'], $item->link);
            }
            if($item->title){
                $temp['caption'] .= '<h3>' . $item->title . '</h3>';
            }
            if($item->text){
                $temp['caption'] .= '<p>'.$item->text.'</p>';
            }
            $items[] = $temp;
        }

        $widget = \yii\bootstrap\Carousels::widget([
            'options' => ['class' => 'slide'],
            'clientOptions' => $this->clientOptions,
            'items' => $items
        ]);

        return LIVE_EDIT ? API::liveEdit($widget, Url::to(['/admin/carousels']), 'div') : $widget;
    }

    public function api_items()
    {
        return $this->_items;
    }
}