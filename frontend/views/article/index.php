<?php
use yii\helpers\Url;
use common\models\UrlParam;
use frontend\models\Image;

/**
 * @var string $title
 * @var bool $hasMore
 * @var string $slug
 * @var string $keyword
 * @var \frontend\models\Article[] $models
 *
 */
$action_id = Yii::$app->controller->action->id;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-list">
    <h1 class="title"><?= $title ?></h1>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $models,
            'imagesSize' => $this->context->screen == 'small' ? '100x60' : '200x120',
        ]) ?>
    </div>
    <?php
    if ($hasMore) {
        echo '<button type="button" class="see-more"'
                . ' onclick="seeMore(this.previousElementSibling, this)">Xem thêm</button>';
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
                setObjectOrientations();
                ellipsisTexts();
//                formatNumbers();
            }
        };
        xhttp.open("POST", "<?= Url::to(['article/ajax-get-items'], true) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            (Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken)
            . ('&' . UrlParam::ACTION_ID . '=' . $action_id)
            . (
                $action_id == 'category'
                ? ('&' . UrlParam::SLUG . "=$slug")
                : (
                    $action_id == 'search' || $action_id == 'tags'
                    ? ('&' . UrlParam::KEYWORD . "=$keyword")
                    : ''
                )
            )
            ?>");
    }
</script>