<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Products;
use Yii;
use frontend\models\Orders;
use frontend\models\Orderproducts;

class ProductsController extends Controller {

    public function actionAdd($id) {
        $model = $this->loadModel($id);
        $basket = Yii::$app->session->get('basket');
        if (!isset($basket[$model->id])) {
            $basket[$model->id] = 1;
        } else {
            $basket[$model->id] ++;
        }
        Yii::$app->session->set('basket', $basket);
        return json_encode(['color'=> 'text-success', 'count' => count($basket)]);
//        return $this->redirect(Yii::$app->getRequest()->referrer);
    }

    public function actionRemove($id) {
        $this->loadModel($id);
        $basket = Yii::$app->session->get('basket');
        if (isset($basket[$id])) {
            $basket[$id] --;
            if ($basket[$id] <= 0) {
                unset($basket[$id]);
            }
        }
        Yii::$app->session->set('basket', $basket);
        return $this->redirect(['order']);
    }

    public function actionClear($id) {
        $this->loadModel($id);
        $basket = Yii::$app->session->get('basket');
        if (isset($basket[$id])) {
            unset($basket[$id]);
        }
        Yii::$app->session->set('basket', $basket);
        if (empty(Yii::$app->session->get('basket'))){
            return $this->redirect(['site/index']);
        }
        return $this->redirect(['order']);
    }

    public function actionOrder() {
        $basket = Yii::$app->session->get('basket');
        if (count($basket) == 0) {
            if (Yii::$app->request->referrer === 'http://localhost/shop2/products/order') {
                return $this->redirect(['site/index']);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        $model = new Orders();
        if(!Yii::$app->user->isGuest){
            $model->name = Yii::$app->user->identity->name;
            $model->family = Yii::$app->user->identity->family;
            $model->city_id = Yii::$app->user->identity->city_id;
            $model->address = Yii::$app->user->identity->address;
            $model->postcode = Yii::$app->user->identity->postcode;
            $model->phone = Yii::$app->user->identity->phone;
            $model->email = Yii::$app->user->identity->email;
            $model->user_id = Yii::$app->user->id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $total = 0;
            foreach ($basket as $id => $quantity) {
                $product = $this->loadModel($id);
                $total += $product->price * $quantity;
            }
            $model->amount = $total;
            $model->ts = time();
            $model->confirmed = 1;
            $model->paid = 0;
            if ($model->save()) {
                foreach ($basket as $id => $quantity) {
                    $orderProducts = new Orderproducts();
                    $orderProducts->order_id = $model->id;
                    $orderProducts->product_id = $id;
                    $orderProducts->quantity = $quantity;
                    $orderProducts->confirmed = 1;
                    $orderProducts->save();
                }
                \common\components\JahanPay::request($model->amount, $model->id, date('Y/m/d H:i:s', $model->ts));
            }
        }
        

        return $this->render('basket', compact('model'));
    }

    public function beforeAction($action) {
        if ($action->id == 'facture') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionFacture() {
        if (!isset($_GET['au'], $_GET['order_id'])) {
            throw new \yii\web\NotFoundHttpException('فاکتور موردنظ یافت نشد.');
        }
        if (!$order = Orders::findOne($_GET['order_id'])) {
            throw new \yii\web\HttpException(404, 'فاکتور موردنظ یافت نشد.');
        }
        list($code, $message) = \common\components\JahanPay::verify($order->amount, $_GET['au']);
        if ($code != 1) {
            throw new \yii\web\HttpException(500, $message . '(' . $code . ')');
        }
        $order->paid = 1;
        if (!$order->au) {
            $order->au = $_GET['au'];
            $productNames = [];
            foreach ($order->products as $product) {
                if ($product->quantity > 0) {
                    $product->updateCounters(['quantity' => -1] , 'id=:id', [':id' => $product->id]);
                    $product->refresh();
                    if ($product->quantity == 0) {
                        $text = 'اتمام محصول {' . $product->name . '}';
                        \common\components\Sms::send('9147347973', $text);
                    }
                }
                $quantity = Orderproducts::findOne(['order_id' => $order->id, 'product_id' => $product->id]);
                $quantity = $quantity->quantity;
                $productNames[] = $product->name . '-' . $quantity;
            }
            $text = "سفارش جدید\r\n";
            $text .= implode("\r\n", $productNames) . "\r\n";
            $text .= $order->amount . "\r\n";
            $text .= $order->phone . "\r\n";
            $text .= $order->city->state->name . "\r\n";
            $text .= $order->city->name . "\r\n";
            $text .= $order->address . "\r\n";
            $text .= $order->postcode . "\r\n";
            $text .= $order->email . "\r\n";
            $text .= $order->comment;
            \common\components\Sms::send('9147347973', $text);
        }
        $order->save();
        Yii::$app->session->set('basket', []);
        return $this->render('facture',[
            'message' => $message,
            'type' => ($code ==1 ? 'success' : 'danger'),
            'order' => $order,
        ]);
    }

    public function loadModel($id) {
        if (!$model = Products::findOne(['id' => $id, 'confirmed' => 1])) {
            throw new \yii\web\HttpException(404, 'محصول مورد نظر یافت نشد.');
        }
        return $model;
    }

}
