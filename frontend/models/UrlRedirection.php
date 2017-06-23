<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/17/2017
 * Time: 7:06 PM
 */

namespace frontend\models;

use Yii;
use yii\web\NotFoundHttpException;

class UrlRedirection extends \common\models\UrlRedirection
{
    public static function findOneAndRedirect($from_url = null)
    {
        if (!$from_url) {
            $from_url = Yii::$app->request->url;
        }

        $to_url = null;
        $response_code = 301;

        /** @var self $model */
        $model = self::find()
            ->where([
                'OR',
                [
                    'AND',
                    ['=', 'type', self::TYPE_EQUALS],
                    ":from_url LIKE `from_url`",
                ],
                [
                    'AND',
                    ['=', 'type', self::TYPE_CONTAINS],
                    ":from_url LIKE CONCAT('%', `from_url`, '%')",
                ],
                [
                    'AND',
                    ['=', 'type', self::TYPE_STARTS_WITH],
                    ":from_url LIKE CONCAT(`from_url`, '%')",
                ],
                [
                    'AND',
                    ['=', 'type', self::TYPE_ENDS_WITH],
                    ":from_url LIKE CONCAT('%', `from_url`)",
                ],
            ])
            ->addParams([':from_url' => $from_url])
            ->orderBy('sort_order ASC, id ASC')
            ->oneActive();

        if ($model) {
            $to_url = $model->to_url;
            if (in_array($model->response_code, array_keys(self::getResponseCodes()))) {
                $response_code = $model->response_code;
            }
        } else {
            /** @var self[] $models */
            $models = self::find()
                ->where(['type' => self::TYPE_REGEXP])
                ->orderBy('sort_order ASC, id ASC')
                ->allActive();

            foreach ($models as $model) {
                try {
                    preg_match($model->from_url, $from_url, $matches);
                    if (isset($matches[0])) {
                        $pattern = $model->from_url;
                        $replacement = $model->to_url;
                        $transform = null;
                        switch (true) {
                            case '~\lowercase' === substr($replacement, -11):
                                $replacement = substr($replacement, 0, -11);
                                $transform = 'lowercase';
                                break;
                            case '~\uppercase' === substr($replacement, -11):
                                $replacement = substr($replacement, 0, -11);
                                $transform = 'uppercase';
                                break;
                            default:
                        }

                        $to_url = preg_replace($pattern, $replacement, $from_url);

                        switch ($transform) {
                            case 'lowercase':
                                $to_url = strtolower($to_url);
                                break;
                            case 'uppercase':
                                $to_url = strtoupper($to_url);
                                break;
                            default:

                        }

                        if (in_array($model->response_code, array_keys(self::getResponseCodes()))) {
                            $response_code = $model->response_code;
                        }

                        break;
                    }
                } catch (\Exception $e) {
                    continue;
                }
                if ($to_url) {
                    break;
                }
            }
        }

        if ($to_url) {
            header("Location: $to_url", true, $response_code);
            exit();
        }
        throw new NotFoundHttpException();
    }

}