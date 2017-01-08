<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>
<?= $form->field($model, 'name') ?>
<?= Html::hiddenInput('hidden', Yii::$app->security->hashData('1250', 'ENOLVVwBJeZjdjfth_8S')) ?>
<?= Html::submitButton('send', ['class' => 'btn btn-primary']) ?>
