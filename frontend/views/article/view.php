<?php
// For test extension
//require_once (Yii::getAlias('@common/runtime/tmp-extensions/yii2-query-template/QueryTemplate.php'));
use yii\helpers\Url;
use frontend\models\Article;
use frontend\models\Image;

/**
 * @var Article $model
 * @var Article[] $relatedItems
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_description
]);
$this->registerLinkTag([
    'rel' => 'canonical',
    'href' => $model->getUrl()
]);
$prev = Article::find()
    ->where(['<', 'publish_time', $model->publish_time])
    ->orderBy('publish_time desc')
    ->limit(1)->onePublished();
$next = Article::find()
    ->where(['>', 'publish_time', $model->publish_time])
    ->orderBy('publish_time asc')
    ->limit(1)->onePublished();

if ($prev) {
    $this->registerLinkTag([
        'rel' => 'prev',
        'href' => $prev->getUrl()
    ]);
}
if ($next) {
    $this->registerLinkTag([
        'rel' => 'next',
        'href' => $next->getUrl()
    ]);
}
?>

<h1><?= $model->name ?></h1>
<article>
    <div class="news-info">
        <?= $this->render('info', ['model' => $model]) ?>
        <?= $this->render('//layouts/fbLike') ?>
    </div>
    <div class="news-desc">
        <?= nl2br($model->description) ?>
    </div>
    <div class="news-content fit-content content-popup-images">
        <?php
        $model->templateToHtml(['content']);
        echo $model->content;
        ?>
    </div>
</article>
<article>
    <?= $this->render('//layouts/fbLike') ?>
    <?= $this->render('//layouts/fbComment') ?>
</article>
<article class="related-news aspect-ratio __5x3">
    <?= $this->render('items', [
        'models' => $relatedItems,
        'imagesSize' => Image::SIZE_3
    ]) ?>
</article>
