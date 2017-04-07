<?php
$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $model->name ?></h1>
<article>
    <?php
    $html = $model->getContentWithTemplates();

    $patt = "/<code>((?:(?!<code>)[\s\S])*)<\/code>/i";
    preg_match_all($patt, $html, $matches);
    foreach ($matches[1] as $inner_code) {
//        var_dump($inner_code);
//        echo "<br>";
//        var_dump(htmlspecialchars($inner_code));
        $html = str_replace($inner_code, htmlspecialchars($inner_code), $html);
    }
    ?>

    <?= $html ?>
</article>