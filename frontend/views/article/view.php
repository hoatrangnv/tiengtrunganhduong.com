<?php
// For test extension
//require_once (Yii::getAlias('@common/runtime/tmp-extensions/yii2-query-template/QueryTemplate.php'));
use frontend\models\SiteParam;
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

$img_src = '';
if ($model->image) {
    $img_src = $model->image->getImgSrc();
}
if (!$img_src) {
    $img_src = Url::home(true) . 'img/tieng_trung_anh_duong.png';
}
?>
<article itemscope itemtype="http://schema.org/Article">
    <div itemprop="mainEntityOfPage">
        <h1 class="news-title" itemprop="headline"><?= $model->name ?></h1>
        <meta itemprop="datePublished" content="<?= date('Y-m-d', $model->publish_time) ?>" property=""/>
        <meta itemprop="dateModified" content="<?= date('Y-m-d', $model->update_time) ?>" property=""/>
        <meta itemprop="image" content="<?= $img_src ?>" property=""/>
        <div class="news-info">
            <?= $this->render('info', ['model' => $model]) ?>
            <?= $this->render('//layouts/likeShare') ?>
        </div>
        <div class="news-desc" itemprop="description">
            <?= nl2br($model->description) ?>
        </div>
        <div class="news-content paragraph content-popup-images" itemprop="articleBody">
            <?=
            str_replace(
                ['<table ', '</table>'],
                ['<div class="table-wrapper" itemscope itemtype="http://schema.org/Table"><table ', '</table></div>'],
                $model->content
            );
            ?>
        </div>
        <div class="news-author">
            <span class="author" itemprop="author" itemscope itemtype="http://schema.org/Person">
                <span class="author-name" itemprop="name"><?= ($model->creator && $model->creator->pen_name) ? $model->creator->pen_name : 'Nguyễn Thoan' ?></span>
            </span>
            <span>|</span>
            <span class="publisher" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
                <span class="publisher-name" itemprop="name"><?= ($item = SiteParam::findOneByName(SiteParam::COMPANY_NAME)) ? $item->value : Yii::$app->name ?></span>
                <span class="publisher-logo" itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                    <img src="<?= Url::home(true) ?>favicon.ico" alt="logo" itemprop="url">
                </span>
            </span>
        </div>
    </div>
</article>
<article>
    <?= $this->render('//layouts/likeShare') ?>
    <?= $this->render('//layouts/fbComment') ?>
</article>
<div class="related-news">
    <h3 class="title"><?= Yii::t('app', 'Related articles') ?></h3>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $relatedItems,
            'imagesSize' => '100x60'
        ]) ?>
    </div>
</div>
<script>
    setTimeout(updateCounter, 3000);
    function updateCounter() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                console.log(xhttp.response);
            }
        };
        xhttp.open("POST", "<?= Url::to(['article/ajax-update-counter']) ?>");
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("<?=
            (Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken)
            . ('&' . UrlParam::FIELD . '=view_count')
            . ('&' . UrlParam::VALUE . '=1')
            . ('&' . UrlParam::SLUG . '=' . $model->slug)
            ?>");
    }
</script>