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
<style amp-custom>
    #sidebar {
        padding: 1rem;
        background: #fff;
    }
    #sidebar .amp-close-image {
        position: absolute;
        top: 0;
        right: 0;
    }
    #sidebar ul {
        list-style: none;
    }
    #sidebar ul li {
        padding: 0.5em;
        color: #FF2D33;
    }
    #sidebar ul li .child-text {
        font-size: 0.86em;
        padding-left: 0.5em;
        color: #333;
    }
    #sidebar ul li.active {
        background: #cef;
    }
    #sidebar ul li:hover {
        text-decoration: underline;
    }
</style>
<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
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
