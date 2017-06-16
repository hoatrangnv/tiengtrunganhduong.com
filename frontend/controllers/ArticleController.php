<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2017
 * Time: 12:38 AM
 */

namespace frontend\controllers;

use common\models\MyActiveQuery;
use common\models\UrlParam;
use frontend\models\ArticleCategory;
use Yii;
use frontend\models\Article;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;

class ArticleController extends BaseController
{
    const ITEMS_PER_PAGE = 20;
    const SESSION_PAGE_KEY = 'Article.page';

    public function actionView()
    {
        $model = $this->findModel(Yii::$app->request->get(UrlParam::SLUG));
        if ($category = $model->category) {
            $relatedItems = $category
                ->getArticles()
                ->andWhere(['<', 'publish_time', $model->publish_time])
                ->orderBy('publish_time desc')
                ->limit(12)
                ->allPublished();
        } else {
            $relatedItems = [];
        }
        return $this->render('view', [
            'model' => $model,
            'relatedItems' => $relatedItems
        ]);
    }

    public function actionCategory()
    {
        $slug = Yii::$app->request->get(UrlParam::SLUG);
        $category = $this->findCategory($slug);
        Yii::$app->session->set(self::SESSION_PAGE_KEY, 1);
        $models = $this->findModels($category->getAllArticles());
        return $this->render('index', [
            'title' => $category->name,
            'slug' => $category->slug,
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'hasMore' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionSearch()
    {
        $alias = Yii::$app->request->get(UrlParam::ALIAS);
        $_keyword = Yii::$app->request->get(UrlParam::KEYWORD);
        if (!$alias || !$_keyword) {
            throw new NotFoundHttpException();
        }
        $keyword = str_replace('-', ' ', $_keyword);
        Yii::$app->session->set(self::SESSION_PAGE_KEY, 1);
        $query = $this->searchByKeyword($keyword);
        $models = $this->findModels($query);
        return $this->render('search', [
            'title' => strtoupper($alias) . ': ' . $keyword,
            'keyword' => $keyword,
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'hasMore' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionAjaxGetItems()
    {
        $this->layout = false;
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $action = Yii::$app->request->getBodyParam(UrlParam::ALIAS);
        switch ($action) {
            case 'category':
                $slug = Yii::$app->request->getBodyParam(UrlParam::SLUG);
                if (!$slug) {
                    throw new NotFoundHttpException();
                }
                $category = ArticleCategory::findOneBySlug($slug);
                $query = $category
                    ? $category->getAllArticles()
                    : Article::find()->where('0=1');
                break;
            case 'search':
                $keyword = Yii::$app->request->getBodyParam(UrlParam::KEYWORD);
                $query = $this->searchByKeyword($keyword);
                break;
            default:
                $query = Article::find();
        }

        $page = Yii::$app->session->get(self::SESSION_PAGE_KEY);
        Yii::$app->session->set(self::SESSION_PAGE_KEY, $page + 1);
        $models = $this->findModels($query);
        return json_encode([
            'content' => $this->render('items', [
                'models' => array_slice($models, 0, self::ITEMS_PER_PAGE)
            ]),
            'hasMore' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    /**
     * @param $slug
     * @return Article | null
     * @throws NotFoundHttpException
     */
    public function findModel($slug)
    {
        if (!$model = Article::findOneBySlug($slug)) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    /**
     * @param $slug
     * @return ArticleCategory | null
     * @throws NotFoundHttpException
     */
    public function findCategory($slug)
    {
        if (!$category = ArticleCategory::findOneBySlug($slug)) {
            throw new NotFoundHttpException();
        }
        return $category;
    }

    /**
     * @param MyActiveQuery $query
     * @return Article[]
     */
    public function findModels(MyActiveQuery $query)
    {
        $page = Yii::$app->session->get(self::SESSION_PAGE_KEY);
        return $query
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('publish_time desc')
            ->allPublished();
    }

    /**
     * @param $keyword
     * @return MyActiveQuery
     */
    public function searchByKeyword($keyword)
    {
        $pattern = str_replace(
            [
                'a',
                'd',
                'e',
                'i',
                'o',
                'u',
                'y',
            ],
            [
                '(a|á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ)',
                '(d|đ)',
                '(e|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ)',
                '(i|í|ì|ỉ|ĩ|ị)',
                '(o|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ)',
                '(u|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự)',
                '(y|ý|ỳ|ỷ|ỹ|ỵ)',
            ],
            strtolower($keyword)
        );
        return Article::find()->where(['REGEXP', 'CAST(`name` AS BINARY)', $pattern]);
    }
}