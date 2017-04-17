<?php

use frontend\models\Article;

/* @var $this yii\web\View */

$this->title = 'Web development tips & code snippets';
?>
<h1><?= $this->title ?></h1>
<section class="list-view">
    <ul>
        <?php
        foreach (Article::find()->orderBy('publish_time desc')->allPublished() as $item) {
            ?>
            <li>
                <?= $item->a([], ['class' => 'link']) ?>
            </li>
            <?php
        }
        ?>
    </ul>
</section>
