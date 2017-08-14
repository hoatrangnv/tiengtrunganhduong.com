<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/14/2017
 * Time: 11:56 PM
 */

namespace frontend\models;

use yii\helpers\Url;
use common\models\UrlParam;

class Quiz extends \common\modules\quiz\models\Quiz
{
    public function getUrl($params = [], $schema = true)
    {
        return Url::to(array_merge(['my-quiz/play', UrlParam::SLUG => $this->slug], $params), $schema);
    }

    public function desc()
    {
        return $this->description;
    }

    public function date()
    {
        return date('d/m/Y H:i', (int) $this->publish_time);
    }

    public function views()
    {
        return $this->view_count ? $this->view_count : 0;
    }

    public function comments()
    {
        return $this->comment_count ? $this->comment_count : 0;
    }
}