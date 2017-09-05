<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 8/19/2017
 * Time: 9:43 AM
 */

namespace common\models;

use Yii;
use yii\web\UrlManager;

class Quiz extends \common\modules\quiz\models\Quiz
{
//    public function getUrl($params = [], $schema = true)
//    {
//        // AMP URL
//        if (Yii::$app->params['amp']) {
//            $params[UrlParam::AMP] = 'amp';
//        }
//        /**
//         * @var $urlMng UrlManager
//         */
//        $urlMng = Yii::$app->frontendUrlManager;
//        return ($schema ? Yii::getAlias('@frontendUrl') : '') . $urlMng->createUrl(
//            array_merge(['quiz/play', UrlParam::SLUG => $this->slug], $params)
//        );
//    }
}