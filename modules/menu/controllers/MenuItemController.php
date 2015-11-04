<?php

namespace yii\easyii\modules\menu\controllers;

use yii\easyii\components\Controller;
use yii\easyii\modules\menu\models\MenuItem;
use Yii;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\StatusController;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class MenuItem
 * @package app\easyii\modules\menu\MenuItem
 */
class MenuItemController extends Controller
{

    public $layout = 'menu';

    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => MenuItem::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => MenuItem::className()
            ],
        ];
    }

    /**
     * Create a menu item
     * @return array|string|Response
     */
    public function actionCreate($menu_id)
    {
        $model = new MenuItem();
        if(!$model->menu_id) {
            $model->menu_id = $menu_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if ($model->save()) {
                    $this->flash('success', Yii::t('site', 'Menu item created'));
                    return $this->redirect(['/admin/' . $this->module->id.'/a/edit', 'id' => $model->menu_id]);
                } else {
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (($model = MenuItem::findOne($id))) {
            if(isset($model->children)&& !empty($model->children)){
                foreach($model->children as $child){
                    $child->parent_id = 0;
                    $child->status = 0;
                    $child->update();
                }
            }

            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('site', 'Menu item deleted'));
    }

    /**
     * Edit menu
     * @param $id
     * @return array|string|Response
     */
    public function actionEdit($id)
    {
        $model = MenuItem::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if($model->save()){
                    $this->flash('success', Yii::t('site', 'Menu item updated'));
                }
                else{
                    $this->flash('error', Yii::t('site', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

}