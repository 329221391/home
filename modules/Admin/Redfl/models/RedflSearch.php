<?php

namespace app\modules\Admin\Redfl\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Redfl\models\Redfl;

/**
 * RedflSearch represents the model behind the search form about `app\modules\Admin\Redfl\models\Redfl`.
 */
class RedflSearch extends Redfl
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'author_id', 'author_tpye_id', 'pri_type_id', 'sub_type_id', 'school_id', 'class_id', 'for_someone_id'], 'integer'],
            [['contents', 'date', 'createtime'], 'safe'],
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
        $query = Redfl::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
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
            'for_someone_id' => $this->for_someone_id,
            'date' => $this->date,
            'createtime' => $this->createtime,
        ]);

        $query->andFilterWhere(['like', 'contents', $this->contents]);

        return $dataProvider;
    }
}
