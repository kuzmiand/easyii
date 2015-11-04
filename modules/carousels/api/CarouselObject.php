<?php
namespace yii\easyii\modules\carousels\api;

use yii\easyii\components\API;
use yii\helpers\Url;

class CarouselsObject extends \yii\easyii\components\ApiObject
{
    public $image;
    public $link;
    public $title;
    public $text;

    public function getTitle(){
        return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
    }

    public function getText(){
        return LIVE_EDIT ? API::liveEdit($this->model->text, $this->editLink) : $this->model->text;
    }

    public function  getEditLink(){
        return Url::to(['/admin/carousels/a/edit/', 'id' => $this->id]);
    }

}