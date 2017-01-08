<?php
    /* @var $this \yii\web\View */
    /* @var $content string */

    use frontend\assets\AppAsset;
    use frontend\models\Categories;
    use frontend\models\Products;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\helpers\Html;
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
            'brandLabel' => 'فروشگاه اینترنتی',
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => 'خانه', 'url' => ['/site/index']],
        ];

        foreach (Categories::find()->where(['confirmed' => 1, 'parent_id' => NULL])->orderBy('name')->all() as $category) {
            if (!$subMenu_1 = Categories::find()->where(['confirmed' => 1, 'parent_id' => $category->id])->orderBy('name')->all()) {
                $menuItems[] = ['label' => $category->name, 'url' => Url::to(['categories/view', 'id' => $category->id])];
            } else {
                $item = [];
                foreach ($subMenu_1 as $subMenu) {
                    $item[] = ['label' => $subMenu->name, 'url' => Url::to(['categories/view', 'id' => $subMenu->id])];
                }
                $menuItems[] = ['label' => $category->name, 'items' => $item];
            }
        }
        $menuItems[] = ['label' => '<span class="fa fa-shopping-cart fa-lg text-' . (empty(Yii::$app->session->get('basket')) ? 'danger' : 'success') . '"></span>', 'url' => ['products/order']];
        echo Nav::widget([
            'encodeLabels' => FALSE,
            'options'      => ['class' => 'navbar-nav'],
            'items'        => $menuItems,
        ]);
        NavBar::end();
    ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-xs-pull-0">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        کاربران
                    </div>
                    <div class="panel-body">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <p><a href="<?= Url::to(['site/login']) ?>">ورود</a></p>
                            <p><a href="<?= Url::to(['site/signup']) ?>">ثبت نام</a></p>
                        <?php else: ?>
                            <p><b><?= Yii::$app->user->identity->name ?>
                                    &nbsp; <?= Yii::$app->user->identity->family ?></b></p>
                            <p><a href="<?= Url::to(['site/state']) ?>"><span
                                        class="fa fa-bar-chart-o fa-fw"></span> آمار خرید های قبلی</a></p>
                            <p><a href="<?= Url::to(['site/logout']) ?>" data-method="post">خروج</a></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">برترین محصولات</div>
                    <div class="panel-body">
                        <?php
                            $products = Products::find()->joinWith('orders')->where('products.confirmed=1 AND orders.confirmed=1 AND orderproducts.confirmed=1')->orderBy('orderproducts.quantity')->all();
                        ?>
                        <?php foreach ($products as $product): ?>
                            <p><a href="#"><?= $product->name ?></a></p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">محصولات تصادفی</div>
                    <div class="panel-body">
                        <?php foreach (Products::find()->where(['confirmed' => 1])->orderBy('RAND()')->limit(5)->all() as $product): ?>
                            <p><a href="#"><?= $product->name ?></a></p>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">برترین کاربران</div>
                    <div class="panel-body">
                        <?php foreach (\frontend\models\Orders::find()->where(['confirmed' => 1, 'paid' => 1])->select(['amount'])->orderBy('amount DESC')->limit(5)->all() as $item):_ ?>
                            <p><?= Html::encode($item->user->username) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
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
