<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/15/2017
 * Time: 1:08 PM
 */

/**
 * @var string $type
 * @var array $attrs
 * @var array $childConfigs
 * @var array $childrenData
 */
use yii\helpers\Url;
use \common\modules\quiz\QuizEditorAsset;
use common\modules\quiz\LocalQuizEditorAsset;

if (Yii::$app->request->get('use_local_asset') == 1) {
    LocalQuizEditorAsset::register($this);
} else {
    QuizEditorAsset::register($this);
};
?>
<div id="quiz-editor-root"></div>
<script>
    window.QuizEditorRoot = document.getElementById("quiz-editor-root");
    window.QuizEditorProps = {
        save: save,
        model: {
            type: <?= json_encode($type) ?>,
            attrs: <?= json_encode($attrs) ?>,
            childConfigs: <?= json_encode($childConfigs) ?>,
            childrenData: <?= json_encode($childrenData) ?>
        },
        imagesAPI: <?= json_encode(Url::to(['image/search'], true)) ?>
    };
    //==========================================
    function save(state, callback) {
        var fd = new FormData();
        fd.append("state", JSON.stringify(state));
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= \yii\helpers\Url::to(['default/ajax-save']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var res = JSON.parse(this.response);
                console.log('Server got text:', this.response);
                console.log('-- json parse -->', res);
//                return res;
                callback(res);
            } else {
                callback({
                    state: state,
                    errors: {
                        HTTP_ERROR: 'Status: ' + this.status
//                        + ', Status Text: ' + this.statusText
//                        + ', Response Text' + this.responseText
                    },
                    success: false
                });
            }
        };
        xhr.upload.onprogress = function(event) {
        };
        xhr.send(fd);

    }
</script>