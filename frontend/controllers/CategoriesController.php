<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Products;
use frontend\models\Categories;

class CategoriesController extends Controller {
    
    public function actionView($id){
        $category = $this->loadModel($id);
        $query = Products::find()->where(['category_id' => $category->id, 'confirmed' => 1]);
        $pagination = new \yii\data\Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => 20,
        ]);
        $models = $query->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->all();
        return $this->render('/site/index',[
            'models' => $models,
            'pagination' => $pagination,
        ]);
    }
    
    private function loadModel($id){
        if(!$model = Categories::findOne(['id' => $id, 'confirmed' => 1])){
            throw new \yii\web\HttpException(404, 'محصول مورد نظر پیدا نشد .');
        }
        return $model;
    }
    
}
