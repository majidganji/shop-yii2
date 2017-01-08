<?php

    use frontend\models\Orders;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\Pjax;

    $this->title = 'فروشگاه اینترنتی';
?>
<div class="row">
    <?php if (!$models): ?>
        <div class="col-sm-12">
            <div class="alert alert-warning">
                <p>محصولی یافت نشد .</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($models as $model): ?>
            <div class="col-sm-3">
                <div class="well well-sm">
                    <div class="well-sm" style="height: 60px;">
                        <?php Pjax::begin(); ?>
                        <a class="btn btn-primary btn-xs pull-left"
                           href="<?= Url::to(['products/add', 'id' => $model->id]) ?>"><span
                                class="fa fa-plus fa-fw"></span></a>
                        <?php Pjax::end(); ?>
                        <p style="height: 70px;">
                            <?= Html::encode($model->name) ?>
                        </p>
                    </div>
                    <img class="img-thumbnail" style="height: 120px; width: 100%"
                         src="<?= Yii::$app->homeUrl ?>/photos/<?= $model->id ?>_t.jpg">
                    <?php
                        $orderCount = Orders::find()->joinWith(['products'])->where(['products.confirmed' => 1, 'products.id' => $model->id, 'orderproducts.confirmed' => 1, 'orders.confirmed' => 1])->count();
                    ?>
                    <p>
                    <div
                        class="alert alert-<?= ($orderCount < 1 ? 'danger' : 'success') ?> ">آمار فروش:  <?= $orderCount ?> </div>
                    </p>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-6"><?= $model->price ?></div>
                        <div
                            class="col-xs-6 text-<?= ($model->quantity > 0 ? 'success' : 'danger') ?>"><?= $model->quantity ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="row">
            <div class="col-sm-12">
                <p>
                    <?=
                        yii\widgets\LinkPager::widget([
                            'pagination' => $pagination,
                        ])
                    ?>
                </p>

            </div>
        </div>
    <?php endif; ?>
</div>