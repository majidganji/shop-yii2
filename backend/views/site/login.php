<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ورود';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode ($this->title) ?></h1>
    <hr/>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin (['id' => 'login-form']); ?>

            <?= $form->field ($model, 'username')->label ('نام کاربری') ?>

            <?= $form->field ($model, 'password')->passwordInput ()->label ('رمز عبور') ?>


            <div class="form-group">
                <?= Html::submitButton ('ورود', [
                    'class' => 'btn btn-primary',
                    'name' => 'login-button'
                ]) ?>
            </div>

            <?php ActiveForm::end (); ?>
        </div>
    </div>
</div>
