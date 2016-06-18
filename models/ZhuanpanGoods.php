<?php

namespace app\models;

use Yii;


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
