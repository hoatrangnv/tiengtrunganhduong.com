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
    ReactDOM.render(
        <QuizModel
            type={<?= json_encode($type) ?>}
            attrConfigs={<?= json_encode($attrConfigs) ?>}
            childConfigs={<?= json_encode($childConfigs) ?>}
            childrenData={[]}
        />,
        document.getElementById("root")
    );
</script>