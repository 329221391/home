<?php

namespace app\modules\Admin\Notes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Notes\models\Notes;

/**
 * NotesSearch represents the model behind the search form about `app\modules\Admin\Notes\models\Notes`.
 */
class NotesSearch extends Notes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pri_type_id', 'sub_type_id', 'school_id', 'class_id', 'custom_id', 'user_tpye_id', 'author_id', 'ispassed', 'issend', 'isdelete'], 'integer'],
            [['for_someone_id', 'title', 'contents', 'thumb', 'createtime', 'starttime', 'endtime'], 'safe'],
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
        $query = Notes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pri_type_id' => $this->pri_type_id,
            'sub_type_id' => $this->sub_type_id,
            'school_id' => $this->school_id,
            'class_id' => $this->class_id,
            'custom_id' => $this->custom_id,
            'user_tpye_id' => $this->user_tpye_id,
            'author_id' => $this->author_id,
            'createtime' => $this->createtime,
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
            'ispassed' => $this->ispassed,
            'issend' => $this->issend,
            'isdelete' => $this->isdelete,
        ]);

        $query->andFilterWhere(['like', 'for_someone_id', $this->for_someone_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'contents', $this->contents])
            ->andFilterWhere(['like', 'thumb', $this->thumb]);

        return $dataProvider;
    }
}
