<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SeoInfo;

/**
 * SeoInfoSearch represents the model behind the search form about `backend\models\SeoInfo`.
 */
class SeoInfoSearch extends SeoInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator_id', 'updater_id', 'image_id', 'active', 'type', 'status', 'sort_order', 'create_time', 'update_time', 'doindex', 'dofollow'], 'integer'],
            [['url', 'route', 'name', 'meta_title', 'meta_keywords', 'meta_description', 'description', 'long_description', 'content'], 'safe'],
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
        $query = SeoInfo::find();

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
            'active' => $this->active,
            'type' => $this->type,
            'status' => $this->status,
            'sort_order' => $this->sort_order,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'route', $this->route])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'long_description', $this->long_description])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
