<?php
use yii\helpers\Html;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no" />
<?= Html::cssFile('@web/css/bootstrap.css') ?>
<?= Html::cssFile('@web/css/bootstrap-datetimepicker.min.css') ?>


<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/bootstrap-datetimepicker.min.js') ?>
<?= Html::jsFile('@web/js/bootstrap-datetimepicker.zh-CN.js') ?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>今日总结</title>
<style type="text/css">
<!--
.share_title {
	background-color: #28cacc;
	line-height: 3em;
	font-size: 1.5em;
	text-align: center;
	color: #FFFFFF;
}
* {
	font-family: "微软雅黑", Arial;
	line-height: 2.5em;
	margin: 0px;
	padding: 0px;
}

.blue {
	color: #0278fe;
}
.gray {
	color: #959595;
}

.pic_title {
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	line-height: 4em;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #959595;
	height: 4em;
}
.pic_content {
	width: 95%;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 6em;
	margin-left: auto;
}


-->
</style>
</head>
<body>
<div class="outer">
<div class="share_title">今日总结
<div class="glyphicon glyphicon-calendar" style="float:right;padding-right:4em;"><span class="" id="datetimepicker"><?php echo $date ?></span></div>

<script type="text/javascript">
   	$('#datetimepicker').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1,
		format:'yyyy-mm-dd'
    })
	.on('changeDate', function(ev){
	    alert(ev.date.getUTCFullYear()+'-'+ev.date.getUTCMonth()+'-'+ev.date.getUTCDate());
    });
   
</script>

</div>
<div class="pic_title container">家长你好！以下是
  <?php echo $user['name_zh'] ?>
  小朋友今天的在校情况</div>
<div class="container">
  <h3>食谱</h3>
  <div class="row">
    <div class="col-md-3">早餐</div>
    <div class="col-md-8"><?php echo $summary['cook_book']['breakfast']?></div>
  </div>
  <div class="row">
    <div class="col-md-3">加餐</div>
    <div class="col-md-8"><?php echo $summary['cook_book']['addone']?></div>
  </div>
  <div class="row">
    <div class="col-md-3">午餐</div>
    <div class="col-md-8"><?php echo $summary['cook_book']['lunch']?></div>
  </div>
  <div class="row">
    <div class="col-md-3">加餐</div>
    <div class="col-md-8"><?php echo $summary['cook_book']['addtwo']?></div>
  </div>
  <div class="row">
    <div class="col-md-3">晚餐</div>
    <div class="col-md-8"><?php echo $summary['cook_book']['dinner']?></div>
  </div>
  
  <h3>生活情况</h3>
  <div class="row">
    <div class="col-md-3">吃饭情况</div>
    <div class="col-md-8"><?php echo $summary['eat']?></div>
  </div>
  <div class="row">
    <div class="col-md-3">睡觉情况</div>
    <div class="col-md-8"><?php echo $summary['sleep']?></div>
  </div>  
  <div class="row">
    <div class="col-md-3">学习情况</div>
    <div class="col-md-8"><?php echo $summary['course']?>tttttt</div>
  </div>  
  <div class="row">
    <div class="col-md-3">活动情况</div>
    <div class="col-md-8"><?php echo $summary['outdoor']?></div>
  </div>    
   <div class="row">
    <div class="col-md-3">课程情况</div>
    <div class="col-md-8"><?php echo $summary['lessons']?></div>
  </div>    
   <div class="row">
    <div class="col-md-3">家庭作业</div>
    <div class="col-md-8"><?php echo $summary['homework']?></div>
  </div>    
  <h3>照片</h3>
  <?php foreach($summary['att_list'] as $kk => $vv){?>
      <img src="<?php echo $vv?>" />
  <?php }?>
      
</div>
</body>
</html>
