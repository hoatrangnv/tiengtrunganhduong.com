<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/5/2017
 * Time: 12:38 AM
 */

namespace frontend\controllers;

use common\models\UrlParam;
use Yii;
use frontend\models\Article;
use yii\web\NotFoundHttpException;

class ArticleController extends BaseController
{
    public function actionView()
    {
        $model = $this->findModel(Yii::$app->request->get(UrlParam::SLUG));
        return $this->render('view', ['model' => $model]);
    }

    public function findModel($slug)
    {
        if (!$model = Article::find()->where(['slug' => $slug])->oneActive()) {
            throw new NotFoundHttpException();
        }
        return $model;
    }
}