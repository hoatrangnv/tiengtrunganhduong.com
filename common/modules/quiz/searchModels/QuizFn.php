<?php

namespace common\modules\quiz\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\quiz\models\QuizFn as QuizFnModel;

/**
 * QuizFn represents the model behind the search form about `common\modules\quiz\models\QuizFn`.
 */
class QuizFn extends QuizFnModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description', 'parameters', 'body', 'guideline'], 'safe'],
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
        $query = QuizFnModel::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'parameters', $this->parameters])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'guideline', $this->guideline]);

        return $dataProvider;
    }
}
