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
\common\modules\quiz\QuizCreatorAsset::register($this);
?>

<div id="root"></div>
<script type="text/babel">
    function save(state) {
        var fd = new FormData();
        fd.append("state", JSON.stringify(state));
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= \yii\helpers\Url::to(['default/ajax-save']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var resp = JSON.parse(this.response);
                console.log('Server got:', resp);
                if (resp.success) {
                } else {
                }
            } else {
            }
        };
        xhr.upload.onprogress = function(event) {
        };
        xhr.send(fd);

    }
    ReactDOM.render(
        <QuizModel
            save={save}
            type={<?= json_encode($type) ?>}
            attrs={<?= json_encode($attrs) ?>}
            childConfigs={<?= json_encode($childConfigs) ?>}
            childrenData={<?= json_encode($childrenData) ?>}
        />,
        document.getElementById("root")
    );
</script>