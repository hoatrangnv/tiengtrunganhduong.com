<?php
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;

//require_once Yii::getAlias('@app/runtime/tmp-extensions/yii2-menu/Menu.php');
//require_once Yii::getAlias('@app/runtime/tmp-extensions/yii2-menu/MenuItem.php');
//use vanquyet\menu\Menu;

//var_dump($this->context->menu->getRootItems());
/**
 * @var $menu vanquyet\menu\Menu
 */
$menu = $this->context->menu;
?>
<nav class="nav-bar clr">
    <div class="menu clr">
        <button type="button" class="menu-toggle" onclick="this.classList.toggle('active')">
            <i class="icon menu-icon"></i>
            <span class="menu-title"><?= ($m = $menu->getActiveItem()) ? $m->label : 'Danh mục' ?></span>
        </button>
        <ul>
            <?php
            foreach ($menu->getRootItems() as $item) {
                /**
                 * @var $item \vanquyet\menu\MenuItem
                 * @var $children \vanquyet\menu\MenuItem[]
                 * @var $grandchildren \vanquyet\menu\MenuItem[]
                 */
                $children = $item->getChildren();
                ?>
                <li<?= $item->isActive() ? ' class="active"' : '' ?>>
                    <?php
                    if (empty($children)) {
                        echo $item->a();
                    } else {
                        ?>
                        <button type="button" class="menu-toggle<?= $item->isActive() ? ' active' : '' ?>" onclick="this.classList.toggle('active')"></button>
                        <?= $item->a() ?>
                        <ul>
                            <?php
                            foreach ($children as $child) {
                                ?>
                                <li<?= $child->isActive() ? ' class="active"' : '' ?>>
                                    <?php
                                    $grandchildren = $child->getChildren();
                                    if (empty($grandchildren)) {
                                        echo $child->a();
                                    } else {
                                        ?>
                                        <button class="menu-toggle" onclick="this.classList.toggle('active')"></button>
                                        <?= $child->a() ?>
                                        <ul>
                                            <?php
                                            foreach ($grandchildren as $grandchild) {
                                                echo ($grandchild->isActive() ? '<li class="active">' : '<li>') . "{$grandchild->a()}</li>";
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <button type="button" class="search-toggle"
                onclick="
                    document.getElementById('search-toolbar').classList.toggle('active');
                    document.querySelector('.gsc-search-box-tools .gsc-search-box input.gsc-input').focus();
                ">
            <i class="icon magnifier-icon"></i>
        </button>
    </div>
</nav>
<div class="search-toolbar clr" id="search-toolbar">
    <gcse:search></gcse:search>
</div>
