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
    <?= $this->render('//layouts/likeShare') ?>
    <div class="content aspect-ratio __5x3">
        <?= $this->render('items', [
            'models' => $models,
            'imagesSize' => $this->context->screen == 'small' ? '90x50' : '190x100',
        ]) ?>
    </div>
</div>