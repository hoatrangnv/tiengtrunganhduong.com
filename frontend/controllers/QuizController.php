<?php

namespace frontend\controllers;

use common\models\ChineseSingleWord;
use common\models\NameTranslation;
use common\models\UrlParam;
use common\utils\FacebookDebugger;
use Facebook\Facebook;
use Faker\Guesser\Name;
use Yii;
use frontend\models\Quiz;
use frontend\models\UrlRedirection;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\db\MyActiveRecord;
use common\db\MyActiveQuery;
use yii\web\BadRequestHttpException;

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

    public function actionPlay()
    {
        $model = $this->findModel(Yii::$app->request->get(UrlParam::SLUG));
        $relatedItems = Quiz::find()
            ->andWhere(['<', 'publish_time', $model->publish_time])
            ->orderBy('publish_time desc')
            ->limit(12)
            ->allPublished();
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
            $this->seoInfo->image_src =
                strrpos($sharingImageSrc, 'http') === 0
                    ? $sharingImageSrc
                    : Yii::getAlias("@quizImagesUrl/$sharingImageSrc");
        }

        return $this->render('play', array_merge($model->getPlayData(), ['relatedItems' => $relatedItems]));
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionGetSharingData()
    {
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
        $image_name = uniqid(date('YmdHis_')) . '.png';
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
        $facebookDebugger = new FacebookDebugger();
        for ($i = 0; $i < 3; $i++) {
            $facebookDebugger->reload($url);
            sleep(0.5);
        }
//        $try_count = 0;
//        do {
//            $try_count++;
//            $debug_res = file_get_contents(
////                "https://graph.facebook.com/debug_token?input_token="
////                    . urlencode($url) . '&access_token='
////                    . Yii::$app->params['fb_app_id'] . '|' . Yii::$app->params['fb_app_secret'],
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
        return $query
            ->limit(static::ITEMS_PER_PAGE + 1)
            ->offset(($page - 1) * static::ITEMS_PER_PAGE)
            ->orderBy('publish_time desc')
            ->allPublished();
    }

    public function actionTestCallback()
    {
        echo '{"value":"hahaha"}';
    }

    public function actionTranslateName()
    {
        $name = Yii::$app->request->get('name');
        $words = preg_split( "/( |\+)/", $name);
        $response = [
            'data' => [
                'words' => [],
                'translated_words' => [],
                'spellings' => [],
                'meanings' => [],
            ],
            'error_message' => '',
        ];

//        foreach ($words as $i => $o_word) {
//            $word = strtolower(trim($o_word));
//            if ($word) {
//                $translations = NameTranslation::find()->where([
//                    'word' => $word,
//                    'type' => 0 == $i ? NameTranslation::TYPE_LAST_NAME : NameTranslation::TYPE_FIRST_NAME
//                ])->all();
//                $translation = null;
//                foreach ($translations as $record) {
//                    /**
//                     * @var $record NameTranslation
//                     */
//                    if (strtolower(trim($record->word)) == $word) {
//                        $translation = $record;
//                        break;
//                    }
//                }
////                if (!$translation && !empty($translations)) {
////                    $translation = $translations[0];
////                }
//                if ($translation) {
//                    $response['data']['name'] .= ' ' . trim($o_word);
//                    $response['data']['translated_name'] .= ' ' . $translation->translated_word;
//                    $response['data']['spelling'] .= ' ' . $translation->spelling;
//                } else {
//                    $response['data']['name'] .= ' ' . trim($o_word);
//                    $response['data']['translated_name'] .= ' _';
//                    $response['data']['spelling'] .= ' _';
//                }
//            }
//        }

        $first_name_words = [];
        $last_name_word = '';
        if (count($words) == 1) {
            $first_name_words = $words;
        } else if (count($words) == 2) {
            $first_name_words = [$words[1]];
            $last_name_word = $words[0];
        } else {
            $first_name_words = array_slice($words, 2);
            $last_name_word = $words[0] . ' ' . $words[1];
            $last_name_translations = NameTranslation::find()
                ->where(['LIKE', 'word', $last_name_word])
                ->andWhere(['type' => NameTranslation::TYPE_LAST_NAME])
                ->all();
            if (count($last_name_translations) == 0) {
                $first_name_words = array_slice($words, 1);
                $last_name_word = $words[0];
            }
        }

        $last_name_translation_all = NameTranslation::find()
            ->where(['LIKE', 'word', $last_name_word])
            ->andWhere(['type' => NameTranslation::TYPE_LAST_NAME])
            ->all();

        /**
         * @var $last_name_translation NameTranslation[]
         */
        $last_name_translation = [];
        foreach ($last_name_translation_all as $record) {
            /**
             * @var $record NameTranslation
             */
            if (mb_strtolower(trim($record->word)) == mb_strtolower($last_name_word)) {
                $last_name_translation[] = $record;
            }
        }
        if (count($last_name_translation) == 0) {
            // find in chinese single word table

        }

        $first_name_translations_all = NameTranslation::find()
            ->where(array_merge(
                ['OR'],
                array_map(function ($word) {
                    return ['LIKE', 'word', $word];
                }, $first_name_words)))
            ->andWhere(['type' => NameTranslation::TYPE_FIRST_NAME])
            ->all();

        /**
         * @var $first_name_translations NameTranslation[][]
         */
        $first_name_translations = [];
        foreach ($first_name_words as $word_index => $word) {
            $first_name_translations[$word_index] = [];
            foreach ($first_name_translations_all as $record) {
                /**
                 * @var $record NameTranslation
                 */
                if (mb_strtolower(trim($record->word)) == mb_strtolower($word)) {
                    $first_name_translations[$word_index][] = $record;
                }
            }
            if (count($first_name_translations[$word_index]) == 0) {
                // find in chinese single word table
            }
        }

        $findMeaning = function ($translation) {
            return array_map(function ($translation) {
                /**
                 * @var $translation NameTranslation
                 */
                $meaning = $translation->meaning;
                if ('' === trim($meaning)) {
                    /**
                     * @var $singleWords ChineseSingleWord[]
                     */
                    $singleWords = ChineseSingleWord::find()
                        ->where(['LIKE', 'word', $translation->translated_word])
                        ->all();

                    foreach ($singleWords as $singleWord) {
                        if (mb_strtolower($singleWord->word) === mb_strtolower($translation->translated_word)) {
                            $meaning .= str_replace(["\\n", "\\t"], ["\n", ""], $singleWord->meaning) . "\n";
                        }
                    }
                    $meaning = trim($meaning);
                }
                return $meaning;
            }, $translation);
        };

        if ('' !== $last_name_word) {
            $response['data']['words'][] = $last_name_word;
            $response['data']['translated_words'][] = array_map(function ($translation) {
                /**
                 * @var $translation NameTranslation
                 */
                return $translation->translated_word;
            }, $last_name_translation);
            $response['data']['spellings'][] = array_map(function ($translation) {
                /**
                 * @var $translation NameTranslation
                 */
                return $translation->spelling;
            }, $last_name_translation);
            $response['data']['meanings'][] = $findMeaning($last_name_translation);
        }

        foreach ($first_name_words as $index => $word) {
            $response['data']['words'][] = $word;
            $translation = $first_name_translations[$index];
            $response['data']['translated_words'][] = array_map(function ($translation) {
                /**
                 * @var $translation NameTranslation
                 */
                return $translation->translated_word;
            }, $translation);;
            $response['data']['spellings'][] = array_map(function ($translation) {
                /**
                 * @var $translation NameTranslation
                 */
                return $translation->spelling;
            }, $translation);
            $response['data']['meanings'][] = $findMeaning($translation);
        }

        echo json_encode($response);
        exit();
    }
}
