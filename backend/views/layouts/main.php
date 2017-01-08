<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'فروشگاه',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'صفحه اصلی', 'url' => Yii::$app->homeUrl],
    ];
    $menuItems[] = [
        'label' => 'خروج (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="list-group">
                    <a class="list-group-item" href="<?= Url::to(['categories/index']) ?>"><span class="fa fa-list"></span> دسته بندی</a>
                    <a class="list-group-item" href="<?= Url::to(['products/index']) ?>"><span class="fa fa-desktop"></span> محصولات</a>
                    <a class="list-group-item" href="<?= Url::to(['orders/index']) ?>"><span class="fa fa-credit-card"></span> فاکتور فروش</a>
                    <a class="list-group-item list-group-item-heading" href="<?= Url::to(['users/index']) ?>"><span class="fa fa-user"></span> کاربران</a>
                    <a class="list-group-item list-group-item-info"><span class="fa fa-asterisk"></span> تغییر رمز</a>
                    <a class="list-group-item list-group-item-danger"><span class="fa fa-sign-out"></span> خروج</a>
                </div>
            </div>
            <div class="col-sm-9">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
