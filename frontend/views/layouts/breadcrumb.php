<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/11/2018
 * Time: 5:35 PM
 */
use yii\helpers\Url;

$canonicalLink = $this->context->canonicalLink;
$links = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
?>
<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
    <?php
    array_unshift($links, ['url' => Url::home(true), 'label' => Yii::t('app', 'Homepage')]);
    $pos = 0;
    foreach ($links as $link) {
        $pos++;
        $item = [];
        if (is_string($link)) {
            $item['url'] = $canonicalLink;
            $item['label'] = $link;
        } else if (isset($link['url']) && isset($link['label'])) {
            $item = $link;
        }

        if ($pos > 1) {
            ?>
            <span class="divider">/</span>
            <?php
        }
        ?>

        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="<?= $item['url'] ?>" title="<?= $item['label'] ?>" itemprop="item">
                <span itemprop="name"><?= $item['label'] ?></span>
            </a>
            <meta itemprop="position" content="<?= $pos ?>" />
        </li>

        <?php
    }
    ?>
</ol>
