<?php

namespace app\modules\Admin\Custom\models;

use Yii;

/**
 * This is the model class for table "customs_ext".
 *
 * @property integer $id
 * @property integer $custom_id
 * @property string $qq
 * @property string $email
 * @property string $weixin
 * @property string $space
 * @property string $blog
 * @property string $address
 * @property string $postcode
 * @property string $website
 */
class CustomsExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customs_ext';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'custom_id'], 'integer'],
            [['qq', 'email', 'weixin', 'blog', 'postcode'], 'string', 'max' => 45],
            [['space'], 'string', 'max' => 80],
            [['address', 'website'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'custom_id' => 'Custom ID',
            'qq' => 'Qq',
            'email' => 'Email',
            'weixin' => 'Weixin',
            'space' => 'Space',
            'blog' => 'Blog',
            'address' => 'Address',
            'postcode' => 'Postcode',
            'website' => 'Website',
        ];
    }
}
