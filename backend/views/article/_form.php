<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
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

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<style>
    #image-file-input,
    #image-preview-wrapper {
        margin-bottom: 1rem;
    }
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
            $image_uploader = '<div class="clearfix">' .
                '<div id="image-preview-wrapper">'
                . $model->img() .
                (($image = $model->image) ? "<div>{$image->width}x{$image->height}; {$image->aspect_ratio}</div>" : '') .
                '</div>' .
                '<input type="file" id="image-file-input" name="image_file" accept="image/*">' .
                '</div>';

            echo $form->field($model, 'image_id', [
                'template' => "{label}$image_uploader{input}{error}{hint}"])->dropDownList(
                    $model->image ? [$model->image->id => $model->image->name] : []);
            ?>

            <?php echo $form->field($model, 'category_id')->dropDownList(
                ArticleCategory::dropDownListData(),
                ['prompt' => Yii::t('app', 'Select one ...')])
            ?>

            <?php echo $form->field($model, 'publish_time_timestamp')->textInput(['type' => 'datetime']);
            ?>

        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'menu_label')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'sort_order')->textInput() ?>
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
                <span>Submit and back here</span>
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
<script>
<?php
$this->beginBlock('image_file_uploader');
?>
var img_select = $("#<?= Html::getInputId($model, 'image_id') ?>");
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
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelection = function (repo) {
    return repo.name || repo.text;
};
img_select.select2({
    ajax: {
        url: "<?= Url::to(['image/search']) ?>",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 1,
    templateResult: formatRepo, // omitted for brevity, see the source of this page
    templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
});

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
                    var info = document.createElement("div");
                    info.innerHTML =resp. image.width + "x" + resp.image.height + "; " + resp.image.aspect_ratio;
                    img_preview.innerHTML = '';
                    img_preview.appendChild(image);
                    img_preview.appendChild(info);
                    img_select.empty()
                        .append('<option value="' + resp.image.id + '">' + resp.image.name + '</option>')
                        .val(resp.image.id).trigger("change");

                } else {
                    img_preview.innerHTML = '<div class="text-danger">Errors: ' + JSON.stringify(resp.errors) + '</div>';
                }
            } else {
                img_preview.innerHTML = '<div class="text-danger">Upload failed! Please try again</div>';
            }
        };
        xhr.send(fd);

    });
    // On change
    img_select.on("change", function (event) {
        var id = img_select.val();
        var fd = new FormData();
        fd.append('id', id);
        fd.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->csrfToken ?>');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= Url::to(['image/find-one-by-id'], true) ?>', true);
        xhr.onload = function() {
            if (this.status == 200) {
                img_preview.innerHTML = '';
                var resp = JSON.parse(this.response);
                console.log('Server got:', resp);
                if (!!resp) {
                    var image = new Image();
                    image.src = resp.source;
                    img_preview.appendChild(image);
                    var info = document.createElement("div");
                    info.innerHTML = resp.width + "x" + resp.height + "; " + resp.aspect_ratio;
                    img_preview.appendChild(info);
                } else {
                    img_preview.innerHTML = '<div class="text-danger">Cannot find this image on server</div>';
                }
            } else {
                img_preview.innerHTML = '<div class="text-danger">Failed to request image!</div>';
            }
        };
        xhr.send(fd);
    });
<?php
$this->endBlock();
    $this->registerJs($this->blocks['image_file_uploader'], View::POS_READY, 'image_file_uploader');
    $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js', [
        'depends' => \yii\web\JqueryAsset::className()
    ]);
?>
</script>
<script src="<?= Yii::getAlias('@web/libs/datetimepicker/datetimepicker.js') ?>"></script>
<link href="<?= Yii::getAlias('@web/libs/datetimepicker/datetimepicker.css') ?>" rel="stylesheet">
<style>
    .datetimePicker__widget {
        display: none;
        position: absolute;
        z-index: 999;
        background: #fff;
    }
    .datetimePicker__widget.active {
        display: table;
    }
</style>
<script>
    !function (datetimeInput) {
        if (!datetimeInput) {
            throw Error();
        }
        datetimeInput.picker = new DatetimePicker(
            new Date(datetimeInput.value),
            {
                "weekdays": ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                "months": ["Giêng", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười Một", "Mười Hai"],
                "onChange": function (current) {
                    exportValue();
                },
                "classNamePrefix": "datetimePicker__"
            }
        );
        var widget = datetimeInput.picker.widget(
            {
                "yearMonthBlock": {
                    "items": ["yearCell", "monthCell"]
                },
                "dateBlock": {
                    "onClick": function (current) {}
                },
                "timeBlock": {
                    "items": ["hoursCell", "minutesCell", "secondsCell"]
                },
                "controlBlock": {
                    "items": ["set2nowCell", "resetCell", "submitCell"],
                    "onSubmit": function (current) {
                        widget.classList.remove("active");
                    }
                },
                "items": ["yearMonthBlock", "dateBlock", "timeBlock", "controlBlock"]
            }
        );
        datetimeInput.addEventListener("input", function () {
            var time = (new Date(datetimeInput.value)).getTime();
            if (!isNaN(time)) {
                datetimeInput.picker.current.time = time;
            } else {
                exportValue();
            }
        });
        datetimeInput.parentNode.insertBefore(widget, datetimeInput.nextElementSiblings);
        datetimeInput.addEventListener("focusin", function () {
            datetimeInput.picker.current.time = (new Date(datetimeInput.value)).getTime();
            widget.classList.add("active");
        });
        document.addEventListener("click", function (event) {
            if (event.target !== datetimeInput &&
                event.target !== widget &&
                !checkIsContains(widget, event.target) &&
                checkIsContains(document, event.target)
            ) {
                widget.classList.remove("active");
            }
        });
        function exportValue() {
            var current = datetimeInput.picker.current;
            datetimeInput.value = "Y-m-d H:i:s"
                .replace(/Y/g, current.year)
                .replace(/m/g, pad(current.month + 1))
                .replace(/d/g, pad(current.date))
                .replace(/H/g, pad(current.hours))
                .replace(/i/g, pad(current.minutes))
                .replace(/s/g, pad(current.seconds))
            ;
        }
        function pad(number) {
            return number < 10 ? "0" + number : "" + number;
        }
        function checkIsContains(root, elem) {
            if (root.contains(elem)) {
                return true;
            } else {
                return [].some.call(root.children, function (child) {
                    return checkIsContains(child, elem);
                });
            }
        }
    }(document.getElementById("<?= Html::getInputId($model, 'publish_time_timestamp') ?>"));
</script>
