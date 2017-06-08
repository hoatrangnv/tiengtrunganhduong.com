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

<?php
foreach (\frontend\models\ArticleCategory::find()->where(['parent_id' => null])
             ->orderBy('sort_order asc')->allActive() as $category) {
?>
<div class="news-block__small aspect-ratio __5x3">
    <h3 class="title"><?= $category->name ?></h3>
    <?php
    foreach ($category->getAllArticles()->orderBy('publish_time desc')->limit(3)->allPublished() as $k => $item) {
        if ($k == 0) {
            ?>
            <div class="item-view">
                <div class="img-wrap">
                    <?= $item->img() ?>
                </div>
            </div>
            <?php
        }
        echo $item->a();
    }
    ?>
</div>
<?php
}
?>