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

foreach ($models as $quiz) {
    echo "<li>{$quiz->a(
                '<div class="image">' .
                    '<div class="item-view">' .
                        '<div class="img-wrap">' .
                            $quiz->img($imagesSize) .
                        '</div>' .
                    '</div>' .
                '</div>' .
                '<div class="name">' .
                    $quiz->name .
                '</div>'
            )}</li>";
}