<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <h2><?= nl2br(Html::encode($message)) ?></h2>
        <hr/>
        <div class="center-block">
            <a class="btn btn-danger btn-lg" href="<?= Yii::$app->homeUrl ?>">برگشت به صفحه اصلی</a>
        </div>
    </div>

</div>
