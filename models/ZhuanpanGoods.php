<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zhuanpan_goods".
 *
 * @property integer $id
 * @property integer $used
 * @property string $goods_name
 * @property integer $count
 * @property integer $type
 * @property integer $value
 * @property string $brand
 * @property string $purpose
 * @property string $image
 */
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
}
