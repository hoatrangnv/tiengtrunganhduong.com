<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/11/2017
 * Time: 11:46 PM
 */

use frontend\models\ArticleCategory;
use frontend\models\Article;
use frontend\models\Image;

$cat_ids = array_keys(ArticleCategory::indexData());

$articles_1 = Article::find()
    ->where(['in', 'category_id', $cat_ids])
    ->andWhere(['>=', 'publish_time', time() - 2 * 86400])
    ->orderBy('view_count desc')
    ->limit(3)
    ->indexBy('id')
    ->allPublished();
$not_ids = array_keys($articles_1);

$articles_2 = Article::find()
    ->where(['in', 'category_id', $cat_ids])
    ->andWhere(['not in', 'id', $not_ids])
    ->andWhere(['>=', 'publish_time', time() - 7 * 86400])
    ->orderBy('view_count desc')
    ->limit(6 - count($not_ids))
    ->indexBy('id')
    ->allPublished();
$not_ids = array_merge($not_ids, array_keys($articles_2));

$articles_3 = Article::find()
    ->where(['in', 'category_id', $cat_ids])
    ->andWhere(['not in', 'id', $not_ids])
    ->orderBy('publish_time desc')
    ->limit(9 - count($not_ids))
    ->indexBy('id')
    ->allPublished();
$not_ids = array_merge($not_ids, array_keys($articles_3));

$articles_4 = Article::find()
    ->where(['in', 'category_id', $cat_ids])
    ->andWhere(['not in', 'id', $not_ids])
    ->orderBy('rand()')
    ->limit(12 - count($not_ids))
    ->indexBy('id')
    ->allPublished();
?>
<div class="aside-box">
    <div class="content">
        <div class="grid-view g2 aspect-ratio __5x3">
            <ul>
                <?php
                /**
                 * @var Article $item
                 */
                foreach (array_merge($articles_1, $articles_2, $articles_3, $articles_4) as $item) {
                    ?><li>
                        <?= $item->a(
                            '<div class="image">' .
                                '<div class="item-view">' .
                                    '<div class="img-wrap">' .
                                        $item->img('135x81') .
                                    '</div>' .
                                '</div>' .
                            '</div>' .
                            '<h3 class="name">' .
                                "<span>$item->name</span>" .
                            '</h3>'
                        ) ?>
                    </li><?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>

