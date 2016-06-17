<?php

namespace app\modules\admin\vote\models;
use app\modules\AppBase\base\appbase\base\BaseAtt;
use Yii;
/**
 * This is the model class for table "vote_reply_att".
 * @property integer $id
 * @property integer $m_id
 * @property integer $link_id
 * @property integer $type_id
 * @property string $url
 * @property string $url_thumb
 */
class VoteReplyAtt extends BaseAtt
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_reply_att';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m_id', 'link_id', 'type_id'], 'integer'],
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
            'link_id' => 'Link ID',
            'type_id' => 'Type ID',
            'url' => 'Url',
            'url_thumb' => 'Url Thumb',
        ];
    }
    public function addNew($d)
    {
        $self = new self();
        foreach ($d as $k => $v) {
            $self->$k = $v;
        }
        $self->save(false);
        return $self->attributes['id'];
    }
}
