<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!--<script src="http://cdn.ckeditor.com/4.7.0/full-all/ckeditor.js"></script>-->
<script src="<?= Yii::getAlias('@web/libs/ckeditor/ckeditor.js') ?>"></script>
<script>
function ckeditor(id) {
    /**
     * Documentation:
     * http://sdk.ckeditor.com/samples/fileupload.html
     * http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)
     */
//CKEDITOR.replace( '<?//= Html::getInputId($model, 'long_description') ?>//', {
//    height: 300,
//
//    // Configure your file manager integration. This example uses CKFinder 3 for PHP.
////        filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
//    filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
////        filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
////        filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
//    filebrowserImageUploadUrl: '<?php //echo \yii\helpers\Url::to([
    //        'upload/ckeditor-image',
    //        Yii::$app->request->csrfParam => Yii::$app->request->csrfToken
    //    ]) ?>//'
//} );
    CKEDITOR.replace(id, {
        extraPlugins: 'uploadimage,image2',
        height: 300,

        // Upload images to a CKFinder connector (note that the response type is set to JSON).
//    uploadUrl: '<?php //echo Url::to([
        //        'upload/ckeditor-image',
        //        Yii::$app->request->csrfParam => Yii::$app->request->csrfToken
        //    ]) ?>//',

        // Configure your file manager integration. This example uses CKFinder 3 for PHP.
//    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
//        filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
        filebrowserImageBrowseUrl: '<?= Yii::getAlias('@web/libs/ckfinder/ckfinder.html?type=Images') ?>',
        filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: '<?php echo Url::to([
            'upload/ckeditor-image',
            Yii::$app->request->csrfParam => Yii::$app->request->csrfToken
        ]) ?>',

        // The following options are not necessary and are used here for presentation purposes only.
        // They configure the Styles drop-down list and widgets to use classes.

        stylesSet: [
            {name: 'Narrow image', type: 'widget', widget: 'image', attributes: {'class': 'image-narrow'}},
            {name: 'Wide image', type: 'widget', widget: 'image', attributes: {'class': 'image-wide'}}
        ],

        // Load the default contents.css file plus customizations for this sample.
        contentsCss: [CKEDITOR.basePath + 'contents.css', 'http://sdk.ckeditor.com/samples/assets/css/widgetstyles.css'],

        // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
        // resizer (because image size is controlled by widget styles or the image takes maximum
        // 100% of the editor width).
        image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
        image2_disableResizer: true
    });
}
</script>
<script>
    window.addEventListener("load", autoGenerateValues);
    function autoGenerateValues() {
        var events = ["change"];
        !function (slug, name, meta_title, desc, meta_desc) {
            events.forEach(function (event) {
                if (name && slug) {
                    name.addEventListener(event, function () {
                        slug.value || (slug.value = vi_slugify(name.value));
                    });
                }
                if (name && meta_title) {
                    name.addEventListener(event, function () {
                        meta_title.value || (meta_title.value = name.value);
                    });
                }
                if (desc && meta_desc) {
                    desc.addEventListener(event, function () {
                        meta_desc.value || (meta_desc.value = desc.value);
                    });
                }
            });
        }(
            document.querySelector("[name$='[slug]']"),
            document.querySelector("[name$='[name]']"),
            document.querySelector("[name$='[meta_title]']"),
            document.querySelector("[name$='[description]']"),
            document.querySelector("[name$='[meta_description]']")
        );
    }
    function slugify(text)
    {
        return text.toString().toLowerCase()
            .replace(/(\w)\'/g, '$1')           // Special case for apostrophes
            .replace(/[^a-z0-9_\-]+/g, '-')     // Replace all non-word chars with -
            .replace(/\-\-+/g, '-')             // Replace multiple - with single -
            .replace(/^-+/, '')                 // Trim - from start of text
            .replace(/-+$/, '');                // Trim - from end of text
    }
    function lowercase_vi_filter(text)
    {
        return text.toString().toLowerCase()
            .replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a")
            .replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e")
            .replace(/ì|í|ị|ỉ|ĩ/g, "i")
            .replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o")
            .replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u")
            .replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y")
            .replace(/đ/g, "d");
    }
    function vi_slugify(text) {
        return slugify(lowercase_vi_filter(text));
    }
</script>