<?php

use yii\helpers\Html;



$this->title = '食谱管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<script language="javascript">
var edit_url = 'index.php?r=manage/cook-book/edit-cook';
</script>
<?= Html::cssFile('@web/css/js_tree/default/style.min.css') ?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>


<div class="wrapper">
  <div class="col-sm-12">
    <section class="panel panel-success">
      <header class="panel-heading">
        <span>食谱管理</span>
      </header>
        <div class="panel-body">
        <span><mark style="color:#900;">注意：表格内数据点击即可编辑。</mark></span>
          <div class="adv-table editable-table">
            <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:15px;">
              <tr style="background:#5bc0de;color:#fff;">
                <th></th>
                <th class="text-center">星期一</th>
                <th class="text-center">星期二</th>
                <th class="text-center">星期三</th>
                <th class="text-center">星期四</th>
                <th class="text-center">星期五</th>
                <th class="text-center">星期六</th>
                <th class="text-center">星期日</th>
              </tr>
              <tr class="text-center">
                <th class="text-center" style="background:#f0ad4e;color:#fff;">早餐</th>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 96)"><?= $cook_info['96']?></span></td>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 116)"><?= $cook_info['116']?></span></td>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 126)"><?= $cook_info['126']?></span></td>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 136)"><?= $cook_info['136']?></span></td>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 147)"><?= $cook_info['147']?></span></td>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 166)"><?= $cook_info['166']?></span></td>
                <td><span title="编辑" onclick="listTable.edit(this, 'name', 176)"><?= $cook_info['176']?></span></td>
              </tr>
              <tr class="text-center">
                <th class="text-center" style="background:#5bc0de;color:#fff;">加餐</th>
                <td><span onclick="listTable.edit(this, 'name', 97)"><?= $cook_info['97']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 117)"><?= $cook_info['117']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 127)"><?= $cook_info['127']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 137)"><?= $cook_info['137']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 148)"><?= $cook_info['148']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 167)"><?= $cook_info['167']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 177)"><?= $cook_info['177']?></span></td>
              </tr>
              <tr class="text-center">
                <th class="text-center" style="background:#f0ad4e;color:#fff;">中餐</th>
                <td><span onclick="listTable.edit(this, 'name', 98)"><?= $cook_info['98']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 118)"><?= $cook_info['118']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 128)"><?= $cook_info['128']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 138)"><?= $cook_info['138']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 149)"><?= $cook_info['149']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 168)"><?= $cook_info['168']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 178)"><?= $cook_info['178']?></span></td>
              </tr>
              <tr class="text-center">
                <th class="text-center" style="background:#5bc0de;color:#fff;">加餐</th>
                <td><span onclick="listTable.edit(this, 'name', 99)"><?= $cook_info['99']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 119)"><?= $cook_info['119']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 129)"><?= $cook_info['129']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 139)"><?= $cook_info['139']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 150)"><?= $cook_info['150']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 169)"><?= $cook_info['169']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 179)"><?= $cook_info['179']?></span></td>
              </tr>
              <tr class="text-center">
                <th class="text-center" style="background:#f0ad4e;color:#fff;">晚餐</th>
                <td><span onclick="listTable.edit(this, 'name', 100)"><?= $cook_info['100']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 120)"><?= $cook_info['120']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 130)"><?= $cook_info['130']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 140)"><?= $cook_info['140']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 160)"><?= $cook_info['160']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 170)"><?= $cook_info['170']?></span></td>
                <td><span onclick="listTable.edit(this, 'name', 180)"><?= $cook_info['180']?></span></td>
              </tr>
            </table>
          </div><!-- adv-table结束 -->
          
        </div><!-- panel-body结束 -->
    </section>
  </div><!-- col-*结束 -->
</div><!-- wrapper结束 -->






