<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/16/2017
 * Time: 1:18 AM
 */

namespace frontend\controllers;

use common\models\UrlParam;
use frontend\models\Article;
use frontend\models\ArticleCategory;
use frontend\models\UrlRedirection;
use Yii;
use frontend\models\Crawler;
use yii\web\NotFoundHttpException;

class CrawlerController extends BaseController
{
    public function actionView()
    {
        /**
         * @var Crawler $crawler
         */
//        try {
//            return UrlRedirection::findOneAndRedirect();
//        } catch (\Exception $e) {
//
//        }
        $alias = Yii::$app->request->get(UrlParam::ALIAS);
        $crawler = Crawler::find()->where(['url' => 'http://tiengtrunganhduong.com/' . $alias])->one();
        if ($crawler) {
            if ($crawler->target_model_type == Crawler::TARGET_MODEL_TYPE__ARTICLE && $crawler->target_model_slug) {
                if ($article = Article::findOneBySlug($crawler->target_model_slug)) {
                    return $this->redirect($article->getUrl(), 301);
                }
            } else if ($crawler->target_model_type == Crawler::TARGET_MODEL_TYPE__ARTICLE_CATEGORY && $crawler->target_model_slug) {
                if ($article_category = ArticleCategory::findOneBySlug($crawler->target_model_slug)) {
                    return $this->redirect($article_category->getUrl(), 301);
                }
            }
            return $crawler->content;
        }
        throw new NotFoundHttpException();
    }
}