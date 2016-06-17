<?php

namespace app\modules\Admin\School\models;

use Yii;

/**
 * This is the model class for table "{{%schools_ext}}".
 *
 * @property integer $id
 * @property integer $school_id
 * @property string $email
 * @property string $qq
 * @property string $weixin
 * @property string $blog
 * @property string $space
 * @property string $website
 * @property string $address
 * @property string $postcode
 */
class SchoolsExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schools_ext}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id'], 'integer'],
            [['email', 'qq', 'weixin', 'blog', 'space', 'website', 'postcode'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'email' => 'Email',
            'qq' => 'Qq',
            'weixin' => 'Weixin',
            'blog' => 'Blog',
            'space' => 'Space',
            'website' => 'Website',
            'address' => 'Address',
            'postcode' => 'Postcode',
        ];
    }
}
