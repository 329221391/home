<?php

namespace app\modules\Admin\Vote\models;
use app\modules\AppBase\base\appbase\base\BaseAtt;
use Yii;
/**
 * This is the model class for table "vote_att".
 * @property integer $id
 * @property integer $m_id
 * @property integer $type_id
 * @property string $url
 * @property string $url_thumb
 */
class VoteAtt extends BaseAtt
{private $sel_arr='id,url,url_thumb';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_att';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'type_id'], 'integer'],
            [['url', 'url_thumb'], 'string', 'max' => 255]
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
            'type_id' => 'Type ID',
            'url' => 'Url',
            'url_thumb' => 'Url Thumb',
        ];
    }
    public function addNew($d)
    {
        $voteatt = new VoteAtt();
        foreach ($d as $k => $v) {
            $voteatt->$k = $v;
        }
        $voteatt->save(false);
        return $voteatt->attributes['id'];
    }
    public function getAtt($id)
    {
        $mc_name = $this->getMcName() . 'getAtt' . $id;
        if ($val = $this->mc->get($mc_name)) {
            $Content = $val;
        } else {
            $Content = VoteAtt::find()->asArray()
                ->select($this->sel_arr)
                ->where(['m_id' => $id])
                ->all();
            $this->mc->add($mc_name, $Content);
        }
        return $Content;
    }
}
