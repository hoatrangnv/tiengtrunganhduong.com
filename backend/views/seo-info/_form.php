<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use yii\web\View;
use backend\models\SeoInfo;

/* @var $this yii\web\View */
/* @var $model backend\models\SeoInfo */
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

<div class="seo-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'image_id')->widget(
            Select2::className(),
            $imageDropDownListOptions)
        ?>

        <?php //echo $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'route')->dropDownList(
            SeoInfo::getRoutes(),
            ['prompt' => Yii::t('app', 'Select one ...')]
        ) ?>

    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'doindex')->checkbox() ?>

        <?= $form->field($model, 'dofollow')->checkbox() ?>

        <?= $form->field($model, 'active')->checkbox() ?>

        <?= $form->field($model, 'long_description')->textarea(['rows' => 20]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    !function (editor) {
        editor && ckeditor(editor);
    }(document.getElementById("<?= Html::getInputId($model, 'long_description') ?>"));
</script>
