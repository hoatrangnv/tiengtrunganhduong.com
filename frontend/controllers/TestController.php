<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2017
 * Time: 2:14 AM
 */

namespace frontend\controllers;


use common\models\MyActiveQuery;
use frontend\models\Article;
use frontend\models\ArticleCategory;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionSearchModels($q, $page = 1, $type = null)
    {
        /**
         * @var MyActiveQuery $query
         * @var Article[]|ArticleCategory[] $models
         */

        switch ($type) {
            case 'ArticleCategory':
                $query = ArticleCategory::find();
                break;
            case 'Article':
            default:
                $query = Article::find();
                break;
        }

        $models = $query
            ->where(['like', 'name', $q])
            ->offset($page - 1)
            ->limit(30)
            ->orderBy('create_time desc')
            ->allActive();

        $result = [
            'items' => [],
            'total_count' => $query
                ->where(['like', 'name', $q])
                ->countActive()
        ];

        foreach ($models as $model) {
            $result['items'][] = [
                'id' => $model->id,
                'name' => $model->name,
                'url' => $model->getUrl(),
                'image_src' => $model->image ? $model->image->getImgSrc('50x50') : ''
            ];
        }

        return json_encode($result);
    }
}
