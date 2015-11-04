<?php

namespace yii\easyii\modules\menu\controllers;

use yii\easyii\components\Controller;
use yii\easyii\modules\menu\models\Menu;
use yii\easyii\modules\menu\models\MenuItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\easyii\behaviors\StatusController;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Base menu module controller
 * @package app\easyii\modules\controllers
 */
class AController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'menu';


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'status' => [
                'class' => StatusController::className(),
                'model' => MenuItem::className(),
            ]
        ];
    }


    /**
     * List all menus
     * @return string
     */
    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Menu::find(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    /**
     * Create a menu
     * @return array|string|Response
     */
    public function actionCreate()
    {
        $model = new Menu();
        $this->layout = 'menu';

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                if ($model->save()) {
                    $this->flash('success', Yii::t('site', 'Menu created'));
                    return $this->redirect(['/admin/' . $this->module->id]);
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
     * Edit menu
     * @param $id
     * @return array|string|Response
     */
    public function actionEdit($id)
    {
        $model = Menu::findOne($id);
        $this->layout = 'menu';

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if(isset($_POST['Menu'])) {
            if ($model->load(Yii::$app->request->post())) {
                if(Yii::$app->request->isAjax){
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
                else{
                    if($model->save()){
                        $this->flash('success', Yii::t('site', 'Menu updated'));
                    }
                    else{
                        $this->flash('error', Yii::t('site', 'Update error. {0}', $model->formatErrors()));
                    }
                    return $this->refresh();
                }
            }
        } else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

//    public function actionDeleteItem($id)
//    {
//        if (($model = MenuItem::findOne($id))) {
//            $model->delete();
//        } else {
//            $this->error = Yii::t('easyii', 'Not found');
//        }
//        return $this->formatResponse(Yii::t('site', 'Menu deleted'));
//    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionUp($id)
    {
        MenuItem::moveUp($id);
        $success = ['swap_id' => $id];
        return $this->formatResponse($success, false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionDown($id)
    {
        MenuItem::moveDown($id);
        $success = ['swap_id' => $id];
        return $this->formatResponse($success, false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionOn($id)
    {
        return $this->changeStatus($id, MenuItem::STATUS_ON);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionOff($id)
    {
        return $this->changeStatus($id, MenuItem::STATUS_OFF);
    }
}