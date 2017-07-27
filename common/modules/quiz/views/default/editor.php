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
\common\modules\quiz\QuizEditorAsset::register($this);
?>
<script type="text/babel">
    function save(state, callback) {
        var fd = new FormData();
        fd.append("state", JSON.stringify(state));
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= \yii\helpers\Url::to(['default/ajax-save']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var res = JSON.parse(this.response);
//                console.log('Server got:', res);
//                return res;
                callback(res);
            } else {
            }
        };
        xhr.upload.onprogress = function(event) {
        };
        xhr.send(fd);

    }

    ReactDOM.render(
        <QuizEditor
            save={save}
            type={<?= json_encode($type) ?>}
            attrs={<?= json_encode($attrs) ?>}
            childConfigs={<?= json_encode($childConfigs) ?>}
            childrenData={<?= json_encode($childrenData) ?>}
            showAttrsForm={true}
        />,
        document.getElementById("root")
    );

</script>