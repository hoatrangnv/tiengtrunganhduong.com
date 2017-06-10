<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\web\JsExpression;
use kartik\select2\Select2;
use backend\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */
/* @var $form yii\widgets\ActiveForm */
?>

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
$imageDropDownListOptions = [
    'name' => '',
    'value' => '',
    'initValueText' => '',
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

<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">

            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'image_id')->widget(
                Select2::className(),
                $imageDropDownListOptions)
            ?>

            <?php echo $form->field($model, 'parent_id')->dropDownList(
                ArticleCategory::dropDownListData(),
                ['prompt' => Yii::t('app', 'Select one ...')])
            ?>

            <?php echo $form->field($model, 'sort_order')->textInput() ?>
        </div>
        <div class="col-md-6">

            <?php echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-12">

            <?php echo $form->field($model, 'active')->checkbox() ?>

            <?php echo $form->field($model, 'visible')->checkbox() ?>

            <?php echo $form->field($model, 'featured')->checkbox() ?>

            <?php echo $form->field($model, 'long_description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="http://cdn.ckeditor.com/4.7.0/full-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace( '<?= Html::getInputId($model, 'long_description') ?>', {
        height: 300,

        // Configure your file manager integration. This example uses CKFinder 3 for PHP.
//        filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
//        filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
//        filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
        filebrowserImageUploadUrl: '<?= \yii\helpers\Url::to([
            'upload/ckeditor-image',
            Yii::$app->request->csrfParam => Yii::$app->request->csrfToken
        ]) ?>'
    } );
</script>