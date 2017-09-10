<?php

namespace common\modules\quiz\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\quiz\models\QuizInputValidator as QuizInputValidatorModel;

/**
 * QuizInputValidator represents the model behind the search form about `common\modules\quiz\models\QuizInputValidator`.
 */
class QuizInputValidator extends QuizInputValidatorModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quiz_fn_id', 'quiz_id'], 'integer'],
            [['name', 'arguments', 'error_message'], 'safe'],
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
        $query = QuizInputValidatorModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
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
            'quiz_fn_id' => $this->quiz_fn_id,
            'quiz_id' => $this->quiz_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'arguments', $this->arguments])
            ->andFilterWhere(['like', 'error_message', $this->error_message]);

        return $dataProvider;
    }
}
