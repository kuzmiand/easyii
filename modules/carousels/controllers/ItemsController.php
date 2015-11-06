<?php
namespace yii\easyii\modules\carousels\controllers;

use Yii;
use yii\easyii\behaviors\SortableController;
use yii\easyii\behaviors\StatusController;
use yii\web\UploadedFile;

use yii\easyii\components\Controller;
use yii\easyii\modules\carousels\models\Carousel;
use yii\easyii\modules\carousels\models\ItemCarousel;
use yii\easyii\helpers\Image;
use yii\widgets\ActiveForm;

class ItemsController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableController::className(),
                'model' => ItemCarousel::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => ItemCarousel::className()
            ]
        ];
    }

    public function actionIndex($id)
    {
        if(!($model = Carousel::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }


    public function actionCreate($id)
    {
        if(!($category = Carousel::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        $model = new ItemCarousel();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                $model->carousel_id = $category->primaryKey;

                if(($fileInstanse = UploadedFile::getInstance($model, 'image')))
                {
                    $model->image = $fileInstanse;
                    if($model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'carousel');
                        $model->status = Carousel::STATUS_ON;

                        if($model->save()){
                            $this->flash('success', Yii::t('easyii/carousel', 'Carousel created'));
                            return $this->redirect(['/admin/'.$this->module->id]);
                        }
                        else{
                            $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                        }
                    }
                    else {
                        $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    }
                }
                else {
                    $this->flash('error', Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => $model->getAttributeLabel('image')]));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'category' => $category,
            ]);
        }
    }

    public function actionEdit($id)
    {
        if(!($model = ItemCarousel::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else {
                if(($fileInstanse = UploadedFile::getInstance($model, 'image')))
                {
                    $model->image = $fileInstanse;
                    if($model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'carousel');
                    }
                    else {
                        $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                        return $this->refresh();
                    }
                }
                else{
                    $model->image = $model->oldAttributes['image'];
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/carousel', 'Carousel updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii/carousel','Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        if(($model = ItemCarousel::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii/article', 'Article deleted'));
    }

    public function actionUp($id)
    {
        return $this->move($id, 'up');
    }

    public function actionDown($id)
    {
        return $this->move($id, 'down');
    }


    public function actionOn($id)
    {
        return $this->changeStatus($id, ItemCarousel::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, ItemCarousel::STATUS_OFF);
    }
}