<?php

namespace app\modules\Admin\Vote\models;
use app\modules\AppBase\base\appbase\base\BaseContent;
use Yii;
/**
 * This is the model class for table "vote_con".
 * @property integer $id
 * @property integer $m_id
 * @property string $contents
 */
class VoteCon extends BaseContent
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_con';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id'], 'integer'],
            [['contents'], 'string']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'm_id' => 'M ID',
            'contents' => 'Contents',
        ];
    }
    public function addNew($d)
    {
        $votecon = new VoteCon();
        foreach ($d as $k => $v) {
            $votecon->$k = $v;
        }
        $votecon->save(false);
        return $votecon->attributes['id'];
    }
}
