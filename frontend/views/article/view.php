<?php
$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $model->name ?></h1>
<article>
    <?php
    $html = $model->getContentWithTemplates();

    $patt = "/<code>(?:(?!<code>)(?:(?!<\/code>))[\s\S])*<\/code>/i";
    preg_match_all($patt, $html, $matches);
    foreach ($matches[0] as $code) {
        $html = str_replace($code, '<code>'
//            . htmlspecialchars(substr(substr($code, 0, -7), 6))
            . str_replace('&', '&amp;',
                str_replace('<', '&lt;',
                    str_replace('>', '&gt;',
                        substr(substr($code, 0, -7), 6)
                    )
                )
            )
            . '</code>', $html);
    }

    ?>

    <?= $html ?>
</article>