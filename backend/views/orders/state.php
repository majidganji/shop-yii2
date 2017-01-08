<?php 
    use common\components\JDF;
    use yii\helpers\Html; 
    use yii\helpers\Url; 
    $this->title = 'فاکتورها'
?>
<div class="row">
    <div class="col-sm-12">
        <p>
            <?= Html::a('جستجو ...', Url::to(['orders/search']),['class' => 'btn btn-info btn-lg']) ?>
        </p>
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="info">
                    <th>شناسه خرید</th>
                    <th>خریدار</th>
                    <th>تاریخ</th>
                    <th>کد پستی</th>
                    <th>کد بانک</th>
                    <th><span class="fa fa-money"></span></th>
                    <th>فعال</th>
                    <th><span class="fa fa-gear"></span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($models as $model): ?>
                <tr>
                    <td>
                        <a href="<?= Url::to(['index', 'track' =>$model->id.'-'.$model->ts ]) ?>"><?= $model->id . '-' . $model->ts ?></a>
                    </td>
                    <td><?= Html::a(Html::encode($model->user_id ? $model->user->username : ' '), Url::to(['users/view', 'id' =>($model->user_id ? $model->user->id : '#')])) ?></td>
                    <td><?= JDF::tr_num(JDF::jdate('l j F Y', $model->ts)) ?></td>
                    <td><?= JDF::tr_num($model->postcode) ?></td>
                    <td><?= $model->au ?></td>
                    <td><span class="text-<?= ($model->paid ? 'success fa fa-check' : 'danger fa fa-times') ?>"></span></td>
                    <td>
                        <a href="<?= Url::to(['orders/tf', 'id' => $model->id]) ?>">
                            <span class="text-<?= ($model->confirmed ? 'success fa fa-check' : 'danger fa fa-times') ?>"></span>
                        </a>
                    </td>
                    <td>
                        <?= Html::a('<span class="text-danger fa fa-times-circle-o"></span>',  Url::to(['orders/delete', 'id' => $model->id]), ['onclick' => 'return confirm("آیا مطمئن هستید ؟");']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?=
        \yii\widgets\LinkPager::widget([
            'pagination' => $pagination
        ])
                ?>
    </div>
</div>