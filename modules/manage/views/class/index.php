<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Classes\models\ClassesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = '班级管理';

?>
<script language="javascript">
var edit_url = 'index.php?r=manage/class/edit-class';
</script>
<?= Html::cssFile('@web/css/token-input.css') ?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>
<?php if($message <> ''){?>
<div class="alert alert-success" role="alert" id="add_alert">
	<button type="button" class="close" data-dismiss="alert" onclick="$('#add_alert').hide();"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<?= $message?>
</div>
<?php }?>

<!-- form -->
<div class="wrapper">
	<div class="col-sm-12">
		<section class="panel panel-info">
			<header class="panel-heading">
				<div class="class-title">
					<span>班级管理</span>
					<span class="pull-right">
						<form class="form-inline" action="" method="post">
							<div class="pull-right">
								<div class="form-group">
									<label class="sr-only" for="class_name"></label>
									<input type="text" class="form-control" name="class_name" placeholder="班级名称">
								</div>
								<div class="form-group">
									<label class="sr-only" for="teacher_id"></label>
									<input type="text" class="form-control" name="teacher_id" id="teacher_id" placeholder="主班老师">
									<input type="hidden" name="r" value="manage/class/index"/>
								</div>
								<button type="submit" class="btn btn-warning">添加班级</button>
		            			<button type="reset" class="btn btn-primary">重&nbsp;置</button>
	            			</div>
						</form>
					</span>
				</div>
			</header>
			<div class="panel-body">
				<span><mark style="color:#900;">注意：班级名称一栏点击即可编辑，审核一栏点击即可更改。</mark></span>
				<div class="adv-table editable-table">
					<table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:15px;">
						<tr style="background:#f0ad4e;color:#fff;">
							<th class="text-center">班级名称</th>
							<th class="text-center">班级CODE</th>
							<th class="text-center">主班老师</th>
							<th class="text-center">是否有效</th>
							<th class="text-center">是否已毕业</th>
							<th class="text-center">创建时间</th>
							<th class="text-center">操作</th>
						</tr>
						<?php foreach($models as $kk => $vv){?>
						<tr class="text-center" id="<?=$vv['id']?>">
							<td><span title="编辑" onclick="listTable.edit(this, 'name', <?= $vv['id']?>)"><?= $vv['name']?></span></td>
							<td><?= $vv['code']?></td>
							<td><?= $vv['teacher_name']?></td>
							<td><?= Html::img('@web/images/'.$vv['ispassed'].'.png',['onclick'=>"listTable.toggle(this, 'ispassed',".$vv['id'].")"])?></td>
							<td><?= Html::img('@web/images/'.$vv['isgraduated'].'.png',['onclick'=>"listTable.toggle(this, 'isgraduated',".$vv['id'].")"])?></td>
							<td><?= $vv['createtime']?></td>
							<td>
                                <a style="color:#fff;"  class="btn btn-xs btn-danger del-btn">删除</a>
								<a style="color:#fff;" class="btn btn-xs btn-info" href="index.php?r=manage/customs/index&type=1&class_id=<?= $vv['id']?>">详情</a>
							</td>
						</tr>
						<?php }?>
					</table>
				</div><!-- adv-table结束 -->
				
				<span class="pull-right">总数：<span style="color:#428bca;font-size:15px;"><?= $pages->totalCount?></span>&nbsp;条记录</span>
			</div><!-- panel-body结束 -->
		</section>
	</div><!-- col-sm-12结束 -->
</div><!-- wrapper结束 -->

<script type="text/javascript">


  var default_texting = function running(ob){
							  if(ob.html() == ''){
								 ob.jstree({
										  'core' : {
											'data' : {
												  'url' : 'index.php?r=manage/class/all-teacher',
												  'data' : function (node) {
														return { 'wwid' : node.id };
												  }
											  }
										   },
										   'plugins' : ['unique','wholerow']
								 })
								 .on('changed.jstree', function (e, data) {
									if(data && data.selected && data.selected.length && data.node) {
									   //check if id exite
									   //get input value
									   var ob = $("#teacher_id").tokenInput("get");
									   for(item in ob){
										  if(parseInt(ob[item].id) == parseInt(data.selected)){
											  exit();
										  }
									   }
									   $("#teacher_id").tokenInput("add", {id: data.selected, name: data.node.text});
									   return false;
									}
								})
							  }
							};

  $("#teacher_id").tokenInput('index.php?r=manage/class/search-teacher',{hintText:default_texting,noResultsText: "没有搜索结果",searchingText: "搜索中",tokenLimit: 1});
  $("#token-input-teacher_id").attr("placeholder","请选择主班老师");
  // 删除班级
  $(document).ready(function(){
      $(".del-btn").on('click',function(){
          id = $(this).parents("tr").attr('id');
          if(confirm("确定删除")){
              $.post("index.php?r=manage/class/delete",
                  { id:id },
                  function(data){
                      if(data=="成功删除"){
                          $("#"+id).hide();
                      }
                      alert(data);
                  });
          }
      })
  })
</script>

<?php
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>


