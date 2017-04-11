<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
use backend\models\Article;
use backend\models\Image;
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div align="center">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['article/create', 'code_editor' => true]) ?>">New Article</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Inactive Articles</h2>

                <ul>
                    <?php
                    foreach (Article::find()->where(['active' => 0])->orderBy('publish_time desc')->limit(20)->all() as $item) {
                        echo "<li>{$item->a(null, [], ['code_editor' => 1])}</li>";
                    }
                    ?>
                </ul>

                <p><a class="btn btn-default" href="<?= Url::to(['article/index', 'ArticleSearch[active]' => 0]) ?>">Articles &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Active Articles</h2>

                <ul>
                    <?php
                    foreach (Article::find()->where(['active' => 1])->orderBy('publish_time desc')->limit(20)->all() as $item) {
                        echo "<li>{$item->a(null, [], ['code_editor' => 1])}</li>";
                    }
                    ?>
                </ul>

                <p><a class="btn btn-default" href="<?= Url::to(['article/index', 'ArticleSearch[active]' => 1]) ?>">Articles &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Images</h2>

                <ul id="motivatebox">
                    <?php
                    foreach (Image::find()->orderBy('create_time desc')->limit(20)->all() as $item) {
                        echo
                            "<li>"
                            . "<span class=\"bg-default motivate\">{$item->getImgTemplate()}</span>"
                            . $item->a(
                                $item->img('50x50', ['style' => 'max-width:50px;max-height:50px'])
                                . "{$item->name}"
                              )
                            . "</li>";
                    }
                    ?>
                </ul>

                <p><a class="btn btn-default" href="<?= Url::to(['image/index']) ?>">Images &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
