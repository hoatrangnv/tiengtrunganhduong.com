<?php

namespace frontend\controllers;

use common\db\MyActiveQuery;
use common\models\UrlParam;
use frontend\models\Quiz;
use frontend\models\UrlRedirection;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class QuizController extends BaseController
{
    const ITEMS_PER_PAGE = 18;
    const SESSION_PAGE_KEY = 'Quiz.page';

    /**
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->session->set(self::SESSION_PAGE_KEY, 1);
        $models = $this->findModels(Quiz::find());
        return $this->render('index', [
            'title' => Yii::t('app', 'Quizzes'),
            'models' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'hasMore' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    /**
     * @return string
     */
    public function actionMe()
    {
        if (Yii::$app->user->isGuest) {
            echo Yii::t('app', 'Please login to see your quizzes');
            exit();
        }
        Yii::$app->session->set(self::SESSION_PAGE_KEY, 1);
        $models = $this->findModels(Quiz::find()->where(['creator_id' => Yii::$app->user->id]));
        return $this->render('index', [
            'title' => Yii::t('app', 'Your Quizzes'),
            'quizzes' => array_slice($models, 0, self::ITEMS_PER_PAGE),
            'hasMore' => isset($models[static::ITEMS_PER_PAGE])
        ]);
    }

    public function actionPlay()
    {
        $model = $this->findModel(Yii::$app->request->get(UrlParam::SLUG));
        $relatedItems = Quiz::find()
            ->andWhere(['<', 'publish_time', $model->publish_time])
            ->orderBy('publish_time desc')
            ->limit(12)
            ->allPublished();
        $relatedItems = Quiz::find()->where(['<>', 'id', $model->id])->limit(8)
            ->orderBy('publish_time desc')
            ->allPublished();
        shuffle($relatedItems);
        $relatedItems = array_slice($relatedItems, 0, 4);
        //TODO: Check whether Requested Url is same as Model Url or not.
        //TODO: If not, redirect to Model Url.
        $this->cmpUrls8RedirectIfNot($model->getUrl([], true));
        $this->seoInfo->parseValues($model->attributes);

        //TODO: Sharing data
        $sharingTitle = Yii::$app->request->get(UrlParam::SHARING_TITLE);
        $sharingDescription = Yii::$app->request->get(UrlParam::SHARING_DESCRIPTION);
        $sharingImageSrc = Yii::$app->request->get(UrlParam::SHARING_IMAGE_SRC);
        if ($sharingTitle) {
            $this->seoInfo->meta_title = $sharingTitle;
        }
        if ($sharingDescription) {
            $this->seoInfo->meta_description = $sharingDescription;
        }
        if ($sharingImageSrc) {
            $this->seoInfo->customImage['source'] = substr($sharingImageSrc, 0, 10) == 'data:image' ? $sharingImageSrc : Yii::getAlias("@quizImagesUrl/$sharingImageSrc");
            if ($image_size = @getimagesize(Yii::getAlias("@quizImages/$sharingImageSrc"))) {
                list ($image_width, $image_height) = $image_size;
                $this->seoInfo->customImage['width'] = $image_width;
                $this->seoInfo->customImage['height'] = $image_height;
            }
        }

        return $this->render('play', ['quiz' => $model, 'relatedItems' => $relatedItems]);
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionGetSharingData()
    {
        $this->enableCsrfValidation = false;
//        $contextOptions = [
//            'ssl' => [
//                'verify_peer' => false,
//                'verify_peer_name' => false,
//            ],
//        ];

        if (!Yii::$app->request->isPost
            || !($slug = rawurldecode(Yii::$app->request->post('slug')))
            || !($image = rawurldecode(Yii::$app->request->post('image')))
        ) {
            throw new BadRequestHttpException();
        }
        $title = rawurldecode(Yii::$app->request->post('title', ''));
        $description = rawurldecode(Yii::$app->request->post('description', ''));

//        list($type, $data) = explode(';', $image);
//        list(, $data)      = explode(',', $data);
//        $data = base64_decode($data);
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
        $image_name = uniqid(date('YmdHis_')) . '.jpg';
        $path = date('Y/m/d/');
        $dir = Yii::getAlias("@quizImages/$path");
        if (!file_exists($dir)) {
            FileHelper::createDirectory($dir);
        }
        $image_src = "$path$image_name";
        $url = Url::to(['play',
            UrlParam::SLUG => $slug,
            UrlParam::SHARING_TITLE => $title,
            UrlParam::SHARING_DESCRIPTION => $description,
            UrlParam::SHARING_IMAGE_SRC => $image_src,
        ], true);
        file_put_contents("$dir$image_name", $data);
//        $facebookDebugger = new FacebookDebugger();
//        for ($i = 0; $i < 3; $i++) {
//            $facebookDebugger->reload($url);
//            sleep(0.5);
//        }
//        $try_count = 0;
//        do {
//            $try_count++;
//            $debug_res = file_get_contents(
////                "https://graph.facebook.com/debug_token?input_token="
////                    . urlencode($url) . '&access_token='
////                    . Yii::$app->params['facebook.appID'] . '|' . Yii::$app->params['fb_app_secret'],
//                'https://graph.facebook.com/?id=' . urlencode($url) . '&scrape=true',
//                false,
//                stream_context_create($contextOptions)
//            );
//            sleep(0.5);
//        } while (!$debug_res || $try_count < 10);
        return json_encode([
            'errorMsg' => '',
            'data' => [
                'url' => $url,
                'title' => $title,
                'description' => $description,
                'image_url' => Yii::getAlias("@quizImagesUrl/$image_src"),
            ]
        ]);
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionAjaxGetItems()
    {
        if (!Yii::$app->request->isPost) {
            return '';
        }
        $this->layout = false;
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $action_id = Yii::$app->request->getBodyParam(UrlParam::ACTION_ID);
        switch ($action_id) {
            case 'index':
                $query = Quiz::find();
                break;
            case 'me':
                if (!Yii::$app->user->isGuest) {
                    $query = Quiz::find()->where(['creator_id' => Yii::$app->user->id]);
                } else {
                    throw new BadRequestHttpException();
                }
                break;
            default:
                throw new BadRequestHttpException();
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

    public function actionAjaxUpdateCounter()
    {
        if (!Yii::$app->request->isPost) {
            return '';
        }
        $field = Yii::$app->request->getBodyParam(UrlParam::FIELD);
        $value = (int) Yii::$app->request->getBodyParam(UrlParam::VALUE, 1);
        $slug = Yii::$app->request->getBodyParam(UrlParam::SLUG);
        if (!in_array($field, ['view_count', 'comment_count', 'like_count', 'share_count'])) {
            throw new BadRequestHttpException();
        }
        $table = Quiz::tableName();
        $query = Yii::$app->db
            ->createCommand("UPDATE `$table` SET `$field` = (IFNULL(`$field`, 0) + :value) WHERE `slug` = :slug")
            ->bindValues([':value' => $value, ':slug' => $slug])
            ->execute();
        return !!$query;
    }

    public function cmpUrls8RedirectIfNot($mod_url)
    {
        // @TODO: Check whether Requested Url is same as Model Url or not.
        $req_url = Yii::$app->request->absoluteUrl;
        $parsed_url = parse_url($req_url);
        $req_path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $req_query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $req_fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
        $parsed_url = parse_url($mod_url);
        $mod_path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        if ($req_path !== $mod_path) {

            // @TODO: If not, redirect to Model Url.
            $to_url = "$mod_url$req_query$req_fragment";
            header("Location: $to_url", true, 301);
            exit();
        }
    }

    /**
     * @param $slug
     * @return Quiz
     * @throws NotFoundHttpException
     */
    public function findModel($slug)
    {
        if (!$model = Quiz::find()->where(['slug' => $slug])->oneActive()) {
            UrlRedirection::findOneAndRedirect();
        }
        if (!$model) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    /**
     * @param MyActiveQuery $query
     * @return Quiz[]
     */
    public function findModels(MyActiveQuery $query)
    {
        $page = Yii::$app->session->get(self::SESSION_PAGE_KEY);
        $query
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('publish_time desc');
        if (Yii::$app->user->isGuest) {
            return $query->allPublished();
        } else {
            $wrong_number = $query->publishTimeWrongNumber;
            $time = (int) round(time() / $wrong_number) * $wrong_number;
            return $query->andWhere([
                'OR',
                ['creator_id' => Yii::$app->user->id],
                [
                    'AND',
                    ['=', 'active', 1],
                    ['=', 'visible', 1],
                    ['<=', $query->publishTimeAttribute, $time],
                ],
            ])->all();
        }
    }

    public function actionTestCallback()
    {
        echo '{"value":"hahaha"}';
    }
}
