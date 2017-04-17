<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/16/2017
 * Time: 9:06 AM
 */
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php
foreach ($urls as $url) {
?>
    <url>
        <loc><?= $url['loc'] ?></loc>
        <changefreq>hourly</changefreq>
        <priority>0.8</priority>
        <news:news>
            <news:publication>
                <news:name><?= \Yii::$app->name ?></news:name>
                <news:language>en</news:language>
            </news:publication>
            <news:genres>Blog</news:genres>
            <news:publication_date><?= $url['news']['publication_date'] ?></news:publication_date>
            <news:title><?= $url['news']['title'] ?></news:title>
            <news:keywords><?= $url['news']['keywords'] ?></news:keywords>
        </news:news>
        <?php
        if (isset($url['image'])) {
            ?>
            <image:image>
                <image:loc><?= $url['image']['loc'] ?></image:loc>
                <image:title><?= $url['image']['title'] ?></image:title>
                <image:caption><?= $url['image']['caption'] ?></image:caption>
            </image:image>
            <?php
        }
        ?>
    </url>
<?php
}
?>
</urlset>