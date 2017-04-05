<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<h1>New Articles</h1>

<section>
    <?php
    foreach (\frontend\models\Article::find()->orderBy('publish_time desc')->allPublished() as $item) {
        ?>
        <?= $item->a("<h3>$item->name</h3><div>$item->description</div>") ?>
        <?php
    }
    ?>
</section>
