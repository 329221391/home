<?php


namespace app\modules\Admin\Pic\controllers;
use app\modules\AppBase\base\appbase\base\BaseExcept;
use app\modules\AppBase\base\appbase\BaseController;
use app\modules\AppBase\base\HintConst;
use Yii;
use yii\db\Query;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class PicController extends BaseController{

    public function actionUpload(){
        $school_id = Yii::$app->request->post('school_id',$this->getCustomSchool_id());
        $class_id = Yii::$app->request->post('class_id',Yii::$app->session['custominfo']->custom->class_id);
        $file_name = $this->create_img($school_id,$class_id);
        $file_name = $file_name <> '' ? $file_name . '.thumb.jpg' : '';
        return json_encode(['ErrCode'=>0,'Content'=>$file_name]);
    }



    public function create_img($school_id, $class_id, $images_lable = 'images')
    {
        try {
            if (!$images_lable) {
//            $result = ['ErrCode' => HintConst::$No_image, 'Message' => '缺少参数', 'Content' => []];
                return '';
            }
            $thumb = UploadedFile::getInstanceByName($images_lable);

            if ($thumb) {
                $img_path = 'uploads/';
                $img_path .= date('Y-m-d') . '/';
                if ($school_id) {
                    $img_path .= $school_id . '/';
                }
                if ($class_id) {
                    $img_path .= $class_id . '/';
                }
                if (!is_dir($img_path)) {
                    if (BaseFileHelper::createDirectory($img_path)) {
                    } else {
                        $result = ['ErrCode' => '7474', 'Message' => '权限不足，无法上传图片', 'Content' => []];
                        die (json_encode($result));
                    }
                }
                $base_filename = rand(1000, 9999) . time();
                $pic_url = $img_path . $base_filename . '.jpg';
                $thumb->saveAs($pic_url);   //保存图片到指定路径
                //根据图片路径打上水印
                $query = new Query();
                $school = $query->select('name')->from('schools')->where(['id' => $this->getCustomSchool_id()])->one();//得到用户的学校名称
                if (false === ($image_size = getimagesize($pic_url))) {
                    (new BaseExcept())->execpt_notimage("error for image_size");
                }
                if ($school['name']) {
                    $font_long = strlen($school['name']) * 5 + 20;
                    $position_x = $image_size[0] - $font_long;
                    $position_y = $image_size[1] - 26;
                    Image::text($pic_url, $school['name'], './ms_black.ttf', [$position_x + 1, $position_y + 1], ['size' => 12, 'color' => '000'])->save($pic_url, ['quality' => HintConst::$Pic_Quality]);
                    Image::text($pic_url, $school['name'], './ms_black.ttf', [$position_x, $position_y], ['size' => 12])->save($pic_url, ['quality' => HintConst::$Pic_Quality]);
                }
                //根据图片路径  生成缩略图
                $thumb_url = $img_path . $base_filename . '.thumb.jpg';
                if ($image_size) {
                    //计算宽高比  得出图片高度
                    $thumb_height = floor(HintConst::$Pic_Width * ($image_size[1] / $image_size[0]));
                    Image::thumbnail($pic_url, HintConst::$Pic_Width, $thumb_height)
                        ->save($thumb_url, ['quality' => HintConst::$Pic_Quality]); //保存缩略图片到指定路径
                }
                $file_path = $img_path . $base_filename;
                return $file_path;
            } else {
                return '';
            }
        } catch (\Exception $e) {
            //(new BaseExcept())->execpt_nosuccess($e->getMessage());
            var_dump($e->getMessage());
            exit;
        }
    }

}