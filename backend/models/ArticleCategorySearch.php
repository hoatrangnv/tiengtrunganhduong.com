<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ArticleCategory;

/**
 * ArticleCategorySearch represents the model behind the search form about `backend\models\ArticleCategory`.
 */
class ArticleCategorySearch extends ArticleCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'updater_id', 'image_id', 'parent_id', 'active', 'visible', 'featured', 'shown_on_menu', 'type', 'status', 'sort_order', 'create_time', 'update_time', 'doindex', 'dofollow', 'disable_ads'], 'integer'],
            [['slug', 'name', 'meta_title', 'meta_description', 'meta_keywords', 'description', 'long_description', 'menu_label'], 'safe'],
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
        $query = ArticleCategory::find();

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
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'image_id' => $this->image_id,
//            'parent_id' => $this->parent_id,
            'active' => $this->active,
            'visible' => $this->visible,
            'featured' => $this->featured,
            'shown_on_menu' => $this->shown_on_menu,
            'type' => $this->type,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'disable_ads' => $this->disable_ads,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'long_description', $this->long_description])
            ->andFilterWhere(['like', 'menu_label', $this->menu_label]);

        if ('0' === $this->parent_id) {
            $query->andWhere(['parent_id' => null]);
        } else {
            $query->andFilterWhere(['parent_id' => $this->parent_id]);
        }

        return $dataProvider;
    }
}
