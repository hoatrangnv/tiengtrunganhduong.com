<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2017
 * Time: 12:38 AM
 */

namespace frontend\controllers;

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
                ->andWhere(['!=', 'id', $model->id])
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
            'categorySlug' => $category->slug,
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'hasMore' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionTag()
    {
        $alias = Yii::$app->request->get(UrlParam::ALIAS);
        return $this->render('tag', []);
    }

    public function actionAjaxGetItems()
    {
        $this->layout = false;
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $cat_slug = Yii::$app->request->getBodyParam(UrlParam::CATEGORY_SLUG);
        $category = ArticleCategory::findOneBySlug($cat_slug);
        $query = $category ? $category->getAllArticles() : Article::find();

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
     * @param Query $query
     * @return Article[]
     */
    public function findModels(Query $query)
    {
        $page = Yii::$app->session->get(self::SESSION_PAGE_KEY);
        return $query
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('publish_time desc')
            ->allPublished();
    }
}