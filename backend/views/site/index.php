<?php
use yii\helpers\Url;
/* @var $this yii\web\View */
use backend\models\Article;
use backend\models\Image;
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div align="center">
        <h1>Congratulations!</h1>

        <!--<p class="lead">You have successfully created your Yii-powered application.</p>-->
        <p class="lead">You have successfully logged in. Let's start with...</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['article/create']) ?>"><span class="glyphicon glyphicon-edit"></span> NEW Article</a></p>
        <p><a class="btn btn-lg btn-primary" href="<?= Url::to(['upload/images']) ?>"><span class="glyphicon glyphicon-cloud-upload"></span> Images</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Inactive Articles (<?= Article::find()->isNot('active')->count() ?>)</h2>

                <ul>
                    <?php
                    foreach (Article::find()->isNot('active')->orderBy('publish_time desc')->limit(20)->all() as $item) {
                        echo "<li style='margin-top: 0.1em'>"
                            . $item->a(
                                $item->img('30x30') . " $item->name"
                            )
                            . "</li>";
                    }
                    ?>
                </ul>

                <p><a class="btn btn-default" href="<?= Url::to(['article/index', 'ArticleSearch[active]' => 0]) ?>">View all &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Active Articles (<?= Article::find()->countActive() ?>)</h2>

                <ul>
                    <?php
                    foreach (Article::find()->orderBy('publish_time desc')->limit(20)->allActive() as $item) {
                        echo "<li style='margin-top: 0.1em'>"
                            . $item->a(
                                $item->img('30x30') . " $item->name"
                            )
                            . "</li>";
                    }
                    ?>
                </ul>

                <p><a class="btn btn-default" href="<?= Url::to(['article/index', 'ArticleSearch[active]' => 1]) ?>">View all &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Active Images (<?= Image::find()->countActive() ?>)</h2>

                <ul id="motivatebox">
                    <?php
                    foreach (Image::find()->orderBy('id desc')->limit(20)->allActive() as $item) {
                        echo "<li style='margin-top: 0.1em'>"
                            . $item->a(
                                $item->img('30x30') . " $item->name"
                              )
                            . "</li>";
                    }
                    ?>
                </ul>

                <p><a class="btn btn-default" href="<?= Url::to(['image/index']) ?>">View all &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
