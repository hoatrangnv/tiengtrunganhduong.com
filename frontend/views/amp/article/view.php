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
    </div>
    <div class="news-desc">
        <?= nl2br($model->description) ?>
    </div>
    <div class="news-content fit-content content-popup-images">
        <?php
        $model->templateToHtml(['content']);
        $content = preg_replace("/<img[^>]+\>/i", "", $model->getAmpContent());
        if (strpos($content, '<amp-youtube') !== false) {
            Yii::$app->params['has-amp-youtube'] = true;
        }
        if (strpos($content, '<amp-iframe') !== false) {
            Yii::$app->params['has-amp-iframe'] = true;
        }
        if (strpos($content, '<amp-audio') !== false) {
            Yii::$app->params['has-amp-audio'] = true;
        }
        echo str_replace(
            ['<table ', '</table>'],
            ['<div class="table-wrapper"><table ', '</table></div>'],
            $model->content);
        ?>
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