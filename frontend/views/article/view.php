<?php
// For test extension
//require_once (Yii::getAlias('@common/runtime/tmp-extensions/yii2-query-template/QueryTemplate.php'));
use yii\helpers\Url;
use frontend\models\Article;
use frontend\models\Image;
use common\models\UrlParam;

/**
 * @var Article $model
 * @var Article[] $relatedItems
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="news-title"><?= $model->name ?></h1>
<article>
    <div class="news-info">
        <?= $this->render('info', ['model' => $model]) ?>
        <?= $this->render('//layouts/likeShare') ?>
    </div>
    <div class="news-desc">
        <?= nl2br($model->description) ?>
    </div>
    <div class="news-content fit-content content-popup-images">
        <?php
        $model->templateToHtml(['content']);
        echo $model->content;
        ?>
    </div>
</article>
<article>
    <?= $this->render('//layouts/likeShare') ?>
    <?= $this->render('//layouts/fbComment') ?>
</article>
<article class="related-news">
    <h3><?= Yii::t('app', 'Related articles') ?></h3>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $relatedItems,
            'imagesSize' => Image::SIZE_3
        ]) ?>
    </div>
</article>
<script>
    setTimeout(updateCounter, 3000);
    function updateCounter() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.response);
            }
        };
        xhttp.open("POST", "<?= Url::to(['article/update-counter']) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            (Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken)
            . ('&' . UrlParam::SLUG . '=' . $model->slug)
            . ('&' . UrlParam::NAME . '=view_count')
            . ('&' . UrlParam::VALUE . '=1')
            ?>");
    }
</script>