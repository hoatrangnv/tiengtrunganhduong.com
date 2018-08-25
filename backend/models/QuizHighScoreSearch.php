<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\QuizHighScore;

/**
 * QuizHighScoreSearch represents the model behind the search form of `backend\models\QuizHighScore`.
 */
class QuizHighScoreSearch extends QuizHighScore
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_id', 'user_id', 'score', 'duration', 'time'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = QuizHighScore::find();

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
            'quiz_id' => $this->quiz_id,
            'user_id' => $this->user_id,
            'score' => $this->score,
            'duration' => $this->duration,
            'time' => $this->time,
        ]);

        return $dataProvider;
    }
}
