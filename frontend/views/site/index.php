<?php

/* @var $this yii\web\View */

$this->title = 'Web development tips & code snippets';
?>
<h1><?= $this->title ?></h1>

<div class="list-view">
    <ul>
        <?php
        foreach (\frontend\models\Article::find()->orderBy('publish_time desc')->allPublished() as $item) {
            ?>
            <li>
                <h3><?= $item->a() ?></h3>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
