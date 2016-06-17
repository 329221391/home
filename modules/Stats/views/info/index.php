<?php
/**
 * User: gjc
 *  2015/6/15 10:41
 */
use app\modules\AppBase\base\cat_def\CatDef;
use janisto\timepicker\TimePicker;

$item = '使用情况';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '统计'), 'url' =>Yii::$app->urlManager->createUrl(['Stats/school', 's' => $pathinfo['s'], 'e' => $pathinfo['e']])];
$this->params['breadcrumbs'][] = $item;
?>
<div class="container" style="padding-top:1em;">
    <div class="row">
        <div class="col-sm-3"><?= TimePicker::widget([
                'language' => 'zh-CN',
                'id' => 's',
                'name' => 'startdate',
                'value' => '开始时间',
                'mode' => 'datetime',
                'clientOptions' => [
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'HH:mm:ss',
                    'showSecond' => true,
                ]
            ]);
            ?></div>
        <div class="col-sm-3"><?= TimePicker::widget([
                'language' => 'zh-CN',
                'id' => 'e',
                'name' => 'enddate',
                'value' => '结束时间',
                'mode' => 'datetime',
                'clientOptions' => [
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'HH:mm:ss',
                    'showSecond' => true,
                ]
            ]);
            ?></div>
        <div class="col-sm-2">
            <button id="status" type="button" class="btn btn-success">统计</button>
        </div>
    </div>

    <div class="panel panel-warning" style="margin-right:2.7em;margin-top:1em;">
       <div class="panel-heading">
            <b><?= $item; ?>&nbsp;
              <?php
              if ($pathinfo['school_id']) { ?>
                  <a href="index.php?r=Stats/info/man&school_id=<?= $pathinfo['school_id'] ?>"> <?= $pathinfo['name'] ?></a>
              <?php } else {
                  echo $pathinfo['name'];
              } ?>
            </b>
       </div>
       <div class="panel-body">
           <table class="table table-striped table-hover table-bordered" style="margin-top:10px;">
               <tr style="background:#428bca;color:#fff;">
                   <th>分类</th>
                   <th>数量</th>
               </tr>
               <tr>
                   <td>用户</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['custom'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['custom']['num'] ?></a>
                       <?php } else {
                           echo $status['custom']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>图片</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['pic'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['pic']['num'] ?></a>
                       <?php } else {
                           echo $status['pic']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>文章</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['article'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['article']['num'] ?></a>
                       <?php } else {
                           echo $status['article']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>月评价</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['moneva'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['moneva']['num'] ?></a>
                       <?php } else {
                           echo $status['moneva']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>年评价</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['termeva'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['termeva']['num'] ?></a>
                       <?php } else {
                           echo $status['termeva']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>消息</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['msg'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['msg']['num'] ?></a>
                       <?php } else {
                           echo $status['msg']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>通知</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['note'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['note']['num'] ?></a>
                       <?php } else {
                           echo $status['note']['num'];
                       } ?>
                   </td>
               </tr>
               <tr>
                   <td>调查</td>
                   <td>
                       <?php
                       if (!$pathinfo['school_id']) { ?>
                           <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['vote'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['vote']['num'] ?></a>
                       <?php } else {
                           echo $status['vote']['num'];
                       } ?>
                   </td>

               </tr>
               <tr>
                 <td>红花</td>
                 <td>
                     <?php
                     if (!$pathinfo['school_id']) { ?>
                         <a href="index.php?r=Stats/usedsch/index&type=<?= CatDef::$mod['rf'] ?>&s=<?= $pathinfo['s'] ?>&e=<?= $pathinfo['e'] ?>"> <?= $status['redfl']['num'] ?></a>
                     <?php } else {
                         echo $status['redfl']['num'];
                     } ?>
                 </td>
               </tr>
           </table>
       </div>
    </div>
</div>
<script language="javascript">
    var s = "<?=$pathinfo['s'];?>"
    var e = "<?=$pathinfo['e'];?>"
    if (s == '') s = '开始日期';
    if (e == '') e = '结束日期';
    $("#s").val(s);
    $("#e").val(e);

    $("#status").click(function () {
        var s = $("#s").val();
        var e = $("#e").val();
        window.location.href = 'index.php?r=Stats/info/index&school_id=<?=$pathinfo['school_id'];?>&name=<?= $pathinfo['name']; ?>&s=' + s + '&e=' + e;
    });
</script>
