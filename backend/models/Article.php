<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/31/2017
 * Time: 12:30 AM
 */

namespace backend\models;

use yii\helpers\Url;

class Article extends \common\models\Article
{
    public function getUrl($options = [])
    {
        // TODO: Implement getUrl() method.
        if (isset($options['code_editor']) && $options['code_editor']) {
            return Url::to(['article/update', 'id' => $this->id, 'code_editor' => 1], true);
        }
        return Url::to(['article/update', 'id' => $this->id], true);
    }
}