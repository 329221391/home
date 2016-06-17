<?php

namespace app\modules\Admin\Location\models;
use app\modules\AppBase\base\appbase\BaseAR;
use Yii;
/**
 * This is the model class for table "{{%zh_provinces}}".
 * @property integer $id
 * @property string $name
 * @property string $createtime
 * @property string $updatetime
 */
class Provinces extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zh_provinces}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public static function getProvinceList()
    {
        $data = Provinces::find()->asArray()
            ->select('id,name')
            ->all();
        array_unshift($data, ['id' => 0, 'name' => '所在省']);
        return $data;
    }
}
