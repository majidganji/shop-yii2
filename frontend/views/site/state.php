<?php use common\components\JDF; use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="info">
                    <th>شناسه خرید</th>
                    <th>تاریخ</th>
                    <th>ساعت</th>
                    <th>مبلغ</th>
                    <th>کد بانک</th>
                    <th>توضیحات</th>
                    <th><span class="fa fa-money fa-lg"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $model): ?>
                <tr>
                    <td>
                        <a href="<?= Url::to(['state', 'track' =>$model->id.'-'.$model->ts ]) ?>"><?= $model->id . '-' . $model->ts ?></a>
                    </td>
                    <td><?= JDF::tr_num(JDF::jdate('l j F Y', $model->ts)) ?></td>
                    <td><?= JDF::tr_num(JDF::jdate('H:i:s', $model->ts)) ?></td>
                    <td><?= JDF::tr_num($model->amount) ?></td>
                    <td><?= $model->au ?></td>
                    <td><?= Html::encode($model->comment) ?></td>
                    <td><span class="text-<?= ($model->paid ? 'success fa fa-check' : 'danger fa fa-times') ?>"></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>