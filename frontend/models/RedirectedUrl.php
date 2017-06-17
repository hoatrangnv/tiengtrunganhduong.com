<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/17/2017
 * Time: 7:06 PM
 */

namespace frontend\models;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class RedirectedUrl extends \common\models\RedirectedUrl
{
    public static function findOneAndRedirect($from_url = null)
    {
        if (!$from_url) {
            $from_url = Url::current();
        }
        $from_url_json = json_encode($from_url);
        $to_url = null;
        /** @var self $model */
        $model = self::find()
            ->where(['LIKE', 'from_urls', $from_url_json])
            ->orderBy('sort_order ASC')
            ->oneActive();
        if ($model) {
            $to_url = $model->to_url;
        }
        if (!$to_url) {
            /** @var self[] $models */
            $models = self::find()
                ->orderBy('sort_order ASC')
                ->limit(100)
                ->allActive();
            foreach ($models as $item) {
                $patterns = json_decode($item->from_urls);
                foreach ($patterns as $pattern) {
                    try {
                        preg_match($pattern, $from_url, $matches);
                        if (isset($matches[0])) {
                            $to_url = preg_replace($pattern, $item->to_url, $from_url);
                            break;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                if ($to_url) {
                    break;
                }
            }
        }
        if ($to_url) {
            return Yii::$app->response->redirect($to_url, 301);
        } else {
            throw new NotFoundHttpException();
        }
    }

}