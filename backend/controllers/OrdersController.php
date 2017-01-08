<?php

namespace backend\controllers;

class OrdersController extends AdminController {

    public function actionIndex($track = NULL) {
        if (!empty($track) && $track != NULL) {
            list($id) = explode('-', $track);
            if (!$model = \backend\models\Orders::findOne(['id' => $id])) {
                throw new \yii\web\HttpException(404, 'فاکتوری با این مشخصات پیدا نشد .');
            }
            return $this->render('order', ['model' => $model, 'pagination' => NULL]);
        } else {
            $query = \backend\models\Orders::find();
            $pagination = new \yii\data\Pagination([
                'totalCount' => $query->count(),
                'defaultPageSize' => 30,
            ]);
            $models = $query->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->all();
            return $this->render('state', [
                'models' => $models,
                'pagination' => $pagination,
            ]);
        }
    }

    public function actionTf($id) {
        $model = $this->loadModel($id);
        if ($model->confirmed) {
            $model->confirmed = 0;
        } else {
            $model->confirmed = 1;
        }
        if ($model->save()) {
            return $this->redirect(\Yii::$app->getRequest()->referrer);
        } else {
            throw new \yii\web\HttpException(400, 'خطا در هنگام بروز رسانی');
        }
    }

    public function actionDelete($id) {
        if($this->loadModel($id)->delete()){
          return $this->redirect(\Yii::$app->getRequest()->referrer);
        } else {
            throw new \yii\web\HttpException(400, 'خطا در هنگام بروز رسانی');
        }
    }
    
    public function actionSearch() {
        $model = new \backend\models\Orderssearch();
        if($model->load(\Yii::$app->request->get()) && $model->validate()){
            $query = \backend\models\Orderssearch::find()
                    ->filterWhere(['id' => $model->id])
                    ->andFilterWhere(['LIKE', 'name', $model->name])
                    ->andFilterWhere(['LIKE', 'family', $model->family])
                    ->andFilterWhere(['LIKE', 'postcode', $model->postcode])
                    ->andFilterWhere(['LIKE', 'au', $model->au]);
            $pagination = new \yii\data\Pagination([
                'totalCount' => $query->count(),
                'defaultPageSize' => 20,
            ]);
            $models = $query->offset($pagination->offset)->limit($pagination->limit)->orderBy('id DESC')->all();
            return $this->render('state', compact('models', 'pagination'));
        }
        return $this->render('search', compact('model'));
    }

    public function loadModel($id) {
        if (!$model = \backend\models\Orders::findOne($id)) {
            throw new \yii\web\NotFoundHttpException('کاربری با این مشخصات پیدا نشد!');
        }
        return $model;
    }

}
