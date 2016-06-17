<?php

use app\modules\Admin\CatDefalut\models\CatDefalut;
use app\modules\Admin\Location\models\Cities;
use app\modules\Admin\Location\models\Districts;
use app\modules\Admin\Location\models\Location;
use app\modules\Admin\Location\models\Provinces;
use app\modules\Admin\School\models\Schools;
use app\modules\AppBase\base\HintConst;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Admin\School\models\Schools */
/* @var $form yii\widgets\ActiveForm */
$yesno = (new CatDefalut())->getYesOrNoList();
?>

<div class="schools-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 45, 'value' => 'x']) ?>
    <?= $form->field($model, 'nickname')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => 12]) ?>
    <?= $form->field($model, 'zh_province_id')->dropDownList(ArrayHelper::map(Provinces::getProvinceList(), 'id', 'name')) ?>
    <?= $form->field($model, 'zh_citie_id')->dropDownList(ArrayHelper::map(Cities::getCityList(), 'id', 'name')) ?>
    <?= $form->field($model, 'zh_district_id')->dropDownList(ArrayHelper::map(Districts::getDistrictList(), 'id', 'name')) ?>
    <?php if ($flag == HintConst::$UPDATE) { ?>
        <?= $form->field($model, 'headmaster_id')->textInput() ?>
        <?= $form->field($model, 'code')->label() ?>
        <?= $form->field($model, 'starttime')->textInput() ?>
        <?= $form->field($model, 'endtime')->textInput() ?>
        <?= $form->field($model, 'ispassed')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <?= $form->field($model, 'isdeleted')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <?= $form->field($model, 'isout')->dropDownList(ArrayHelper::map($yesno, 'id', 'name_zh')) ?>
        <div class="fenge"></div>
        <?= $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'cat_default_id')->textInput() ?>
        <?= $form->field($model, 'catalogue_des_id')->textInput() ?>
        <?= $form->field($model, 'creater_id')->textInput() ?>
        <?= $form->field($model, 'creater_name')->textInput(['maxlength' => 45]) ?>

    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script language="javascript">
    var zh_provines_id,zh_city_id;

    var provines_name = 'schools-zh_province_id';
    var city_name = 'schools-zh_citie_id';
    var district_name = 'schools-zh_district_id';
//    $('#'+provines_name+'').val("所在省");
//    $('#'+city_name).value("所在市");
//    $('#'+district_name).value("请选择地区");
    $('#'+provines_name).change(function () {
        zh_provines_id = $('#schools-zh_province_id').val()
        $.getJSON('index.php?r=schools/citieslist&zh_provines_id=' + zh_provines_id, function (date) {
            $("#" + city_name + " option").remove();
            $("#" + city_name + "").append('<option value=0>所在市</option>');
            $.each(date, function (i, m) {
                $("#" + city_name + "").append('<option value=' + m.id + '>' + m.name + '</option>');
            })
        });
        $('#'+city_name).change(function () {
            zh_city_id = $('#schools-zh_province_id').val()
            $.getJSON('index.php?r=schools/districtslist&zh_city_id=' + zh_city_id, function (date2) {
                $("#" + district_name + " option").remove();
                $("#" + district_name + "").append('<option value=0>所在县</option>');
                $.each(date2, function (ii, mm) {
                    $("#" + district_name + "").append('<option value=' + mm.id + '>' + mm.name + '</option>');
                })
            });
        });
    });
</script>

