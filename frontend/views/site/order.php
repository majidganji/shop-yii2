<?php use common\components\JDF; use yii\helpers\Html; use frontend\models\Orderproducts;?>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="info">
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
                <?php 
                    $orderProducts = Orderproducts::find()->where(['order_id' => $model->id, 'confirmed' => 1])->all();
                ?>
                <?php foreach ($orderProducts as $model): ?>
                <?php 
                    $sum = $model->product->price * $model->quantity;
                    $total += $sum;
                ?>
                <tr>
                    <td><?= $row++ ?></td>
                    <td><?= Html::encode($model->product->name) ?></td>
                    <td><?= Html::encode($model->product->price) ?></td>
                    <td><?= Html::encode($model->quantity) ?></td>
                    <td><?= $sum ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="success">
                    <td colspan="3" class="text-left">جمع کل</td>
                    <td colspan="2"> <?= $total ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>