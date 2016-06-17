<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Admin\Classes\models\ClassesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 
$this->params['breadcrumbs'][] = $this->title;
?>
<script language="javascript">
var edit_url = 'index.php?r=manage/class/edit-class';
</script>

<?= Html::cssFile('@web/css/token-input.css') ?>
<?= Html::cssFile('@web/css/js_tree/default/style.min.css') ?>
<?= Html::cssFile('@web/css/style.min.css') ?>

<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>

 


