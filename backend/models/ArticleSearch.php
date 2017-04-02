<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `backend\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'updater_id', 'category_id', 'image_id', 'active', 'visible', 'hot', 'status', 'type', 'sort_order', 'create_time', 'update_time', 'publish_time', 'views', 'likes', 'comments', 'shares'], 'integer'],
            [['slug', 'name', 'meta_title', 'meta_keywords', 'meta_description', 'description', 'content', 'sub_content'], 'safe'],
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
        $query = Article::find();

        // add conditions that should always apply here

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
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'category_id' => $this->category_id,
            'image_id' => $this->image_id,
            'active' => $this->active,
            'visible' => $this->visible,
            'hot' => $this->hot,
            'status' => $this->status,
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'publish_time' => $this->publish_time,
            'views' => $this->views,
            'likes' => $this->likes,
            'comments' => $this->comments,
            'shares' => $this->shares,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'sub_content', $this->sub_content]);

        return $dataProvider;
    }
}
