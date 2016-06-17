<?php

use app\modules\AppBase\base\cat_def\CatDef;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\Articles\models\Articles */

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '俱乐部审核'), 'url' => ['index', 'pri_type_id' => $pri_type_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', CatDef::getName($pri_type_id)), 'url' => ['index', 'pri_type_id' => $pri_type_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="padding-right:3.7em;">
    <h5><strong><?= Html::encode($model['title']) ?></strong></h5>
    <form action="" method="post">
        <table class="table table-striped table-hover table-bordered">
            <tr>
                <th>标题</th>
                <td><?= $model['title'] ?></td>
            </tr>
            <tr>
                <th>内容</th>
                <td><?php echo htmlspecialchars($model['contents']); ?></td>
            </tr>
            <tr>
                <th>配图</th>
                <td>
                    <?php foreach ($model['att'] as $v) { ?>
                        <img width="20%" src="http://www.jyq365.com/<?= $v['url_thumb'] ?>">
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
            </tr>
        </table>
    </form>
</div>
