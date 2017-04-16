<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/16/2017
 * Time: 8:33 AM
 */
?>
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
foreach ($sitemaps as $sitemap) {
?>
    <sitemap>
        <loc><?= $sitemap['loc'] ?></loc>
        <lastmod><?= $sitemap['lastmod'] ?></lastmod>
    </sitemap>
<?php
}
?>
</sitemapindex>
