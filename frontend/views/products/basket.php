<?php

use frontend\models\Products;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'سبد خرید ';
?>
<div
    class="row">
    <div
        class="col-sm-12">
        <table
            class="table table-hover table-bordered">
            <thead>
            <tr class="info">
                <th> ردیف</th>
                <th> عنوان</th>
                <th> قیمت واحد</th>
                <th>تعداد</th>
                <th>جمع</th>
                <th>
                    <span class="fa fa-gear"></span>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $row = 1;
            $total = 0;
            $sum = 0;
            ?>
            <?php foreach (Yii::$app->session->get('basket') as $id => $quantity): ?>
                <?php
                if (!$product_order = Products::findOne(['id' => $id, 'confirmed' => 1])) {
                    throw new \yii\web\HttpException(404, 'محصول مورد نظر یافت نشد.');
                }
                $sum = $product_order->price * $quantity;
                $total += $sum;
                ?>
                <tr>
                    <td><?= $row++ ?></td>
                    <td><?= Html::encode($product_order->name) ?></td>
                    <td><?= Html::encode($product_order->price) ?></td>
                    <td><?= Html::encode($quantity) ?></td>
                    <td><?= $sum ?></td>
                    <td class="col-sm-1">
                        <a class="btn btn-warning btn-xs" href="<?= Url::to(['products/remove', 'id' => $id]) ?>"><span class="fa fa-minus"></span></a>
                        &nbsp;
                        <a class="btn btn-danger btn-xs" href="<?= Url::to(['products/clear', 'id' => $id]) ?>"><span class="fa fa-times"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="success">
                <td colspan="4"
                    class="text-left">
                    جمع
                    کل
                </td>
                <td colspan="2"><?= $total ?></td>
            </tr>
            </tbody>
        </table>
        <hr/>
        <?php
        $form = ActiveForm::begin([
            'options' => [
                'class' => 'alert alert-info',
            ],
        ])
        ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'family') ?>
        <?= $form->field($model, 'city_id')->dropDownList($model->getCityOptions()) ?>
        <?= $form->field($model, 'address')->textarea(['rows' => 4, 'style' => 'resize:none;']) ?>
        <?= $form->field($model, 'postcode')->textInput(['maxlength' => 10]) ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'comment')->textarea(['rows' => 5, 'style' => 'resize:none;']) ?>
        <DIV
            class="row">
            <div
                class="form-group">
                <div
                    class="col-sm-6 col-sm-offset-3">
                    <?= Html::submitButton('<span class="fa fa-money"></span>   پرداخت آنلاین ', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
                </div>
            </div>

        </DIV>
        <?php ActiveForm::end(); ?>
    </div>
</div>