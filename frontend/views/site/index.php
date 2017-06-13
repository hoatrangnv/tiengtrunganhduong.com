<?php

use frontend\models\Article;
use yii\helpers\Url;
use frontend\models\ArticleCategory;

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
$i = 0;
foreach (array_filter(ArticleCategory::indexData(), function ($category) {
    return !$category->parent_id;
}) as $category) {
    $i++;
?>
<div class="news-block aspect-ratio __5x3">
    <h3 class="title"><?= $category->a() ?></h3>
    <div class="content">
        <?php
        foreach ($category->getAllArticles()->orderBy('publish_time desc')
                     ->limit($this->context->screen == 'small' ? 5 : ($i % 3 == 0 ? 6 : 3))
                     ->allPublished() as $j => $item) {
            ?>
            <div class="item clr">
                <div class="image">
                    <div class="item-view">
                        <div class="img-wrap">
                            <?= $item->img() ?>
                        </div>
                    </div>
                </div>
                <div class="name">
                    <?= $item->a() ?>
                </div>
                <div class="desc">
                    <?= $item->desc() ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
}
?>