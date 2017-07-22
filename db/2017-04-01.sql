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

insert  into `article`(`id`,`creator_id`,`updater_id`,`category_id`,`image_id`,`slug`,`name`,`meta_title`,`meta_keywords`,`meta_description`,`description`,`content`,`sub_content`,`active`,`visible`,`hot`,`sort_order`,`status`,`type`,`create_time`,`update_time`,`publish_time`,`views`,`likes`,`comments`,`shares`) values (1,NULL,7,NULL,NULL,'m','Những chàng trai 30','','','','','hehe\r\nfđfdffd','',NULL,NULL,NULL,'',NULL,NULL,NULL,1490900932,NULL,NULL,NULL,NULL,NULL),(2,NULL,NULL,NULL,NULL,'d','ffffffffffffff','','','','','v','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,NULL,NULL,NULL,NULL,'do','ffffffffffffff','','','','','v','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,NULL,NULL,NULL,'fff','anh yêu em Hường ah','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,NULL,NULL,NULL,NULL,'ff','anh nhớ em','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,NULL,NULL,NULL,NULL,'ffđ','nguyễn nam anh','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,NULL,NULL,NULL,NULL,'rrrrrrrrrrrrrrrrrrrrrf','Trà xanh Thái Nguyên và những lợi ích tuyệt vời cho sức khỏe','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,NULL,NULL,NULL,NULL,'ffffffffff','11 lợi ích tuyệt vời trà xanh Thái Nguyên mang lại cho sức khỏe','','','','','đ','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,NULL,NULL,NULL,NULL,'trrttr','Trà xanh Thái Nguyên và những lợi ích tuyệt vời cho sức khỏeff','','','','','f','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,NULL,NULL,NULL,NULL,'ê','dfd gjgkgkfj  rr','','','','','đ','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,NULL,NULL,NULL,NULL,'f','fđ  đfdffdfd','','','','','fff','f',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,NULL,NULL,NULL,NULL,'y','yyyyyyyyyyyyyyyyy ttt','','','','','y','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,NULL,NULL,NULL,NULL,'fffffff','fđffd dfdfđf','','','','','ff','',NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,7,7,NULL,NULL,'gfgfgfgbvcvbvb','gfgfgfgbvcvbvb','','','','','fdfd','f',NULL,NULL,NULL,'',NULL,NULL,1490900118,1490900118,NULL,NULL,NULL,NULL,NULL),(15,7,7,NULL,NULL,'reererefdfdfdfdfd','rẻererefdfdfdfdfd','','','','','fdfdf','',NULL,NULL,NULL,'',NULL,NULL,1490900172,1490900172,NULL,NULL,NULL,NULL,NULL),(16,7,7,NULL,NULL,'75000-cap-nhat-de-xuat-mot-1bo-cong-cu-dichtrifdfdf','7/5000 Cập nhật Đề xuất một ~`!1@#$$%&&**/?:\"Bộ công cụ DịchTrìfđfđf','','','','','fdfđffdfđffđf','',NULL,NULL,NULL,'',NULL,NULL,1490900247,1490901031,NULL,NULL,NULL,NULL,NULL),(17,7,7,NULL,NULL,'dhddffff-dfdfdfdfdfdf-43','dhddf%%$$^&&^/\"Fff_--dfdfdfdfdfdf ###$$#$#43','','','','','đ','',NULL,NULL,NULL,'',NULL,NULL,1490900474,1490900489,NULL,NULL,NULL,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `image` */

insert  into `image`(`id`,`creator_id`,`updater_id`,`name`,`path`,`file_name`,`file_basename`,`file_extension`,`resize_labels`,`string_data`,`mime_type`,`sort_order`,`active`,`status`,`views`,`likes`,`comments`,`shares`,`create_time`,`update_time`) values (56,7,7,'Ảnh của tôi tôi thích','201703/','anh-cua-toi-toi-thich.jpg','anh-cua-toi-toi-thich','jpg','{\"s2\":\"-100x63\",\"s3\":\"-150x94\",\"s4\":\"-200x125\",\"s5\":\"-250x156\",\"s6\":\"-300x188\",\"s7\":\"-350x219\",\"s8\":\"-400x250\",\"s9\":\"-450x281\",\"s10\":\"-500x313\",\"s11\":\"-200x125\",\"s12\":\"-800x500\",\"s13\":\"-1000x625\",\"s14\":\"-1200x750\"}',NULL,'image/jpeg',NULL,1,NULL,NULL,NULL,NULL,NULL,1490986799,1490987048);

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
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (7,'quyettvq','BvJ7KUKELd2mbyPKsuGWLDw9IB3Nsl2_','$2y$13$4szP5PIJivf4XOUnhQKybOPS4SKt1r9lvWZcSN.x9j2joe4RrFy/e',NULL,'quyettvq@gmail.com',10,1490858092,1490868300);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
