<?php

namespace app\modules\Admin\Logs\models;

use app\modules\AppBase\base\appbase\BaseAR;
use app\modules\AppBase\base\BaseConst;
use app\modules\AppBase\base\CommonFun;
use app\modules\AppBase\base\HintConst;
use Yii;

/**
 * This is the model class for table "{{%logs}}".
 *
 * @property integer $id
 * @property integer $catalogue_id
 * @property string $describe
 * @property string $action
 * @property string $table_name
 * @property integer $table_id
 * @property string $field
 * @property string $before
 * @property string $after
 * @property string $createtime
 * @property string $updatetime
 * @property integer $ispassed
 * @property integer $isdeleted
 */
class Logs extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalogue_id', 'table_id', 'ispassed', 'isdeleted'], 'integer'],
            [['field','action', 'table_name', 'before', 'after','describe','catalogue_id', 'table_id', 'ispassed', 'isdeleted','createtime', 'updatetime'], 'safe'],
            [['describe'], 'string', 'max' => 225],
            [['field','action', 'table_name', 'before', 'after'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalogue_id' => 'Catalogue ID',
            'describe' => 'Describe',
            'action' => 'Action',
            'table_name' => 'Table Name',
            'table_id' => 'Table ID',
            'field' => 'Field',
            'before' => 'Before',
            'after' => 'After',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'ispassed' => 'Ispassed',
            'isdeleted' => 'Isdeleted',
        ];
    }
    public function addLogs($action, $id, $field, $before, $after)
    {
        if (isset(Yii::$app->session[BaseConst::$Table_Name])) {
            if (Yii::$app->session[BaseConst::$Table_Name] == BaseConst::$classes_T) {
                $logs = new LogsClasses();
            } else {
                $logs = new self();
            }
            $logs->table_name = Yii::$app->session[BaseConst::$Table_Name];
            $logs->action = $action;
            $logs->table_id = $id;
            $logs->field = $field;
            $logs->before = $before;
            if ($field == HintConst::$Field_password) {
                $logs->after = CommonFun::encrypt($after);
            } else {
                $logs->after = $after;
            }
            $logs->createtime = CommonFun::getCurrentDateTime();
            $logs->ispassed = HintConst::$YesOrNo_YES;
            $logs->isdeleted = HintConst::$YesOrNo_NO;
            $logs->save(false);
        }
    }
}
