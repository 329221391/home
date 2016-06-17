<?php
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
    <title></title>
    <?= Html::cssFile('@web/css/bootstrap.css') ?>
    <?= Html::cssFile('@web/css/mobile/base.css') ?>
</head>
<body>

<?php $this->beginBody() ?>

<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<?= $content ?>

<?php $this->endBody() ?>
<script>
    $(function(){
        function imgclick(event){
            window.location.href = event.target.src;
        }
        $('.content').find('img').each(function(index,ele){
            $(ele).css("width","100%");
            $(ele).click(imgclick);
        });
    })
</script>
</body>
</html>
<?php $this->endPage() ?>