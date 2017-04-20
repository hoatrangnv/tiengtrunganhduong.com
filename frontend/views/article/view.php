<?php
use yii\helpers\Url;

$this->title = $model->name;
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_description
]);
$this->registerLinkTag([
    'rel' => 'canonical',
    'href' => $model->getUrl()
]);
$this->params['breadcrumbs'][] = $this->title;
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
<article>
    <p>
        <strong>Related Articles</strong>
    </p>
    <?php
    foreach (\frontend\models\Article::find()->orderBy('rand()')->limit(5)->all() as $item) {
        echo "<p>{$item->a([], ['class' => 'link'])}</p>";
    }
    ?>
</article>