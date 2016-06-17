<!DOCTYPE html>
<?php
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->head() ?>
</head>
<body>
<?php
$this->beginBody()
?>

<div class="container">
    <div class="banner">
    	<img src="images/shop-img/banner.png">
    </div>
</div>
    <div>
        <?= $content ?>
    </div>

<!-- container结束 -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>