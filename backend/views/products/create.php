<?php 
use yii\widgets\ActiveForm;
$this->title= 'درج محصول';
$form = ActiveForm::begin([
    'options' => [
        'enctype'=>'multipart/form-data',
        'class' => 'col-sm-6 col-sm-offset-3 alert alert-info',
    ],
]);
?>
<h3>درج محصول جدید </h3>
<hr/>
    <?= $form->field($model, 'category_id')->dropDownList($model->categoryOptions);  ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'pic')->fileInput() ?>
    <?= $form->field($model, 'price') ?>
    <?= $form->field($model, 'quantity') ?>
    <?= $form->field($model, 'confirmed')->checkbox() ?>
<div class="form-group">
    <?= yii\helpers\Html::submitButton('ارسال', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>