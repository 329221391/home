<?php

namespace app\modules\Admin\Classes\models;

use Yii;

/**
 * This is the model class for table "{{%classes_ext}}".
 *
 * @property integer $id
 * @property integer $class_id
 * @property string $qq
 * @property string $email
 * @property string $weixin
 * @property string $space
 * @property string $blog
 * @property string $address
 * @property string $postcode
 * @property string $website
 */
class ClassesExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%classes_ext}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'class_id'], 'integer'],
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
            'class_id' => 'Class ID',
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
