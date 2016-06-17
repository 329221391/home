<?php
/**
 * User: gjc
 *  2015/6/15 10:41
 */
use app\modules\AppBase\base\cat_def\CatDef;
use yii\widgets\LinkPager;


$this->title = CatDef::getName($pri_type_id);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '俱乐部审核'), 'url' => ['index', 'pri_type_id' => $pri_type_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="padding-right:3em;">
    <table class="table table-striped table-hover table-bordered" style="margin-top:10px;">
        <tr style="background:#f0ad4e;color:#fff;">
            <th class="text-center">ID</th>
            <th class="text-center">作者</th>
            <th class="text-center">缩略图</th>
            <th class="text-center">标题</th>
            <th class="text-center">内容</th>
            <th class="text-center">创建时间</th>
            <th class="text-center">操作</th>
        </tr>

        <?php foreach ($status['data'] as $k => $v) { ?>
            <tr class="text-center">
                <td style="width:5%;"><?= $v['id'] ?></td>
                <td style="width:6%;"><?= $v['name_zh'] ?></td>
                <td>
                    <?php if (!is_null($v['url_thumb'])) { ?>
                        <img width="80%" src="http://www.jyq365.com/<?= $v['url_thumb'] ?>">
                    <?php } ?>
                </td>
                <td><?= mb_substr($v['title'], 0, 20) ?></td>
                <td><?= mb_substr($v['contents'], 0, 100) ?>...</td>
                <td><?= $v['createtime'] ?></td>
                <td style="width:10%;">
                    <a class="btn btn-xs btn-danger" href="javascript:if(confirm('确定删除')){window.location.href='index.php?r=Stats/club/delete&pri_type_id=<?= $pri_type_id ?>&id=<?= $v['id'] ?>';}">删除</a>
                    <a class="btn btn-xs btn-info" href="index.php?r=Stats/club/view&pri_type_id=<?= $pri_type_id ?>&id=<?= $v['id'] ?>">详情</a>
            </tr>
        <?php } ?>
    </table>
    <span class="pull-right">
        <?= LinkPager::widget([
            'pagination' => $status['pages'],
        ]);
        ?>
    </span>
</div>




