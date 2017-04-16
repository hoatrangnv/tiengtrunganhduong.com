<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/16/2017
 * Time: 9:34 AM
 */
?>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
foreach ($urls as $url) {
?>
    <url>
        <loc><?= $url['loc'] ?></loc>
        <lastmod><?= $url['lastmod'] ?></lastmod>
        <changefreq>always</changefreq>
        <priority><?= $url['priority'] ?></priority>
    </url>
<?php
}
?>
</urlset>