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
