<?php

use frontend\models\Article;
use yii\helpers\Url;
use frontend\models\ArticleCategory;

/**
/* @var $this yii\web\View
 * @var $category ArticleCategory
 * @var $article Article
 */
$i = 0;
foreach (array_filter(ArticleCategory::indexData(true), function ($category) {
    return !$category->parent_id && 1 == $category->featured;
}) as $category) {
    $i++;
?>
<div class="news-block aspect-ratio __5x3">
    <h3 class="title"><?= $category->a() ?></h3>
    <div class="content">
        <?php
        $j = 0;
        foreach ($category->getAllArticles()->orderBy('publish_time desc')
                     ->limit($this->context->screen == 'small' ? 5 : ($i % 3 == 0 ? 6 : 3))
                     ->allPublished() as $article) {
            $j++;
            echo $article->a('<div class="image">
                    <div class="item-view">
                        <div class="img-wrap">' .
                            $article->img(1 == $j ? '320x200' : '50x30') .
                        '</div>
                    </div>
                </div>
                <div class="name">' .
                    " <span>$article->name</span>" .
                '</div>
                <div class="desc">' .
                    $article->desc() .
                '</div>', ['class' => 'item clr']);
        }
        ?>
    </div>
</div>
<?php
}
?>