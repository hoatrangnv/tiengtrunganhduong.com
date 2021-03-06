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
    public $publish_time__operator = '=';

    public $create_time__operator = '=';

    public $update_time__operator = '=';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'updater_id', 'image_id', 'category_id', 'active', 'visible', 'featured', 'shown_on_menu', 'type', 'status', 'sort_order', 'create_time', 'update_time', 'publish_time', 'view_count', 'like_count', 'comment_count', 'share_count', 'doindex', 'dofollow', 'disable_ads'], 'integer'],
            [['slug', 'name', 'meta_title', 'meta_description', 'meta_keywords', 'description', 'content', 'sub_content', 'menu_label'], 'safe'],
            [['publish_time__operator', 'create_time__operator', 'update_time__operator'], 'string'],
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
            'image_id' => $this->image_id,
//            'category_id' => $this->category_id,
            'active' => $this->active,
            'visible' => $this->visible,
            'featured' => $this->featured,
            'shown_on_menu' => $this->shown_on_menu,
            'type' => $this->type,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'view_count' => $this->view_count,
            'like_count' => $this->like_count,
            'comment_count' => $this->comment_count,
            'share_count' => $this->share_count,
            'disable_ads' => $this->disable_ads,
        ]);

        $query
            ->andFilterWhere([
                $this->create_time__operator,
                'create_time',
                '0' === $this->create_time ? time() : $this->create_time
            ])
            ->andFilterWhere([
                $this->update_time__operator,
                'update_time',
                '0' === $this->update_time ? time() : $this->update_time
            ])
            ->andFilterWhere([
                $this->publish_time__operator,
                'publish_time',
                '0' === $this->publish_time ? time() : $this->publish_time
            ]);

        $query
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'sub_content', $this->sub_content])
            ->andFilterWhere(['like', 'menu_label', $this->menu_label]);

        if ('0' === $this->category_id) {
            $query->andWhere(['category_id' => null]);
        } else {
            $query->andFilterWhere(['category_id' => $this->category_id]);
        }

        return $dataProvider;
    }
}
