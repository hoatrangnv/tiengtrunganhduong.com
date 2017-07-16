<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/15/2017
 * Time: 1:08 PM
 */

/**
 * @var string $type
 * @var array $attrConfigs
 * @var array $childConfigs
 */

\common\modules\quiz\QuizCreatorAsset::register($this);
?>

<div id="root"></div>
<script type="text/babel">
    function submit(state) {
        console.log(state);
        var fd = new FormData();
        fd.append("state", JSON.stringify(state));
        fd.append("<?= Yii::$app->request->csrfParam ?>", "<?= Yii::$app->request->csrfToken ?>");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "<?= \yii\helpers\Url::to(['default/ajax-create']) ?>", true);
        xhr.onload = function() {
            if (this.status == 200) {
                var resp = JSON.parse(this.response);
                console.log('Server got:', resp);
                if (resp.success) {
                    console.log(resp);
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
            submit={submit}
            type={<?= json_encode($type) ?>}
            attrConfigs={<?= json_encode($attrConfigs) ?>}
            childConfigs={<?= json_encode($childConfigs) ?>}
            childrenData={[]}
        />,
        document.getElementById("root")
    );
</script>