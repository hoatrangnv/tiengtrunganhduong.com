<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/26/2017
 * Time: 2:14 AM
 */

namespace frontend\controllers;


use frontend\models\Article;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionSearchArticles($q, $page = 1)
    {
        /**
         * @var Article[] $articles
         */

        $articles = Article::find()
            ->where(['like', 'name', $q])
            ->offset($page - 1)
            ->limit(30)
            ->orderBy('create_time desc')
            ->allActive();

        $result = [
            'items' => [],
            'total_count' => Article::find()
                ->where(['like', 'name', $q])
                ->countActive()
        ];

        foreach ($articles as $article) {
            $result['items'][] = [
                'id' => $article->getUrl(),
                'name' => $article->name,
            ];
        }

        return json_encode($result);
    }
}
