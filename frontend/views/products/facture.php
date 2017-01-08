<?php

use yii\helpers\Html;
?>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="<?= $type ?>">
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>قیمت واحد</th>
                    <th>تعداد</th>
                    <th>جمع</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row = 1;
                $sum = 0;
                $total = 0;
                ?>
                <?php foreach (\frontend\models\Orderproducts::findAll(['order_id' => $order->id, 'confirmed' => 1]) as $orderProduct): ?>
                    <?php
                    if (!$produc = \frontend\models\Products::findOne(['id' => $orderProduct->product_id, 'confirmed' => 1])) {
                        throw new yii\web\HttpException('محصول مورد نظر پیدا نشد .');
                    }
                    $sum = $produc->price * $orderProduct->quantity;
                    $total += $sum;
                    ?>
                    <tr>
                        <td><?= $row++ ?></td>
                        <td><?= Html::encode($produc->name); ?></td>
                        <td><?= $produc->price ?></td>
                        <td><?= $orderProduct->quantity ?></td>
                        <td><?= $sum ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="info">
                    <td class="text-left" colspan="3">جمع کل</td>
                    <td class="" colspan="2"><?= $total ?></td>
                </tr>
            </tfoot>
        </table>
        <h2>
            شناسه خرید شما : <bdo dir="ltr" style="direction: ltr;"><?= $order->id ?>-<?= $order->ts ?></bdo>
        </h2>
    </div>
</div>