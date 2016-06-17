<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = '招生管理';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>
<?= Html::jsFile('@web/plus/kindeditor-4.1.10/kindeditor-min.js') ?>
<div class="wrapper">
    <div class="col-sm-12">
        <section class="panel panel-info">
            <header class="panel-heading">
                <span>添加招生信息</span>
            </header>
            <div class="panel-body">
                <div class="wrapper">
                    <div class="col-sm-12">
                        <form class="form-horizontal" method="post" action="index.php?r=manage/zhaosheng/create">
                            <input type="hidden" id="first_img" name="first_img" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-10">
                                    <input class="form-control"  name="title" placeholder="30个汉字内">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">招生电话</label>
                                <div class="col-sm-10">
                                    <input class="form-control"  name="post_phone" placeholder="11位有效电话号码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">主体内容</label>
                                <div class="col-sm-10">
                                    <!--<input type="password" class="form-control" id="inputPassword3" placeholder="Password">-->
                                    <textarea class="form-control" name="content" style="height:400px;visibility:hidden;"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success" onclick="return checkForm()">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script>

    var editor;

    function checkForm(){
        var editorHtml = editor.html();
        var obj = $("<div>"+editorHtml+"</div>");
        var imgs = obj.find('img');
        var firstImg = '';
        if(imgs.length > 0){
            firstImg = imgs[0].src;
            $('#first_img').val(firstImg);
        }
        return true;
    }
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : false
        });

    });
</script>
</script>