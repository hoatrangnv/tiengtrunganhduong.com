<?php
use yii\helpers\Url;
use common\models\UrlParam;
use frontend\models\Image;

/**
 * @var string $title
 * @var bool $hasMore
 * @var string $categorySlug
 * @var \frontend\models\Article[] $models
 *
 */

?>
<div class="news-list">
    <h2 class="title"><?= $title ?></h2>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $models,
            'imageSize' => $this->context->screen == 'small' ? Image::SIZE_3 : Image::SIZE_6,
        ]) ?>
    </div>
    <?php
    if ($hasMore) {
        echo '<button type="button" class="see-more" onclick="seeMore(this.previousElementSibling, this)">Xem thêm</button>';
    }
    ?>
</div>
<script>
    function seeMore(container, button) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                var data = JSON.parse(xhttp.responseText);
                container.innerHTML += data.content;
                if (!data.hasMore) {
                    button.parentNode.removeChild(button);
                }
//                setObjectOrientation();
//                ellipsisTexts();
//                formatNumbers();
            }
        };
        xhttp.open("POST", "<?= Url::to(['article/ajax-get-items'], true) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?= Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken
        . (isset($categorySlug) ? '&' . UrlParam::CATEGORY_SLUG . "=$categorySlug" : '') ?>");
    }
</script>