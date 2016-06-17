<?php

namespace app\modules\Admin\Logs\models;

use app\modules\AppBase\base\appbase\BaseAR;
use Yii;

/**
 * This is the model class for table "{{%logs_classes}}".
 *
 * @property integer $id
 * @property integer $class_id
 * @property string $field_name
 * @property string $before
 * @property string $after
 * @property string $createtime
 */
class LogsClasses extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logs_classes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_id'], 'integer'],
            [['class_id','field_name', 'before', 'after','createtime'], 'safe'],
            [['field_name', 'before', 'after'], 'string', 'max' => 50]
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
            'field_name' => 'Field Name',
            'before' => 'Before',
            'after' => 'After',
            'createtime' => 'Createtime',
        ];
    }
}
