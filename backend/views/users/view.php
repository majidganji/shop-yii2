<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'نمایش مشخصات کاربر';
?>
<div class="col-sm-6 col-sm-offset-3 well">
    <h3><?= $this->title ?> - <?= $model->id ?></h3>
    <?= Html::a('ویرایش', Url::to(['users/edit', 'id' => $model->id]), ['class' => 'btn btn-warning']) ?>
    &nbsp;
    <?= Html::a('حذف', Url::to(['users/delete', 'id' => $model->id]),['onclick' => 'return confirm("آیا مطمئن هستید ؟");', 'class' => 'btn btn-danger']) ?>
    <hr />
    <b>نام:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->name) ?>
    </div>
    <b> نام خانوادگی:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->family) ?>
    </div>
    <b> نام کاربری:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->family) ?>
    </div>
    <b> شهر:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->city->name) ?>
    </div>
    <b> آدرس:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->address) ?>
    </div>
    <b> تلفن:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->phone) ?>
    </div>
    <b> کد پستی:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->postcode) ?>
    </div>
    <b> ایمیل:</b><br/>
    <div class="well well-sm">
        <?= Html::encode($model->email) ?>
    </div>
    <b> فعال:</b><br/>
    <div class="well well-sm">
        <?= ($model->status == 10 ? '<span class ="text-success">فعال است</span>' : '<span class="text-danger">فعال نیست</span>') ?>
    </div>
    <b> تاریخ ثبت نام:</b><br/>
    <div class="well well-sm">
        <?= common\components\JDF::jdate('l j F Y - H:i:s', $model->created_at) ?>
    </div>
    <b> آخرین آپدیت:</b><br/>
    <div class="well well-sm">
        <?= common\components\JDF::jdate('l j F Y - H:i:s', $model->updated_at)?>
    </div>
</div>