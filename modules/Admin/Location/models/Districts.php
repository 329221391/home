<?php

namespace app\modules\Admin\Location\models;
use app\modules\AppBase\base\appbase\BaseAR;
use Yii;
/**
 * This is the model class for table "{{%zh_districts}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $zh_city_id
 * @property string $createtime
 * @property string $updatetime
 */
class Districts extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zh_districts}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'zh_city_id'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['name'], 'string', 'max' => 20]
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
            'zh_city_id' => 'Zh City ID',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public static function getDistrictList($zh_city_id = 0)
    {
        $mo = Districts::find()->select(['id', 'name'])
            ->where(['zh_city_id' => $zh_city_id])
            ->all();
        $data = parent::getArray2Only_IdName($mo);
        array_unshift($data, ['id' => 0, 'name' => '所在县']);
        return $data;
    }
}
