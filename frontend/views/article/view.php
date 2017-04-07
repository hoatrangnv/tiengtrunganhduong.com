<?php
$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $model->name ?></h1>
<article>
    <?php
    $html = $model->getContentWithTemplates();
    $dom = new DOMDocument;
    $dom->loadHTML($html);
    $codes = $dom->getElementsByTagName('code');
    foreach ($codes as &$code) {
        $code->textContent = htmlentities($code->textContent);

    }

    ?>

    ?>
    <?= $model->getContentWithTemplates() ?>
</article>