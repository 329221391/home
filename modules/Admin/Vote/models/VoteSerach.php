<?php

namespace app\modules\Admin\Vote\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Vote\models\Vote;

/**
 * VoteSerach represents the model behind the search form about `app\modules\Admin\Vote\models\Vote`.
 */
class VoteSerach extends Vote
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'author_tpye_id', 'pri_type_id', 'sub_type_id', 'school_id', 'class_id', ' yes', 'no'], 'integer'],
            [['title', 'contents', 'date', 'createtime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Vote::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'author_id' => $this->author_id,
            'author_tpye_id' => $this->author_tpye_id,
            'pri_type_id' => $this->pri_type_id,
            'sub_type_id' => $this->sub_type_id,
            'school_id' => $this->school_id,
            'class_id' => $this->class_id,
            'date' => $this->date,
            'createtime' => $this->createtime,
            ' yes' => $this-> yes,
            'no' => $this->no,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'contents', $this->contents]);

        return $dataProvider;
    }
}
