<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<h2>New Articles</h2>

<div class="list-view">
    <ul>
        <?php
        foreach (\frontend\models\Article::find()->orderBy('publish_time desc')->allPublished() as $item) {
            ?>
            <li>
                <h3><?= $item->a() ?></h3>
                <p><?= $item->description ?></p>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
