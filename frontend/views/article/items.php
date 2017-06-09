<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/9/2017
 * Time: 4:36 PM
 */
/**
 * @var string $imageSize
 * @var \frontend\models\Article[] $models
 */

if (!isset($imageSize)) {
    $imageSize = null;
}

foreach ($models as $item) {
?>
<div class="news-item clr">
    <div class="image">
        <div class="item-view">
            <div class="img-wrap">
                <?= $item->img($imageSize) ?>
            </div>
        </div>
    </div>
    <div class="name">
        <?= $item->a() ?>
    </div>
    <div class="info">
        <?= $this->render('info', ['model' => $item]) ?>
    </div>
    <div class="desc">
        <?= $item->desc() ?>
    </div>
</div>
<?php
}