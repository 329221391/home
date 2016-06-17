<?php
use yii\helpers\Html;

?>
<?= Html::cssFile('@web/plus/kindeditor-4.1.10/themes/default/default.css') ?>
<?= Html::cssFile('@web/css/token-input.css') ?>
<?= Html::cssFile('@web/css/js_tree/default/style.min.css') ?>

<?= Html::jsFile('@web/plus/kindeditor-4.1.10/kindeditor.js') ?>
<?= Html::jsFile('@web/plus/kindeditor-4.1.10/lang/zh_CN.js') ?>
<?= Html::jsFile('@web/plus/kindeditor-4.1.10/plugins/code/prettify.js') ?>
<?= Html::jsFile('@web/js/jquery.js') ?>
<?= Html::jsFile('@web/js/jquery.tokeninput.js') ?>
<?= Html::jsFile('@web/js/jstree.min.js') ?>
<?= Html::jsFile('@web/js/listtable.js') ?>
<?= Html::jsFile('@web/js/bootstrap.min.js') ?>

<?php $this->beginPage() ?>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">审核提醒</h3>
            </div>
            <ul class="list-group">
                <a href="index.php?r=manage/article&ispassed=212" class="list-group-item"><span
                        class="glyphicon glyphicon-edit"></span> 待审文章 <span class="badge" id="dswz">0</span></a>
                <a href="index.php?r=manage/pic/index&ispassed=212" class="list-group-item"><span
                        class="glyphicon glyphicon-picture"></span> 待审图片 <span class="badge" id="dstp">0</span></a>
                <a href="index.php?r=manage/pingjia/index&ispassed=212&" class="list-group-item"><span
                        class="glyphicon glyphicon-edit"></span> 待审评价 <span class="badge" id="dspj">0</span></a>
            </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">私信</h3>
            </div>
        </div>
    </div>
</div>
<script>
    KindEditor.ready(function (K) {
        var editor1 = K.create('textarea[name="content1"]', {
            cssPath: '../plugins/code/prettify.css',
            uploadJson: 'plus/kindeditor-4.1.10/php/upload_json.php',
            fileManagerJson: 'plus/kindeditor-4.1.10/php/file_manager_json.php',
            allowFileManager: true,
            afterCreate: function () {
                var self = this;
                K.ctrl(document, 13, function () {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
                K.ctrl(self.edit.doc, 13, function () {
                    self.sync();
                    K('form[name=example]')[0].submit();
                });
            }
        });
        prettyPrint();
        $('#submit_article').click(function () {
            var title = $('#title').val();
            var content = editor1.html();
            var send_to = $('#get_send_to_id').val();
            if (title.length > 0 && content.length > 0 && send_to.length > 0) {
                //$.getJSON('index.php?r=manage/article/create&title='+title+'&content='+content+'&send_to='+send_to,function(date){
                $.post('index.php?r=manage/article/create', {
                    title: title,
                    content: content,
                    send_to: send_to
                }, function (date) {
                    if (date.error == 0) {
                        alert(date.message);
                        window.location.href = window.location.href;
                    } else {
                        alert(date.message);
                        alert(date.content);
                    }
                }, "json");
            } else {
                alert('请填写完整选项内容');
            }
        });
    });
    $(document).ready(function () {
        $.getJSON("index.php?r=manage/default/get-prama", function (json) {
            $("#dswz").html(json.dswz);
            $("#dstp").html(json.dstp);
            $("#dspj").html(json.dspj);
        });
    })
</script>
<?php
$htmlData = '';
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">发布文章</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <label for="title">文章标题</label>
                    </div>
                    <div class="col-md-10" style="padding-top:0.3em;">
                        <input type="title" class="form-control" name="title" placeholder="文章标题" id="title">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="title">指定接收人</label>
                    </div>
                    <div class="col-md-10" style="padding-top:0.3em;">
                        <input type="text" aria-required="true" data-selected="" style="display:none;"
                               class="form-control" name="send_to" id="get_send_to_id">
                        <script type="text/javascript">
                            var default_texting = function running(ob) {
                                if (ob.html() == '') {
                                    ob.jstree({
                                        'core': {
                                            'data': {
                                                'url': 'index.php?r=manage/default/get-tree',
                                                'data': function (node) {
                                                    return {'wwid': node.id};
                                                }
                                            }
                                        },
                                        'plugins': ['unique', 'wholerow']
                                    })
                                        .on('changed.jstree', function (e, data) {
                                            if (data && data.selected && data.selected.length && data.node) {
                                                //check if id exite
                                                //get input value
                                                var ob = $("#get_send_to_id").tokenInput("get");
                                                for (item in ob) {
                                                    if (parseInt(ob[item].id) == parseInt(data.selected)) {
                                                        exit();
                                                    }
                                                }
                                                $("#get_send_to_id").tokenInput("add", {
                                                    id: data.selected,
                                                    name: data.node.text
                                                });
                                                return false;
                                            }
                                        })
                                }
                            };
                            $("#get_send_to_id").tokenInput('index.php?r=manage/default/search-name', {
                                hintText: default_texting,
                                noResultsText: "没有搜索结果",
                                searchingText: "搜索中"
                            });
                        </script>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label for="title">文章内容</label>
                    </div>
                    <div class="col-md-10" style="padding-top:0.3em;">
                        <textarea name="content1" class="form-control" style="visibility:hidden;"
                                  id="content"><?php echo htmlspecialchars($htmlData); ?></textarea>
                        <br/>
                        <button type="submit" class="btn btn-success" id="submit_article">提交内容</button>
                        (提交快捷键: Ctrl + Enter)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
