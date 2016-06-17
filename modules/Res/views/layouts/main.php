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
<!-- <div class="container">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    	<ol class="carousel-indicators">
    		<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    		<li data-target="#carousel-example-generic" data-slide-to="1"></li>
    		<li data-target="#carousel-example-generic" data-slide-to="2"></li>
    	</ol>

    	<div class="carousel-inner" role="listbox">
    		<div class="item active">
    			<a href="http://v.qq.com/cover/3/38uyds1h60wr7b5.html?vid=o0016m3ajom">
    				<img src="images/res-img/dl.png" alt="First Slide">
    			</a>
    		</div>

    		<div class="item">
    			<a href="http://www.iqiyi.com/v_19rrnb2z9k.html?vfm=2002_2345f">
    				<img src="images/res-img/xw.png" alt="Second Slide">
    			</a>
    		</div>

    		<div class="item">
    			<a href="http://www.letv.com/ptv/vplay/23832104.html?ch=2345_dh">
    				<img src="images/res-img/dt.png" alt="Third Slide">
    			</a>
    		</div>
    	</div>

    	<a href="#carousel-example-generic" class="left carousel-control" role="button" data-slide="prev">
    		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    		<span class="sr-only">Previous</span>
    	</a>
    	<a href="#carousel-example-generic" class="right carousel-control" role="button" data-slide="next">
    		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    		<span class="sr-only">Next</span>
    	</a>
    </div>
</div>
<br> -->
	<div>
	    <?= $content ?>
	</div>

<!-- <script src="js/bootstrap.min.js"></script> -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>