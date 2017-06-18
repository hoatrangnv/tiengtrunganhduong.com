<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/16/2017
 * Time: 8:25 AM
 */

namespace frontend\controllers;


use common\models\UrlParam;
use frontend\models\Article;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SitemapController extends Controller
{
    const ITEMS_PER_PAGE = 50;

    public function actionIndex()
    {
        $lastmod = date('c', 360 * floor(time() / 360));

        $sitemaps = [];

        $sitemaps[] = [
            'loc' => Url::to(['sitemap/static'], true),
            'lastmod' => $lastmod
        ];

        // Get article sitemaps
        $articles_number = Article::find()->countPublished();
        $article_sitemaps_number = ceil($articles_number / self::ITEMS_PER_PAGE);
        for ($i = 0; $i < $article_sitemaps_number; $i++) {
            $sitemaps[] = [
                'loc' => Url::to(['sitemap/article', UrlParam::PAGE => $i + 1], true),
                'lastmod' => $lastmod
            ];
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;

        return $this->render('index', [
            'sitemaps' => $sitemaps
        ]);
    }

    public function actionStatic()
    {
        $lastmod = date('c', 360 * floor(time() / 360));

        $urls = [
            'homePage' => [
                'loc' => Url::home(true),
                'lastmod' => $lastmod,
                'priority' => '1.0'
            ]
        ];

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;

        return $this->render('static', [
            'urls' => $urls
        ]);
    }

    public function actionArticle()
    {
        $page = Yii::$app->request->get(UrlParam::PAGE);

        if (!is_numeric($page) || $page < 1) {
            throw new NotFoundHttpException();
        }

        $articles = Article::find()
            ->orderBy('publish_time desc')
            ->offset(($page - 1) * self::ITEMS_PER_PAGE)
            ->limit(self::ITEMS_PER_PAGE)
            ->allActive();

        if (empty($articles)) {
            throw new NotFoundHttpException();
        }

        $urls = [];

        foreach ($articles as $article) {
            $url = ['loc' => $article->getUrl()];
            $image = $article->getImage()->oneActive();
            if ($image) {
                $url['image'] = [
                    'loc' => $image->getSource(),
                    'title' => Html::encode($image->name),
                    'caption' => Html::encode($image->name)
                ];
            }
            $url['news'] = [
                'publication_date' => date('c', $article->publish_time),
                'title' => Html::encode($article->name),
                'keywords' => Html::encode($article->meta_keywords)
            ];
            $urls[] = $url;
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;

        return $this->render('article', [
            'urls' => $urls
        ]);
    }
}