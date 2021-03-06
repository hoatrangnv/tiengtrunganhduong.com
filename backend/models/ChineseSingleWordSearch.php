<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ChineseSingleWord;

/**
 * ChineseSingleWordSearch represents the model behind the search form about `backend\models\ChineseSingleWord`.
 */
class ChineseSingleWordSearch extends ChineseSingleWord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['word', 'spelling', 'spelling_vi', 'meaning'], 'safe'],
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
        $query = ChineseSingleWord::find();

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
        ]);

        $query->andFilterWhere(['like', 'word', $this->word])
            ->andFilterWhere(['like', 'spelling', $this->spelling])
            ->andFilterWhere(['like', 'spelling_vi', $this->spelling_vi])
            ->andFilterWhere(['like', 'meaning', $this->meaning]);

        return $dataProvider;
    }
}
