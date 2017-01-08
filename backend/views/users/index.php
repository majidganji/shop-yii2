<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'کاربران';
?>
<div class="col-sm-12">
    <?php if (!$models): ?>
        <div class="alert alert-danger">
            <p>کاربر وجود ندارد.</p>
        </div>
    <?php else: ?>
    <p>
        <a class="btn btn-info btn-lg" href="<?= Url::to(['users/search']) ?>"><span class="fa fa-search"></span> جستجو</a>
    </p>
    <table class="table table-bordered table-condensed table-responsive table-striped table-hover">
        <thead>
            <tr>
                <td>#</td>
                <td>نام</td>
                <td>نام خانوادگی</td>
                <td>نام کاربری</td>
                <td>کد پستی</td>
                <td>ایمیل</td>
                <td>فعال</td>
                <td><span class="fa fa-gear"></span></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $model): ?>
            <tr>
                <td><?= Html::a($model->id, Url::to(['users/view', 'id' => $model->id])) ?></td>
                <td><?= Html::encode($model->name) ?></td>
                <td><?= Html::encode($model->family) ?></td>
                <td><?= Html::encode($model->username) ?></td>
                <td><?= Html::encode($model->postcode) ?></td>
                <td><?= Html::encode($model->email) ?></td>
                <td><span class="text-<?= ($model->status == 10 ? 'success fa fa-check' : 'danger fa fa-times') ?>"></span></td>
                <td>
                    <?= Html::a('<span class="fa fa-eye text-info"></span>', Url::to(['users/view', 'id' => $model->id])) ?>
                    &nbsp;
                    <?= Html::a('<span class="fa fa-edit text-warning"></span>', Url::to(['users/edit', 'id' => $model->id])) ?>
                    &nbsp;
                    <?= Html::a('<span class="fa fa-times-circle-o text-danger"></span>', Url::to(['users/delete', 'id' => $model->id]),['onclick' => 'return confirm("آیا مطمئن هستید ؟");']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>