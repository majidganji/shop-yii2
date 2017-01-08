<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    $this->title = 'محصولات';
?>
<div class="row">
    <div class="col-sm-12">
        <p>
            <a class="btn btn-primary btn-lg" href="<?= Url::to(['create']) ?>"><span class="fa fa-desktop"></span> ایجاد محصول جدید</a>
        </p>
        <?php if (!$products): ?>
        <div class="alert alert-danger">
            <p>محصولی یافت نشد .</p>
        </div>
        <?php else: ?>
        <table class="table table-hover table-bordered table-responsive table-condensed table-striped">
            <thead>
                <tr class="success">
                    <td>ردیف</td>
                    <td>نام محصول</td>
                    <td>دسته بندی</td>
                    <td>قیمت</td>
                    <td>تعداد</td>
                    <td>فعال</td>
                    <td class="col-xs-1"><span class="fa fa-gear"></span></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product->id ?></td>
                    <td><?= Html::encode($product->name) ?></td>
                    <td><?= Html::encode($product->category->name) ?></td>
                    <td><?= Html::encode($product->price) ?></td>
                    <td><?= Html::encode($product->quantity) ?></td>
                    <td><span class="fa fa-<?= ($product->confirmed ? 'check text-success' : 'times text-danger') ?>"></span></td>
                    <td>
                        <a href="<?= Url::to(['edit' ,'id' => $product->id]) ?>"><span class="fa fa-edit text-warning"></span></a>
                        &nbsp;
                        <a href="<?= Url::to(['delete' ,'id' => $product->id]) ?>" onclick="return confirm('آیا حذف شود ؟');"><span class="fa fa-times-circle-o text-danger"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
