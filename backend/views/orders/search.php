<?php 
    
    $this->title = 'جستجو';
?>

<div class="col-sm-6 col-sm-offset-3 well">
    <h3><?= $this->title ?></h3>
    <hr />
    <?php $form = \yii\widgets\ActiveForm::begin([
        'method' =>'get'
    ]); ?>
    <?= $form->field($model, 'id')->label('شناسه') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'family') ?>
    <?= $form->field($model, 'postcode') ?>
    <?= $form->field($model, 'au') ?>
    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('جستجو', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>