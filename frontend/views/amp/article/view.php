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
        echo preg_replace("/<img (.*)>/", "", $model->getAmpContent());
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