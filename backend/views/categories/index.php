<?php

use yii\helpers\Url;
$this->title = 'دسته بندی';
?>
<div class="row">
    <div class="col-sm-12">
        <p>
            <a class="btn btn-primary btn-lg" href="<?= Url::to(['categories/create']) ?>"><span class="fa fa-navicon"></span> ایجاد دسته بندی جدید</a>
        </p>
        <?php if (!$models) : ?>
            <div class="alert alert-danger">
                <p>دسته بندی وجود ندارد .</p>
            </div>
        <?php else: ?>
            <table class="table table-hover table-bordered table-striped table-responsive">
                <thead>
                    <tr class="info">
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>والد</th>
                        <th>فعال</th>
                        <th class="col-sm-1"><span class="fa fa-gear"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($models as $model): ?>
                    <tr>
                        <td><?= $model->id ?></td>
                        <td><?= $model->name ?></td>
                        <td><?= ($model->parent ?   $model->parent->name : '') ?></td>
                        <td><span class="fa fa-<?= ($model->confirmed ? 'check text-success' : 'times text-danger') ?>"></span></td>
                        <td>
                            <a href="<?= Url::to(['categories/edit', 'id' => $model->id]) ?>"><span class="fa fa-edit fa-lg text-warning"></span></a>
                            &nbsp;
                            <a href="<?= Url::to(['categories/delete', 'id' => $model->id]) ?>" onclick="return confirm('آیا حذف شود ؟');"><span class="fa fa-times-circle-o fa-lg text-danger"></span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>