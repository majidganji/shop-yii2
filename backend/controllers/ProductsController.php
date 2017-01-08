<?php

namespace backend\controllers;

use backend\controllers\AdminController;
use backend\models\Products;
use Yii;

class ProductsController extends AdminController {

    public function actionIndex() {
        $products = Products::find()->orderBy('id DESC')->all();   
        return $this->render('index',['products' => $products]);
    }
    
    public function actionCreate() {
        $model = new Products();
        $model->setScenario('create');
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            \common\components\Image::safeUpload($model->pic->tempName, $model->id); 
            return $this->redirect(['products/index']);
        }
        return $this->render('create',[
            'model' => $model,
        ]);
    }
    
    public function actionEdit($id) {
        $model = $this->loadModel($id);
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            if($model->pic){
                unlink(Yii::$app->basePath . '/../frontend/web/photos/'.$model->id.'.jpg');
                unlink(Yii::$app->basePath . '/../frontend/web/photos/'.$model->id.'_t.jpg');
                \common\components\Image::safeUpload($model->pic->tempName, $model->id); 
            }
            return $this->redirect(['products/index']);
        }
        return $this->render('edit',[
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id){
        $model = $this->loadModel($id);
        $model->delete();
        return $this->redirect(['products/index']);
    }


    private function loadModel($id){
        if(!$model = Products::findOne($id)){
            throw new \yii\web\HttpException(404, 'یافت نشد .');
        }
        return $model;
    }

}
