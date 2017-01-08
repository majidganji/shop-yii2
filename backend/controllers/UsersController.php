<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class UsersController extends AdminController {

    public function actionIndex() {
        $models = User::find()->orderBy('id DESC')->all();
        return $this->render('index', compact('models'));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        return $this->render('view', compact('model'));
    }

    public function actionEdit($id) {
        $model = $this->loadModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['users/view', 'id' => $model->id]);
        }
        return $this->render('edit', compact('model'));
    }

    public function actionDelete($id) {
        if ($this->loadModel($id)->delete()) {
            return $this->redirect(['users/index']);
        } else {
            throw new \yii\web\HttpException(404, 'خطا:حذف نشد .');
        }
    }

    public function actionSearch() {
        $model = new \backend\models\UserSearch;
        if($model->load(Yii::$app->request->get()) && $model->Validate()){
            $query = \backend\models\UserSearch::find()
                    ->filterWhere(['id' => $model->id])
                    ->andFilterWhere(['like', 'name', $model->name])
                    ->andFilterWhere(['like', 'family', $model->family])
                    ->andFilterWhere(['like', 'username', $model->username])
                    ->andFilterWhere(['like', 'email', $model->email])
                    ->andFilterWhere(['like', 'postcode', $model->postcode])
                    ->andFilterWhere(['status'=> $model->status]);
            $models = $query->orderBy('id DESC')->all();
            return $this->render('index', compact('models'));
        }
        return $this->render('search', compact('model'));
    }

    private function loadModel($id) {
        if (!$model = User::findOne($id)) {
            throw new NotFoundHttpException('کاربری با این مشخصات پیدا نشد!');
        }
        return $model;
    }

}
