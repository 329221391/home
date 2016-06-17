<?php

namespace app\modules\Admin\Classes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Classes\models\Classes;

/**
 * ClassesSearch represents the model behind the search form about `app\modules\Admin\Classes\models\Classes`.
 */
class ClassesSearch extends Classes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'school_id', 'teacher_id', 'subteacher1_id', 'subteacher2_id', 'cat_default_id', 'catalogue_des_id', 'ispassed', 'isdeleted', 'isgraduated', 'isout'], 'integer'],
            [['name', 'namenick', 'code', 'logo', 'createtime', 'updatetime'], 'safe'],
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
        $query = Classes::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'school_id' => $this->school_id,
            'teacher_id' => $this->teacher_id,
            'subteacher1_id' => $this->subteacher1_id,
            'subteacher2_id' => $this->subteacher2_id,
            'cat_default_id' => $this->cat_default_id,
            'catalogue_des_id' => $this->catalogue_des_id,
            'ispassed' => $this->ispassed,
            'isdeleted' => $this->isdeleted,
            'isgraduated' => $this->isgraduated,
            'isout' => $this->isout,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'namenick', $this->namenick])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
