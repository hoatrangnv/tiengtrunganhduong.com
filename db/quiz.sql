/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.14 : Database - quiz
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `quiz`;

/*Table structure for table `quiz` */

DROP TABLE IF EXISTS `quiz`;

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `doindex` tinyint(1) DEFAULT NULL,
  `dofollow` tinyint(1) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `publish_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz` */

/*Table structure for table `quiz_answer` */

DROP TABLE IF EXISTS `quiz_answer`;

CREATE TABLE `quiz_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `content` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_answer` */

/*Table structure for table `quiz_caption` */

DROP TABLE IF EXISTS `quiz_caption`;

CREATE TABLE `quiz_caption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_caption` */

/*Table structure for table `quiz_condition` */

DROP TABLE IF EXISTS `quiz_condition`;

CREATE TABLE `quiz_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `min_answers_score` int(11) DEFAULT NULL,
  `max_answers_score` int(11) DEFAULT NULL,
  `player_gender` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_condition` */

/*Table structure for table `quiz_figure` */

DROP TABLE IF EXISTS `quiz_figure`;

CREATE TABLE `quiz_figure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_figure` */

/*Table structure for table `quiz_question` */

DROP TABLE IF EXISTS `quiz_question`;

CREATE TABLE `quiz_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `content` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `multiple_choice` tinyint(1) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_question` */

/*Table structure for table `quiz_result` */

DROP TABLE IF EXISTS `quiz_result`;

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `condition_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result` */

/*Table structure for table `quiz_result_selection` */

DROP TABLE IF EXISTS `quiz_result_selection`;

CREATE TABLE `quiz_result_selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer_id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result_selection` */

/*Table structure for table `quiz_style` */

DROP TABLE IF EXISTS `quiz_style`;

CREATE TABLE `quiz_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `top` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `left` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font_family` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font_weight` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font_size` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font_style` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line_height` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_color` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_width` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_height` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `width` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `height` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transform` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_transform` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `z_index` int(11) DEFAULT NULL,
  `opacity` int(11) DEFAULT NULL,
  `text_align` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_stroke_color` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_stoke_width` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `padding` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `border_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `border_width` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `border_radius` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_style` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
