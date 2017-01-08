<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\Categories;
use Yii;

class CategoriesController extends AdminController {

    public function actionIndex () {
        $models = Categories::find ()->orderBy ('id DESC')->all ();

        return $this->render ('index', ['models' => $models,]);
    }

    public function actionEdit ($id) {
        $model = $this->loadModel ($id);

        if ($model->load (Yii::$app->request->post ()) && $model->validate () && $model->save ()) {
            if ($model->parent_id != NULL) {
                foreach (Categories::find ()->where (['parent_id' => $model->id])->all () as $category) {
                    $category->parent_id = $model->parent_id;
                    $category->save ();
                }
            }

            return $this->redirect (['categories/index']);
        }

        return $this->render ('edit', ['model' => $model]);
    }

    public function actionCreate () {
        $model = new Categories();
        if ($model->load (Yii::$app->request->post ()) && $model->validate () && $model->save ()) {
            return $this->redirect (['categories/index']);
        }

        return $this->render ('create', ['model' => $model]);
    }

    public function actionDelete ($id) {
        $model = $this->loadModel ($id);
        $model->delete ();

        return $this->redirect (Yii::$app->request->referrer);
    }

    private function loadModel ($id) {
        if (!$model = Categories::findOne ($id)) {
            throw new \yii\web\HttpException(404, 'یافت نشد .');
        }

        return $model;
    }

}
