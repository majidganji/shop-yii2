<?php 
use yii\widgets\ActiveForm;
$this->title= 'ویرایش محصول';
$form = ActiveForm::begin([
    'enableClientValidation' => false,
    'options' => [
        'enctype'=>'multipart/form-data',
        'class' => 'col-sm-6 col-sm-offset-3 alert alert-warning',
    ],
]);
?>
<h3>ویرایش محصول  </h3>
<hr/>
    <?= $form->field($model, 'category_id')->dropDownList($model->categoryOptions);  ?>
    <?= $form->field($model, 'name') ?>
<b>تصویر قبلی</b>&nbsp;&nbsp;<?= yii\helpers\Html::img('http://localhost/shop2/photos/'.$model->id.'_t.jpg',['class' => 'img-thumbnail']) ?>
    <?= $form->field($model, 'pic')->fileInput() ?>
    <?= $form->field($model, 'price') ?>
    <?= $form->field($model, 'quantity') ?>
    <?= $form->field($model, 'confirmed')->checkbox() ?>
<div class="form-group">
    <?= yii\helpers\Html::submitButton('ارسال', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>