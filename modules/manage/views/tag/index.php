<?php
use yii\helpers\Html;

$this->title = '标签管理';
$this->params['breadcrumbs'][] = $this->title;


?>
<script language="javascript">
    var edit_url = 'index.php?r=manage/school/edit-school';
    var edit_url2 = 'index.php?r=manage/school/edit-custom';
</script>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-info">
            <header class="panel-heading">
                <span>标签管理</span>
            </header>

            <?php foreach ($tag_arr as $kk => $vv) { ?>
            <div class="panel-body">
                <div class="form-group"  style="border: 1px sold #eee;">
                    <h5 class="col-sm-1 text-center tag-title"><?= $vv['tag_name'] ?>：</h5>
                    <div class="col-sm-3">
                        <form action="" method="post">
                            <div class="input-group">
                                <input type="text" name="tag_value" class="form-control" placeholder="add new tags..">
                                <span class="input-group-btn">
                                    <button class="btn btn-warning" type="submit">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <input type="hidden" name="parent_id" value="<?= $kk ?>"/>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>

                </div><br>
                <div class="form-group form_padding">
                    <?php foreach ($vv['arr'] as $k => $v) { ?>
                        <span class="tag_value"><?= $v['name_zh'] ?>
                            <span class="glyphicon glyphicon-remove delete_tag" style="visibility: visible;" title="删除"
                                date="<?= $v['id'] ?>">
                            </span>

                            <!-- <button type="button" class="close"
                                data-dismiss="modal" aria-hidden="true" style="color:#fff;">
                                &times;
                            </button> -->
                        </span>
                    <?php } ?>
                </div><hr>
            </div>
            <?php } ?>
        </section>
    </div>
</div>


<script language="javascript">
    $(".tag_value").mousemove(function () {
        $(this).attr('class', 'edit_tag');
        // $(this).children(".glyphicon").css({visibility: 'visible'});
    });
    $(".tag_value").mouseout(function () {
        $(this).attr('class', 'tag_value');
        // $(this).children(".glyphicon").css({visibility: 'hidden'});
    });
    $(".delete_tag").click(function () {
        if (confirm('确定删除该标签')) {
            window.location.href = 'index.php?r=manage/tag/delete-tag&id=' + $(this).attr('date');
        }
    });
</script>