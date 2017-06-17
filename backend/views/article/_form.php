<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Image;
use yii\web\JsExpression;
use yii\helpers\Url;
use backend\models\ArticleCategory;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form yii\widgets\ActiveForm */

?>
<!--
<?= $model->templateLogMessage ?>
-->
<?php
$formatJs = <<< JS
var formatRepo = function (repo) {
    if (repo.loading) {
        return repo.text;
    }
    var markup =
'<div class="row">' + 
    '<div class="col-sm-5">' +
        '<img src="' + repo.source + '" class="img-rounded" style="width:50px" />' +
        '<b style="margin-left:5px">' + repo.name + '</b>' + 
    '</div>' +
    '<div class="col-sm-3"><i class="fa fa-code-fork"></i> ' + repo.width + 'x' + repo.height + '</div>' +
    '<div class="col-sm-3"><i class="fa fa-star"></i> ' + repo.aspect_ratio + '</div>' +
'</div>';
    // if (repo.description) {
    //   markup += '<h5>' + repo.description + '</h5>';
    // }
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelection = function (repo) {
    return repo.name || repo.text;
}
JS;

// Register the formatting script
$this->registerJs($formatJs, View::POS_HEAD);

// script to parse the results into the format expected by Select2
$resultsJs = <<< JS
function _(data, params) {
    console.log(data, params);
    params.page = params.page || 1;
    return {
        results: data.items,
        pagination: {
            more: (params.page * 30) < data.total_count
        }
    };
}
JS;

// render your widget
$image = $model->image;
$imageDropDownListOptions = [
    'name' => $image ? $image->name : '',
    'value' => $image ? $image->id : '',
    'initValueText' => $image ? $image->name : '',
    'options' => ['placeholder' => Yii::t('app', 'Search for a image ...')],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'ajax' => [
            'url' => \yii\helpers\Url::to(['image/search']),
            'dataType' => 'json',
            'delay' => 250,
            'data' => new JsExpression('function(params) { return {q: params.term, page: params.page}; }'),
            'processResults' => new JsExpression($resultsJs),
            'cache' => true
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('formatRepo'),
        'templateSelection' => new JsExpression('formatRepoSelection'),
    ],
];
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">
            <?php //echo $form->field($model, 'category_id')->textInput() ?>

            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'image_id')->widget(
                Select2::className(),
                $imageDropDownListOptions)
            ?>

            <?php echo $form->field($model, 'category_id')->dropDownList(
                ArticleCategory::dropDownListData(),
                ['prompt' => Yii::t('app', 'Select one ...')])
            ?>

            <?php echo $form->field($model, 'publish_time_timestamp')->textInput(['type' => 'datetime']) ?>


            <?php echo $form->field($model, 'sort_order')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'menu_label')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <?php echo $form->field($model, 'active')->checkbox() ?>

            <?php echo $form->field($model, 'visible')->checkbox() ?>

            <?php echo $form->field($model, 'featured')->checkbox() ?>

        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'doindex')->checkbox() ?>

            <?php echo $form->field($model, 'dofollow')->checkbox() ?>

            <?php echo $form->field($model, 'shown_on_menu')->checkbox() ?>

        </div>
        <div class="col-md-12">
            <?php echo $form->field($model, 'content')->textarea(['rows' => 20]) ?>

        </div>
    </div>
    <?php
    if (!$model->isNewRecord) {
        ?>
        <div class="form-group">
            <label class="btn btn-default">
                <input type="radio" name="submit-and" value="stay-here">
                <span>Submit then back here</span>
            </label>
        </div>
        <?php
    }
    ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    // Submit and stay here
    !function (inputs) {
        [].forEach.call(inputs, function (input) {
            input.addEventListener("change", function () {
                input.form.submit();
            });
        })
    }(document.querySelectorAll("input[name=submit-and]"));

    // CKEditor
    <?php
    if (!Yii::$app->request->get('code_editor')) {
    ?>
    !function (editor) {
        editor && ckeditor(editor);
    }(document.getElementById("<?= Html::getInputId($model, 'content') ?>"));
    <?php
    }
    ?>
</script>