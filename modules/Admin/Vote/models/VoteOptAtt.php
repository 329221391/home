<?php

namespace app\modules\Admin\Vote\models;

use app\modules\AppBase\base\appbase\base\BaseAtt;
use Yii;

/**
 * This is the model class for table "vote_opt_att".
 *
 * @property integer $id
 * @property integer $m_id
 * @property integer $type_id
 * @property string $url
 * @property string $url_thumb
 */
class VoteOptAtt extends BaseAtt
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vote_opt_att';
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
        $voteoptatt = new VoteOptAtt();
        foreach ($d as $k => $v) {
            $voteoptatt->$k = $v;
        }
        $voteoptatt->save(false);
        return $voteoptatt->attributes['id'];
    }
}
