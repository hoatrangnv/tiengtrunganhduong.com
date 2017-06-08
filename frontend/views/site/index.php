<?php

use frontend\models\Article;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Web development tips & code snippets';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Web development tips & code snippets with HTML, CSS, JavaScript, PHP.'
]);
$this->registerLinkTag([
    'rel' => 'canonical',
    'href' => Url::home(true)
]);
?>
