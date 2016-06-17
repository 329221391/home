<?php

namespace app\modules\Admin\Custom\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\Custom\models\Customs;

/**
 * CustomsSearch represents the model behind the search form about `app\modules\Admin\Custom\models\Customs`.
 */
class CustomsSearch extends Customs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'school_id', 'class_id', 'cat_default_id', 'catalogue_des_id', 'ispassed', 'isdeleted', 'isout'], 'integer'],
            [['name', 'name_zh', 'nickname', 'logo', 'password', 'token', 'tel', 'phone', 'ip', 'ip_last', 'createtime', 'startetime', 'endtime'], 'safe'],
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
        $query = Customs::find();

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
            'cat_default_id' => $this->cat_default_id,
            'catalogue_des_id' => $this->catalogue_des_id,
            'ispassed' => $this->ispassed,
            'isdeleted' => $this->isdeleted,
            'isout' => $this->isout,
            'createtime' => $this->createtime,
            'startetime' => $this->startetime,
            'endtime' => $this->endtime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_zh', $this->name_zh])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'ip_last', $this->ip_last]);

        return $dataProvider;
    }
}
