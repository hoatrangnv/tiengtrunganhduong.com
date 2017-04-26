<?php
use yii\helpers\Url;
use frontend\models\Article;

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
    <div class="article-desc">
        <?= nl2br($model->description) ?>
    </div>
    <div class="article-content">
        <?php
        $content = $model->getContentWithTemplates();
        $pattern = "/<code>([\w\W]*?)<\/code>/i";
        preg_match_all($pattern, $content, $matches);
        foreach ($matches[1] as $match) {
            $content = str_replace($match, htmlentities($match), $content);
        }
        echo $content;
        ?>
    </div>
</article>
<article class="clearfix">
    <?php
    if ($prev)
        echo "<p class=\"pull-left\"><strong>Previous:</strong> {$prev->a(null, ['class' => 'link'])}</p>";
    ?>
    <?php
    if ($next)
        echo "<p class=\"pull-right\"><strong>Next:</strong> {$next->a(null, ['class' => 'link'])}</p>";
    ?>
</article>
<article>
    <?= $this->render('//layouts/disqus.php') ?>
</article>