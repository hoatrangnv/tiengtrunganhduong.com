<?php
/**
 * @var $menu vanquyet\menu\Menu
 */
$menu = $this->context->menu;
?>
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
             */
            ?>
            <li<?= $item->isActive() ? ' class="active"' : '' ?>>
                <?= $item->a() ?>
            </li>
            <?php
            foreach ($item->getChildren() as $child) {
                ?>
                <li class="<?= $child->isActive() ? 'active child' : 'child' ?>">
                    <?= $child->a() ?>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</amp-sidebar>