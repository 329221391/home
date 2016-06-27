<?php

namespace app\models;

use Yii;
use app\modules\AppBase\base\HintConst;

class ZhuanpanGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zhuanpan_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['used', 'count', 'type', 'value'], 'integer'],
            [['goods_name', 'brand'], 'string', 'max' => 45],
            [['purpose', 'image'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'used' => 'Used',
            'goods_name' => 'Goods Name',
            'count' => 'Count',
            'type' => 'Type',
            'value' => 'Value',
            'brand' => 'Brand',
            'purpose' => 'Purpose',
            'image' => 'Image',
        ];
    }

    public function uploadImage($file, $origin_image){
        $image = "";
        $type = '';
        if ($file['type'] == "image/png"
        || $file['type'] == "image/jpeg"
        || $file['type'] == "image/jpg"
        || $file['type'] == "image/gif") {
            if ($file['type'] == "image/png") {
                $type = 'png';
            } elseif ($file['type'] == "image/jpeg") {
                $type = 'jpeg';
            } elseif ($file['type'] == "image/gif") {
                $type = 'gif';
            } else {
                echo '图片格式不对！'; exit;
            }
        }

        if ($file['size'] >= 2000000) {
            echo "您选择的图片太大！请选择不超过2M的图片";  
            exit;
        }

        if ($file['error'] > 0) {
            echo "文件上传失败：".$file['error']."<br>"; exit;
        //表示新建图片文件，新建图片和
        } elseif (empty($origin_image)) {
            $image = "images/zhuanpan/goods/".time().".$type";
            move_uploaded_file($_FILES["file"]["tmp_name"], $image);
        //表示编辑上传图片文件,再把原来的图片删除。
        } elseif (!empty($origin_image)) {
            
            $image = "images/zhuanpan/goods/".time().".$type";
            move_uploaded_file($_FILES["file"]["tmp_name"], $image);
            $thumb = explode('.',$origin_image);
            $thumb = $thumb[0]."_thumb.".$thumb[1];
            @unlink($origin_image);
            @unlink($thumb);

        }
            /*生成缩略图*/
            $image_info = @getimagesize($image);
            if (!$image_info) {
                echo "缩略图成失败！"; exit;
            }
            //原始图的宽度和高度
            $width=$image_info[0];
            $height=$image_info[1];
            //原始图片不得低于100
            if ($width < HintConst::$Thumb_Max_Width) {
                echo "图片尺寸大小！请重新选择";
                exit;
            }
            //缩放比
            $scale=HintConst::$Thumb_Max_Width/$width;
            //缩略图的宽度和高度
            $max_width=$width*$scale;
            $max_height=$height*$scale;
            //创建缩略图画布
            //print_r($image_info['mime']); exit;
            $thumb=imagecreatetruecolor($max_width,$max_height);
            switch ($image_info['mime']) {
                case 'image/jpeg':
                    $image_rsc=imagecreatefromjpeg($image);
                    break;
                case 'image/png':
                    $image_rsc=imagecreatefrompng($image);
                    break;
                case 'image/gif':
                    $image_rsc=imagecreatefromgif($image);
                    break;
                case 'image/bmp':
                    $image_rsc=imagecreatefromwbmp($image);
                    break;
                default:
                    echo "上传图片格式不支持thumb生成!";
                    exit;
            }
        $i=imagecopyresampled($thumb, $image_rsc, 0, 0, 0, 0, $max_width,$max_height,$width,$height);
        $thumb_path="images/zhuanpan/goods/".time()."_thumb.$type";
        $b = imagejpeg($thumb, $thumb_path, 100);
        return $image;
    }
}