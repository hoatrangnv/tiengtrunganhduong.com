<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MissingWord;

/**
 * MissingWordSearch represents the model behind the search form about `backend\models\MissingWord`.
 */
class MissingWordSearch extends MissingWord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'search_count', 'status'], 'integer'],
            [['word', 'last_search_time'], 'safe'],
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
        $query = MissingWord::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'search_count' => $this->search_count,
            'last_search_time' => $this->last_search_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'word', $this->word]);

        return $dataProvider;
    }
}
