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
?>
<article itemscope itemtype="http://schema.org/Article">
    <div itemprop="mainEntityOfPage">
        <h1 class="news-title" itemprop="headline"><?= $model->name ?></h1>
        <meta itemprop="datePublished" content="<?= date('Y-m-d', $model->publish_time) ?>" property=""/>
        <meta itemprop="dateModified" content="<?= date('Y-m-d', $model->update_time) ?>" property=""/>
        <?php
        if ($model->image) {
            ?>
            <meta itemprop="image" content="<?= $model->image->getImgSrc() ?>" property=""/>
            <?php
        }
        ?>
        <div class="news-info">
            <?= $this->render('info', ['model' => $model]) ?>
        </div>
        <div class="news-desc" itemprop="description">
            <?= nl2br($model->description) ?>
        </div>
        <div class="news-content paragraph content-popup-images" itemprop="articleBody">
            <?php
            $content = preg_replace("/<img[^>]+\>/i", "", $model->getAmpContent());

            echo str_replace(
                ['<table ', '</table>'],
                ['<div class="table-wrapper"><table ', '</table></div>'],
                $content);

            if (strpos($content, '<amp-youtube') !== false) {
                Yii::$app->params['has-amp-youtube'] = true;
            }

            if (strpos($content, '<amp-iframe') !== false) {
                Yii::$app->params['has-amp-iframe'] = true;
            }

            if (strpos($content, '<amp-audio') !== false) {
                Yii::$app->params['has-amp-audio'] = true;
            }
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
                    <amp-img width="17" height="17" layout="responsive" src="<?= Url::home(true) ?>favicon.ico" alt="logo" itemprop="url">
                </span>
            </span>
        </div>
    </div>
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