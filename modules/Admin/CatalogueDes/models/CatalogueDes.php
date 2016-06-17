<?php

namespace app\modules\Admin\CatalogueDes\models;

use Yii;

/**
 * This is the model class for table "catalogue_des".
 *
 * @property integer $id
 * @property integer $school_id
 * @property integer $parent_id
 * @property string $name_zh
 * @property integer $priority
 * @property string $describe
 * @property string $createtime
 * @property string $updatetime
 * @property integer $last_admin_id
 * @property integer $ispassed
 * @property integer $isdeleted
 */
class CatalogueDes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'catalogue_des';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['school_id', 'parent_id', 'priority', 'last_admin_id', 'ispassed', 'isdeleted'], 'integer'],
            [['name_zh'], 'string'],
            [['createtime', 'updatetime'], 'safe'],
            [['describe'], 'string', 'max' => 100]
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
            'parent_id' => 'Parent ID',
            'name_zh' => 'Name Zh',
            'priority' => 'Priority',
            'describe' => 'Describe',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'last_admin_id' => 'Last Admin ID',
            'ispassed' => 'Ispassed',
            'isdeleted' => 'Isdeleted',
        ];
    }
}
