<?php

namespace app\modules\Admin\Location\models;
use app\modules\AppBase\base\appbase\BaseAR;
use Yii;
/**
 * This is the model class for table "{{%zh_cities}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $zipcode
 * @property integer $zh_provines_id
 * @property string $createtime
 * @property string $updatetime
 */
class Cities extends BaseAR
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zh_cities}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'zh_provines_id'], 'integer'],
            [['createtime', 'updatetime'], 'safe'],
            [['name', 'zipcode'], 'string', 'max' => 20]
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
            'zipcode' => 'Zipcode',
            'zh_provines_id' => 'Zh Provines ID',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
    public static  function getCityList($zh_provines_id = 0)
    {
        $mo = Cities::find()->select(['id', 'name'])
            ->where(['zh_provines_id' => $zh_provines_id])
            ->all();
        $data = parent::getArray2Only_IdName($mo);
        array_unshift($data, ['id' => 0, 'name' => '所在市']);
        return $data;
    }
}
