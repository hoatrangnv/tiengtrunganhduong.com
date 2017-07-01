<?php
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

/**
 * @var $menu vanquyet\menu\Menu
 */
$menu = $this->context->menu;
?>
<nav class="nav-bar clr">
    <div class="menu clr">
        <button type="button" class="menu-toggle" on="tap:sidebar.toggle">
            <i class="icon menu-icon"></i>
            <span class="menu-title"><?= ($m = $menu->getActiveItem()) ? $m->label : 'Danh mục' ?></span>
        </button>
        <button type="button" class="search-toggle">
            <i class="icon magnifier-icon"></i>
        </button>
    </div>
</nav>
<amp-sidebar id="sidebar"
             layout="nodisplay"
             side="right">
    <amp-img class="amp-close-image"
             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAQAAABLCVATAAAAlklEQVR4Ae3USwqDQBAA0ercK3OYfC7lJ0dtA+JmQAp7EbKZcinzRIZu+kajRmDdaFzoTTIRwnxInuA1ko2tp3pmf580tGBm25+ZOGf0Q045Y9RyHFiIOuOUM0qtx8GVKDJC1Ri5ozojlDN16G+/1l/4JFSBCRucAqODU2B8cCqMUAXGBqe42M6p5I7H69Kqffxi+Y9GX50Hllcu+oGKAAAAAElFTkSuQmCC"
             width="20"
             height="20"
             alt="close sidebar"
             on="tap:sidebar.close"
             role="button"
             tabindex="0"></amp-img>
    <ul>
        <?php
        foreach ($menu->getRootItems() as $item) {
            /**
             * @var $item \vanquyet\menu\MenuItem
             * @var $children \vanquyet\menu\MenuItem[]
             * @var $grandchildren \vanquyet\menu\MenuItem[]
             */
            $children = $item->getChildren();
            if (empty($children)) {
                ?>
                <li<?= $item->isActive() ? ' class="active"' : '' ?>>
                    <?php
                echo $item->a();
                ?>
                </li>
                <?php
            } else {
                foreach ($children as $child) {
                    ?>
                    <li<?= $child->isActive() ? ' class="active"' : '' ?>>
                        <span class="child-text">
                            <?= $child->a() ?>
                        </span>
                    </li>
                    <?php
                }
            }
        }
        ?>
    </ul>
</amp-sidebar>
