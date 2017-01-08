<?php 
use yii\helpers\Html;
$this->title = 'ویرایش کاربر';
?>
<div class="col-sm-6 col-sm-offset-3 well">
    <?php $form = yii\widgets\ActiveForm::begin(); ?>
    <h3><?= $this->title ?> - <?= $model->id ?></h3>
    <hr />
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'family') ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'city_id')->dropDownList($model->cityOptions) ?>
    <?= $form->field($model, 'address')->textarea(['rows' => 5, 'style' => 'resize:none;']) ?>
    <?= $form->field($model, 'phone') ?>
    <?= $form->field($model, 'postcode') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'status')->dropDownList([ '10' => 'فعال', '0' => 'غیر فعال']) ?>
    <div class="form-group">
        <?= Html::submitButton('ذخیره',['class' => 'btn btn-primary']) ?>
    </div>
    <?php yii\widgets\ActiveForm::end(); ?>
</div>