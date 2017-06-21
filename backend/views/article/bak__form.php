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
// @TODO: Default value for some boolean attributes
if ($model->isNewRecord) {
    foreach (['doindex', 'dofollow', 'active', 'visible'] as $attribute) {
        $model->$attribute = true;
    }
}

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
    'options' => ['placeholder' => Yii::t('app', 'Search for an image ...')],
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

<style>
    #image-preview-wrapper img {
        display: block;
        width: 100%;
        max-width: 200px;
    }
</style>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">
            <?php //echo $form->field($model, 'category_id')->textInput() ?>

            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?php
            $image_uploader =
                '<div id="image-preview-wrapper">' . $model->img() . '</div>' .
                '<input type="file" id="image-file-input" name="image_file" accept="image/*">';
            ?>

            <?php echo $form->field($model, 'image_id', ['template' => "{label}$image_uploader{input}{error}{hint}"])->widget(
                Select2::className(),
                $imageDropDownListOptions)
            ?>


            <script>
            <?php
            $js = $this->beginBlock('image_file_uploader');
            ?>
                window.addEventListener("load", function () {
                    var img_select = document.getElementById("<?= Html::getInputId($model, 'image_id') ?>");
                    var img_preview = document.getElementById("image-preview-wrapper");
                    var img_input = document.getElementById("image-file-input");
                    img_input.addEventListener("change", function (event) {
                        var file = this.files[0];
                        var fd = new FormData();
                        fd.append(img_input.name, file);
                        fd.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->csrfToken ?>');
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?= Url::to(['upload/ajax-image'], true) ?>', true);
                        xhr.upload.onprogress = function(event) {
                            if (event.lengthComputable) {
                                var percentComplete = (event.loaded / event.total) * 100;
                                img_preview.innerHTML = percentComplete + '% uploaded';
                            }
                        };
                        xhr.onload = function() {
                            if (this.status == 200) {
                                var resp = JSON.parse(this.response);
                                console.log('Server got:', resp);
                                if (resp.success) {
                                    var image = new Image();
                                    image.src = resp.image.source;
                                    img_preview.innerHTML = '';
                                    img_preview.appendChild(image);
//                                    img_select.value = resp.image.id;
                                    jQuery('#article-image_id').select2('data', resp.image);
//                                    fireEvent(img_select, "change");
                                    console.log(img_select);
                                }
                            }
                        };
                        xhr.send(fd);
                    });
                });
            <?php
            $this->endBlock();
                $this->registerJs($this->blocks['image_file_uploader'], View::POS_END, 'image_file_uploader');
            ?>
            </script>


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

    /**
     * Fire an event handler to the specified node. Event handlers can detect that the event was fired programatically
     * by testing for a 'synthetic=true' property on the event object
     * @param {HTMLNode} node The node to fire the event handler on.
     * @param {String} eventName The name of the event without the "on" (e.g., "focus")
     */
    function fireEvent(node, eventName) {
        // Make sure we use the ownerDocument from the provided node to avoid cross-window problems
        var doc;
        if (node.ownerDocument) {
            doc = node.ownerDocument;
        } else if (node.nodeType == 9){
            // the node may be the document itself, nodeType 9 = DOCUMENT_NODE
            doc = node;
        } else {
            throw new Error("Invalid node passed to fireEvent: " + node.id);
        }

        if (node.dispatchEvent) {
            // Gecko-style approach (now the standard) takes more work
            var eventClass = "";

            // Different events have different event classes.
            // If this switch statement can't map an eventName to an eventClass,
            // the event firing is going to fail.
            switch (eventName) {
                case "click": // Dispatching of 'click' appears to not work correctly in Safari. Use 'mousedown' or 'mouseup' instead.
                case "mousedown":
                case "mouseup":
                    eventClass = "MouseEvents";
                    break;

                case "focus":
                case "change":
                case "blur":
                case "select":
                    eventClass = "HTMLEvents";
                    break;

                default:
                    throw "fireEvent: Couldn't find an event class for event '" + eventName + "'.";
                    break;
            }
            var event = doc.createEvent(eventClass);
            event.initEvent(eventName, true, true); // All events created as bubbling and cancelable.

            event.synthetic = true; // allow detection of synthetic events
            // The second parameter says go ahead with the default action
            node.dispatchEvent(event, true);
        } else  if (node.fireEvent) {
            // IE-old school style, you can drop this if you don't need to support IE8 and lower
            var event = doc.createEventObject();
            event.synthetic = true; // allow detection of synthetic events
            node.fireEvent("on" + eventName, event);
        }
    };
</script>