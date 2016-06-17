<?php

namespace  app\modules\Admin\Articles\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Articles\models\Articles;

/**
 * ArticlesSearch represents the model behind the search form about `app\models\Articles`.
 */
class ArticlesSearch extends Articles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'school_id', 'class_id', 'article_type_id', 'sub_type_id', 'praise_times', 'share_times', 'view_times', 'ispassed', 'isdelete', 'isview'], 'integer'],
            [['title', 'subtitle', 'contents', 'thumb', 'date', 'createtime', 'updatetime'], 'safe'],
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
        $query = Articles::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'school_id' => $this->school_id,
            'class_id' => $this->class_id,
            'article_type_id' => $this->article_type_id,
            'sub_type_id' => $this->sub_type_id,
            'date' => $this->date,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'praise_times' => $this->praise_times,
            'share_times' => $this->share_times,
            'view_times' => $this->view_times,
            'ispassed' => $this->ispassed,
            'isdelete' => $this->isdelete,
            'isview' => $this->isview,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'contents', $this->contents])
            ->andFilterWhere(['like', 'thumb', $this->thumb]);

        return $dataProvider;
    }
}
