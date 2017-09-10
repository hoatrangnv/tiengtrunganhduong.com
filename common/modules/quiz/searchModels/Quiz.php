<?php

namespace common\modules\quiz\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\quiz\models\Quiz as QuizModel;

/**
 * Quiz represents the model behind the search form about `common\modules\quiz\models\Quiz`.
 */
class Quiz extends QuizModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'escape_html', 'duration', 'countdown_delay', 'sort_order', 'active', 'visible', 'doindex', 'dofollow', 'featured', 'create_time', 'update_time', 'publish_time', 'creator_id', 'updater_id', 'image_id', 'quiz_category_id', 'view_count', 'like_count', 'comment_count', 'share_count'], 'integer'],
            [['name', 'slug', 'introduction', 'timeout_handling', 'showed_stopwatches', 'input_answers_showing', 'description', 'meta_title', 'meta_description', 'meta_keywords'], 'safe'],
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
        $query = QuizModel::find();

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
            'escape_html' => $this->escape_html,
            'duration' => $this->duration,
            'countdown_delay' => $this->countdown_delay,
            'sort_order' => $this->sort_order,
            'active' => $this->active,
            'visible' => $this->visible,
            'doindex' => $this->doindex,
            'dofollow' => $this->dofollow,
            'featured' => $this->featured,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'publish_time' => $this->publish_time,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'image_id' => $this->image_id,
            'quiz_category_id' => $this->quiz_category_id,
            'view_count' => $this->view_count,
            'like_count' => $this->like_count,
            'comment_count' => $this->comment_count,
            'share_count' => $this->share_count,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'timeout_handling', $this->timeout_handling])
            ->andFilterWhere(['like', 'showed_stopwatches', $this->showed_stopwatches])
            ->andFilterWhere(['like', 'input_answers_showing', $this->input_answers_showing])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords]);

        return $dataProvider;
    }
}
