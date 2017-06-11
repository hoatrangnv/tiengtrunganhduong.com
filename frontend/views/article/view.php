<?php
// For test extension
//require_once (Yii::getAlias('@common/runtime/tmp-extensions/yii2-query-template/QueryTemplate.php'));
use yii\helpers\Url;
use frontend\models\Article;
use frontend\models\Image;

/**
 * @var Article $model
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
    <div class="article-info">
        <?= $this->render('info', ['model' => $model]) ?>
        <?= $this->render('//layouts/fbLike') ?>
    </div>
    <div class="article-desc">
        <?= nl2br($model->description) ?>
    </div>
    <div class="article-content fit-content">
        <?php
        $model->templateToHtml(['content']);
        echo $model->content;
        ?>
    </div>
</article>
<article>
    <?= $this->render('//layouts/fbLike', ['size' => 'large']) ?>
    <?= $this->render('//layouts/fbComment') ?>
</article>
