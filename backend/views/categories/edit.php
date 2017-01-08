<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
    $this->title = 'ویرایش دسته بندی';
?>
<?php $form = ActiveForm::begin([
    'options'=>[
        'class' => 'col-sm-6 col-sm-offset-3 alert alert-success'
    ]
]); ?>
<?= $form->field($model, 'parent_id')->dropDownList($model->categoriesOptionsEdit) ?>
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'confirmed')->checkbox() ?>
<div class="form-group">
    <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>