/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.14 : Database - quyettran_com
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `quyettran_com`;

/*Table structure for table `article` */

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `sub_content` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `hot` tinyint(1) DEFAULT NULL,
  `sort_order` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `publish_time` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `shares` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `image_id` (`image_id`),
  KEY `user_id` (`creator_id`),
  KEY `editor_id` (`updater_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `article_ibfk_2` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `article_ibfk_3` FOREIGN KEY (`updater_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `article` */

insert  into `article`(`id`,`creator_id`,`updater_id`,`category_id`,`image_id`,`slug`,`name`,`meta_title`,`meta_keywords`,`meta_description`,`description`,`content`,`sub_content`,`active`,`visible`,`hot`,`sort_order`,`status`,`type`,`create_time`,`update_time`,`publish_time`,`views`,`likes`,`comments`,`shares`) values (1,NULL,7,NULL,89,'m','Những chàng trai 30','','','','','hehe\r\nfđfdffd\r\n{img(69,,4,,title=anh nhớ em nhiều lắm,,data-caption=23x2=46)}\r\nhahaha','',NULL,NULL,NULL,'',NULL,NULL,NULL,1491158223,NULL,NULL,NULL,NULL,NULL),(3,NULL,NULL,NULL,NULL,'do','ffffffffffffff','','','','','v','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,NULL,NULL,NULL,'fff','anh yêu em Hường ah','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,NULL,NULL,NULL,NULL,'ff','anh nhớ em','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,NULL,NULL,NULL,NULL,'rrrrrrrrrrrrrrrrrrrrrf','Trà xanh Thái Nguyên và những lợi ích tuyệt vời cho sức khỏe','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,NULL,NULL,NULL,NULL,'ffffffffff','11 lợi ích tuyệt vời trà xanh Thái Nguyên mang lại cho sức khỏe','','','','','đ','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,NULL,NULL,NULL,NULL,'trrttr','Trà xanh Thái Nguyên và những lợi ích tuyệt vời cho sức khỏeff','','','','','f','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,NULL,NULL,NULL,NULL,'ê','dfd gjgkgkfj  rr','','','','','đ','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,NULL,NULL,NULL,NULL,'f','fđ  đfdffdfd','','','','','fff','f',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,NULL,NULL,NULL,NULL,'y','yyyyyyyyyyyyyyyyy ttt','','','','','y','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,NULL,NULL,NULL,NULL,'fffffff','fđffd dfdfđf','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,7,7,NULL,NULL,'gfgfgfgbvcvbvb','gfgfgfgbvcvbvb','','','','','fdfd','f',NULL,NULL,NULL,'',NULL,NULL,1490900118,1490900118,NULL,NULL,NULL,NULL,NULL),(15,7,7,NULL,NULL,'reererefdfdfdfdfd','rẻererefdfdfdfdfd','','','','','fdfdf','',1,NULL,NULL,'',NULL,NULL,1490900172,1491240364,NULL,NULL,NULL,NULL,NULL),(16,7,7,NULL,93,'75000-cap-nhat-de-xuat-mot-1bo-cong-cu-dichtrifdfdf','7/5000 Cập nhật Đề xuất một ~`!1@#$$%&&**/?:\"Bộ công cụ DịchTrìfđfđf','','','','','fdfđffdfđffđf\r\n{img(68,,2)}','',1,NULL,NULL,'',NULL,NULL,1490900247,1491240254,NULL,NULL,NULL,NULL,NULL),(17,7,7,NULL,69,'dhddffff-dfdfdfdfdfdf-43','dhddf%%$$^&&^/\"Fff_--dfdfdfdfdfdf ###$$#$#43','','','','','đ','',1,NULL,NULL,'',NULL,NULL,1490900474,1491240246,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `auth_assignment` */

DROP TABLE IF EXISTS `auth_assignment`;

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_assignment` */

insert  into `auth_assignment`(`item_name`,`user_id`,`created_at`) values ('admin','7',1490859591);

/*Table structure for table `auth_item` */

DROP TABLE IF EXISTS `auth_item`;

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item` */

insert  into `auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/*',2,NULL,NULL,NULL,1490858371,1490858371),('/admin/*',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/assignment/*',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/assignment/assign',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/assignment/index',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/assignment/revoke',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/assignment/view',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/default/*',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/default/index',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/menu/*',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/menu/create',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/menu/delete',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/menu/index',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/menu/update',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/menu/view',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/permission/*',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/permission/assign',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/permission/create',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/permission/delete',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/permission/index',2,NULL,NULL,NULL,1490858369,1490858369),('/admin/permission/remove',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/permission/update',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/permission/view',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/*',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/assign',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/create',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/delete',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/index',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/remove',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/update',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/role/view',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/route/*',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/route/assign',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/route/create',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/route/index',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/route/refresh',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/route/remove',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/rule/*',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/rule/create',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/rule/delete',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/rule/index',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/rule/update',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/rule/view',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/*',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/activate',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/change-password',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/delete',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/index',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/login',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/logout',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/reset-password',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/signup',2,NULL,NULL,NULL,1490858370,1490858370),('/admin/user/view',2,NULL,NULL,NULL,1490858370,1490858370),('/debug/*',2,NULL,NULL,NULL,1490858371,1490858371),('/debug/default/*',2,NULL,NULL,NULL,1490858371,1490858371),('/debug/default/db-explain',2,NULL,NULL,NULL,1490858370,1490858370),('/debug/default/download-mail',2,NULL,NULL,NULL,1490858371,1490858371),('/debug/default/index',2,NULL,NULL,NULL,1490858370,1490858370),('/debug/default/toolbar',2,NULL,NULL,NULL,1490858370,1490858370),('/debug/default/view',2,NULL,NULL,NULL,1490858370,1490858370),('/gii/*',2,NULL,NULL,NULL,1490858371,1490858371),('/gii/default/*',2,NULL,NULL,NULL,1490858371,1490858371),('/gii/default/action',2,NULL,NULL,NULL,1490858371,1490858371),('/gii/default/diff',2,NULL,NULL,NULL,1490858371,1490858371),('/gii/default/index',2,NULL,NULL,NULL,1490858371,1490858371),('/gii/default/preview',2,NULL,NULL,NULL,1490858371,1490858371),('/gii/default/view',2,NULL,NULL,NULL,1490858371,1490858371),('/site/*',2,NULL,NULL,NULL,1490858371,1490858371),('/site/error',2,NULL,NULL,NULL,1490858371,1490858371),('/site/index',2,NULL,NULL,NULL,1490858371,1490858371),('/site/login',2,NULL,NULL,NULL,1490858371,1490858371),('/site/logout',2,NULL,NULL,NULL,1490858371,1490858371),('admin',1,NULL,NULL,NULL,1490859534,1490859534);

/*Table structure for table `auth_item_child` */

DROP TABLE IF EXISTS `auth_item_child`;

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_item_child` */

insert  into `auth_item_child`(`parent`,`child`) values ('admin','/*');

/*Table structure for table `auth_rule` */

DROP TABLE IF EXISTS `auth_rule`;

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `auth_rule` */

/*Table structure for table `image` */

DROP TABLE IF EXISTS `image`;

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `file_basename` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_extension` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resize_labels` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `string_data` varchar(2048) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mime_type` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL,
  `shares` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_name` (`file_name`),
  UNIQUE KEY `file_basename` (`file_basename`),
  KEY `user_id` (`creator_id`),
  KEY `editor_id` (`updater_id`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `image_ibfk_2` FOREIGN KEY (`updater_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `image` */

insert  into `image`(`id`,`creator_id`,`updater_id`,`name`,`path`,`file_name`,`file_basename`,`file_extension`,`resize_labels`,`string_data`,`mime_type`,`sort_order`,`active`,`status`,`views`,`likes`,`comments`,`shares`,`create_time`,`update_time`) values (59,7,7,'dgggffgfffggggggggg44vvv','201703/nice-pc-wallpapers-014/','nice-pc-wallpapers-014.jpg','nice-pc-wallpapers-014','jpg','[]',NULL,'',NULL,1,NULL,NULL,NULL,NULL,NULL,1490990453,1491238167),(60,7,7,'fffgfgfgffgf','201703/','che-kho-thai-nguyen-ngon-6.jpg','che-kho-thai-nguyen-ngon-6','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490990890,1490990890),(61,7,7,'gggggggggggggggggg','201703/','bot tra xanh thai nguyen 9.jpg','bot tra xanh thai nguyen 9','jpg',NULL,NULL,'',NULL,0,NULL,NULL,NULL,NULL,NULL,1490990916,1490990916),(62,7,7,'gegegeg','201703/','tra-thai-nguyen-hao-hang.jpg','tra-thai-nguyen-hao-hang','jpg','[]',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490991082,1490991082),(63,7,7,'gegegeg 2','201703/','tra-thai-nguyen-hao-hang-2.jpg','tra-thai-nguyen-hao-hang-2','jpg','[]',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490991082,1490991082),(64,7,7,'haha','201703/','IMG_0217.jpg','IMG_0217','jpg',NULL,NULL,'',NULL,0,NULL,NULL,NULL,NULL,NULL,1490991216,1490991216),(65,7,7,'fdfdfdrere','201703/','vuon-che-lai-3.jpg','vuon-che-lai-3','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490991392,1490991392),(66,7,7,'d','201703/','tra-thai-nguyen-hao-hang-4.jpg','tra-thai-nguyen-hao-hang-4','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490991409,1490991409),(67,7,7,'người tôi yêu chi dân','201703/','che-kho-thai-nguyen-ngon.jpg','che-kho-thai-nguyen-ngon','jpg','{\"s1\":\"-50x37\",\"s2\":\"-100x75\",\"s3\":\"-150x112\",\"s4\":\"-200x150\",\"s5\":\"-250x187\",\"s6\":\"-300x225\",\"s7\":\"-350x262\",\"s8\":\"-400x300\",\"s9\":\"-450x337\",\"s10\":\"-500x375\",\"s11\":\"-200x150\",\"s12\":\"-800x600\",\"s13\":\"-1000x750\",\"s14\":\"-1151x863\",\"s15\":\"-1151x863\"}',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490991456,1490991456),(68,7,7,'vuon-che-lai-2','201703/','vuon-che-lai-2.jpg','vuon-che-lai-2','jpg','[]',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490991717,1490991717),(69,7,7,'fdfđfdfdddddddđfff','201703/fdfdfdfddddddddfff/','fdfdfdfddddddddfff.jpg','fdfdfdfddddddddfff','jpg','{\"1\":\"-50x37\",\"2\":\"-100x75\",\"3\":\"-200x150\",\"5\":\"-300x225\",\"6\":\"-350x262\",\"7\":\"-400x300\",\"8\":\"-450x337\",\"9\":\"-500x375\",\"10\":\"-200x150\",\"11\":\"-800x600\",\"12\":\"-1000x750\",\"13\":\"-1151x863\",\"14\":\"-1151x863\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490991746,1491158284),(70,7,7,'xin lỗi tình yêu','201703/IMG_0151/','IMG_0151.jpg','IMG_0151','jpg','[]',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490991877,1491238419),(71,7,7,'xin lỗi em','201703/','vuon-che-lai.jpg','vuon-che-lai','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490991913,1490991913),(72,7,7,'tôi yêu em','201703/','IMG_0037.jpg','IMG_0037','jpg','{\"s1\":\"-50x37\",\"s2\":\"-100x75\",\"s3\":\"-150x112\",\"s4\":\"-200x150\",\"s5\":\"-250x187\",\"s6\":\"-300x225\",\"s7\":\"-350x262\",\"s8\":\"-400x300\",\"s9\":\"-450x337\",\"s10\":\"-500x375\",\"s11\":\"-200x150\",\"s12\":\"-800x600\",\"s13\":\"-1000x750\",\"s14\":\"-1151x863\",\"s15\":\"-1151x863\"}',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490992075,1490992075),(73,7,7,'tôi yêu em rất nhiều','201703/','IMG_0201.jpg','IMG_0201','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490992388,1490992388),(74,7,7,'tôi yêu em rất nhiều haha','201703/','toi-yeu-em-rat-nhieu-haha.jpg','toi-yeu-em-rat-nhieu-haha','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490992402,1490992402),(75,7,7,'ffffffffffffffffffffffffffffffffffffffffffffffff','201703/','ffffffffffffffffffffffffffffffffffffffffffffffff.jpg','ffffffffffffffffffffffffffffffffffffffffffffffff','jpg','{\"s2\":\"-100x75\",\"s3\":\"-150x113\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490992797,1490992797),(76,7,7,'ffffffffffffffffffffffffffffffffffffffffffffffff 2','201703/','ffffffffffffffffffffffffffffffffffffffffffffffff-2.jpg','ffffffffffffffffffffffffffffffffffffffffffffffff-2','jpg','{\"s2\":\"-100x75\",\"s3\":\"-150x113\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490992797,1490992797),(77,7,7,'ffffffffffffffffffffffffffffffffffffffffffffffff 3','201703/','ffffffffffffffffffffffffffffffffffffffffffffffff-3.jpg','ffffffffffffffffffffffffffffffffffffffffffffffff-3','jpg','{\"s2\":\"-100x75\",\"s3\":\"-150x113\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490992798,1490992798),(78,7,7,'này  em yêu    ơi ố ồ','201703/','IMG_4045.jpg','IMG_4045','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490992862,1490994226),(79,7,7,'này bạn ởi ơi   hf hfd&^%%$','201703/','nay-ban-oi-oi-hf-hfd.jpg','nay-ban-oi-oi-hf-hfd','jpg','{\"s1\":\"-50x37\",\"s2\":\"-100x75\",\"s3\":\"-150x112\"}',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490992917,1490992917),(80,7,7,'này bạn','201703/nay-ban/','nay-ban.jpg','nay-ban','jpg','{\"1\":\"-50x37\",\"2\":\"-100x75\",\"3\":\"-200x150\",\"4\":\"-250x187\",\"5\":\"-300x225\",\"6\":\"-350x262\",\"7\":\"-400x300\",\"8\":\"-450x337\",\"9\":\"-500x375\",\"10\":\"-200x150\",\"11\":\"-800x600\",\"12\":\"-1000x750\",\"13\":\"-1151x863\",\"14\":\"-1151x863\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490992962,1491151946),(81,7,7,'ffffffffffffffffffffffffv','201703/','ffffffffffffffffffffffffv.jpg','ffffffffffffffffffffffffv','jpg','{\"s2\":\"-100x75\",\"s4\":\"-200x150\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490993127,1490993711),(82,7,7,'ảnh của tôi','201703/','IMG_4040.jpg','IMG_4040','jpg',NULL,NULL,'',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994396,1490994396),(83,7,7,'gggg','201703/','bot TN.jpg','bot TN','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994457,1490994472),(84,7,7,'ff','201703/','bot tra xanh thai nguyen 4.gif','bot tra xanh thai nguyen 4','gif','{\"s1\":\"-38x50\"}',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994530,1490994557),(85,7,7,'r','201703/','bot tra xanh thai nguyen.jpg','bot tra xanh thai nguyen','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994669,1490994669),(86,7,7,'BTH','201703/','bth.jpg','bth','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994719,1490994719),(87,7,7,'Q','201703/','.jpg',NULL,'jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994793,1490994793),(88,7,7,'dgggff','201703/','dgggff.jpg','dgggff','jpg','{\"s2\":\"-100x75\",\"s3\":\"-150x113\"}',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1490994895,1490995194),(89,7,7,'lá bay','201704/124950a9190b86663c4e258f8509a759/','124950a9190b86663c4e258f8509a759.jpg','124950a9190b86663c4e258f8509a759','jpg','{\"1\":\"-50x14\",\"2\":\"-100x29\",\"3\":\"-200x57\",\"4\":\"-250x71\",\"5\":\"-300x86\",\"6\":\"-350x100\",\"7\":\"-400x114\",\"8\":\"-450x129\",\"9\":\"-500x143\",\"10\":\"-200x57\",\"11\":\"-800x229\",\"12\":\"-1000x286\",\"13\":\"-1200x343\",\"14\":\"-1400x400\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1491113644,1491235367),(90,7,7,'xxxxxxx','201704/xxxxxxx/','xxxxxxx.jpg','xxxxxxx','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1491117653,1491117653),(91,7,7,'em yêu anh không??','201704/6b4b14ef187157dbd434cbd4de9f04b3/','6b4b14ef187157dbd434cbd4de9f04b3.jpg','6b4b14ef187157dbd434cbd4de9f04b3','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1491127392,1491127392),(92,7,7,'hahaha','201704/hahaha/','hahaha.jpg','hahaha','jpg','[]',NULL,'image/jpeg',NULL,0,NULL,NULL,NULL,NULL,NULL,1491127823,1491127859),(93,7,7,'gegege','201704/gegege/','gegege.jpg','gegege','jpg','{\"1\":\"-50x28\",\"2\":\"-100x56\",\"3\":\"-200x113\",\"4\":\"-250x141\",\"5\":\"-300x169\",\"6\":\"-350x197\",\"7\":\"-400x225\",\"8\":\"-450x253\",\"9\":\"-500x281\",\"10\":\"-200x113\",\"11\":\"-800x450\",\"12\":\"-1000x563\",\"13\":\"-1200x675\",\"14\":\"-1400x788\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1491127899,1491235591);

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `menu` */

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1490843601),('m140506_102106_rbac_init',1490846580),('m140602_111327_create_menu_table',1490843604),('m160312_050000_create_user',1490843605);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `type` smallint(6) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`activation_token`,`email`,`status`,`type`,`create_time`,`update_time`) values (7,'quyettvq','BvJ7KUKELd2mbyPKsuGWLDw9IB3Nsl2_','$2y$13$4szP5PIJivf4XOUnhQKybOPS4SKt1r9lvWZcSN.x9j2joe4RrFy/e',NULL,NULL,'quyettvq@gmail.com',10,10,1490858092,1490868300),(8,'vanquyet','txpW5Z_wmqwvQmOLD_uvEfH2MmzZaOvS','$2y$13$88428ERrHXnv4O3h2vjb2.PQ/NeZ39DGG.1m3NydqE3DjYfmQmFTK',NULL,NULL,'vanquyet@gmail.com',5,0,1491316044,1491324244);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
