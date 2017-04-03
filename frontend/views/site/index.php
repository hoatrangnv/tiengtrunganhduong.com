<?php

/* @var $this yii\web\View */

$this->title = 'Web development';
?>
<div class="site-index">
    <ul>
        <?php
        foreach (\frontend\models\Article::find()->orderBy('publish_time desc')->allPublished() as $item) {
            echo "<li>{$item->a()}</li>";
        }
        ?>
    </ul>
</div>
