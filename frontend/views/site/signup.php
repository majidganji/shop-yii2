<?php

use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
            'enableClientValidation' => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-sm-5\">{input}</div>\n<div class=\"col-sm-4\">{error}</div>",
                'labelOptions' => ['class' => 'col-sm-3 control-label'],
            ],
        ]);
?>
<div class="row">
    <div class="col-sm-12">
        <h1>ثبت نام کنید</h1>
        <hr />
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'family') ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'city_id')->dropDownList($model->cityOptions) ?>
        <?= $form->field($model, 'address')->textarea(['rows' => 5, 'style' => 'resize:none']) ?>
        <?= $form->field($model, 'postcode')->textInput(['maxlength' => 10]) ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-3">
                <?= yii\helpers\Html::submitButton('ثبت نام', ['class' => 'btn btn-primary btn-blog']) ?>
            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::end()?>