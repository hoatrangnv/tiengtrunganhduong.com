<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!--<script src="http://cdn.ckeditor.com/4.7.0/full-all/ckeditor.js"></script>-->
<script src="<?= Yii::getAlias('@web/ckeditor/ckeditor.js') ?>"></script>
<script>
function ckeditor(id) {
    /**
     * Documentation:
     * http://sdk.ckeditor.com/samples/fileupload.html
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
//    filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
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