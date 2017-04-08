<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\aceeditor\AceEditor;
use kartik\select2\Select2;
use backend\models\Image;


/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">
            <?php //echo $form->field($model, 'category_id')->textInput() ?>

            <?= $form->field($model, 'image_id')->widget(Select2::classname(), [
                'data' => \backend\models\Image::listAsId2Name(),
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Select...'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'publish_time_timestamp')->textInput(['type' => 'datetime']) ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>


            <?php //echo $form->field($model, 'sub_content')->textarea(['rows' => 6]) ?>


        </div>

        <?php //echo $form->field($model, 'visible')->textInput() ?>

        <?php //echo $form->field($model, 'hot')->textInput() ?>

        <?php //echo $form->field($model, 'status')->textInput() ?>

        <?php //echo $form->field($model, 'type')->textInput() ?>

        <?php //echo $form->field($model, 'sort_order')->textInput() ?>

        <!--<div class="form-group">
            <div class="my-grid-view g8 md-g6 sm-g4">
                <div class="clr"></div>
                <ul>
                    <?php
    /*                foreach (Image::find()->limit(10)->allActive() as $item) {
                        */?><li>
                            <div class="img-wrap">
                                <?/*= $item->img(Image::SIZE_2) */?>
                            </div>
                            <div class="caption">
                                <?/*= $item->getImgTemplate(Image::SIZE_2) */?>
                            </div>
                        </li><?php
    /*                }
                    */?>
                </ul>
                <div class="clr"></div>
            </div>
        </div>-->

        <div class="col-md-12">
            <?php
                $code_editor = Yii::$app->request->get('code_editor');
                if (!$code_editor || $code_editor == 'text') {
                    echo $form->field($model, 'content')->textarea(['rows' => 10]);
                } else {
//                    echo $form->field($model, 'content')->widget(
//                        AceEditor::className(),
//                        [
//                            'mode' => 'php', // programing language mode. Default "html"
//                            'theme' => $code_editor, // editor theme. Default "github"
//                            'containerOptions' => [
//                                'style' => 'width:100%;min-height:400px;font-size:14px'
//                            ]
//                        ]
//                    );
                    echo $form->field($model, 'content')->textarea(['style' => 'display:none']);
                    ?>
                    <style type="text/css" media="screen">
                        #code-editor {
                            display: block;
                            width: 100%;
                            min-height: 300px;
                        }
                    </style>
                    <div id="code-editor"><?= htmlentities($model->content) ?></div>
                    <script src="<?= Yii::$app->homeUrl ?>/ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
                    <script>
                        var editor = ace.edit("code-editor");
                        editor.setTheme("ace/theme/monokai");
                        editor.setOptions({
                            maxLines: Infinity
                        });
                        editor.getSession().setMode("ace/mode/php");
                        editor.getSession().setTabSize(4);
                        editor.getSession().on("change", function(e) {
                            var textArea = document.getElementById("<?= Html::getInputId($model, 'content') ?>");
                            textArea.value = editor.getValue();
                        });
                        var bak_overflow = window.getComputedStyle(document.body, null).getPropertyValue("overflow");
                        editor.getSession().selection.on('changeSelection', function(e) {
//                            document.body.style.overflow = "hidden";
//                            setTimeout(function () {
//                                document.body.style.overflow = bak_overflow;
//                            }, 100);
                            document.getElementsByTagName("html")[0].style.overflow = "hidden";
                            document.getElementsByTagName("body")[0].style.overflow = "hidden";
                        });
                    </script>
                    <?php
                }
            ?>
            <?= $form->field($model, 'active')->checkbox() ?>

            <div class="form-group">
                <label class="btn btn-default">
                    <input type="radio" name="submit-and" value="stay-here">
                    <span>Submit and stay here</span>
                </label>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    !function (inputs) {
        [].forEach.call(inputs, function (input) {
            input.addEventListener("change", function () {
                input.form.submit();
            });
        })
    }(document.querySelectorAll("input[name=submit-and]"))
</script>