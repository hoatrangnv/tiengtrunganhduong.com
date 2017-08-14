<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/9/2017
 * Time: 4:36 PM
 */
/**
 * @var string $imagesSize
 * @var \frontend\models\Quiz[] $models
 */

if (!isset($imagesSize)) {
    $imagesSize = null;
}

foreach ($models as $item) {
    echo $item->a('<div class="image">
        <div class="item-view">
            <div class="img-wrap">' .
                $item->img($imagesSize) .
            '</div>
        </div>
    </div>
    <div class="name">' .
        "<span>$item->name</span>" .
    '</div>
    <div class="info">' .
        $this->render('info', ['model' => $item]) .
    '</div>
    <div class="desc">' .
        $item->desc() .
    '</div>', ['class' => 'news-item clr']);
}