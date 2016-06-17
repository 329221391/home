<?php

use app\modules\AppBase\base\HintConst;
use yii\helpers\Html;


$this->title = '红花详情';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '宝贝红花'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-info">
            <header class="panel-heading">
                <span>红花详情</span>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:20px;">
                    <tr style="background:#f0ad4e;color:#fff;">
                        <th class="text-center">标题</th>
                        <th class="text-center">内容</th>
                    </tr>
                    <tr>
                        <td align="center"><?=$model['pri_type_id'] == 249 ? '红花' : '金花' ?></td>
                        <td>
                            <img src="<?=$model['pri_type_id'] == 249 ? '/images/emi_red_flower.png' : '/images/emi_gold_flower.png' ?>"/>
                        </td>
                    </tr>
                    </table>
                </div>
            </div><!-- panel-body结束 -->
        </section>
    </div><!-- col-*结束 -->
</div><!-- wrapper结束 -->