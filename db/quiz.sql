/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.26 : Database - quiz
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`quiz` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

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
  `audio_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `quiz_answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `quiz_question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_answer` */

/*Table structure for table `quiz_caption` */

DROP TABLE IF EXISTS `quiz_caption`;

CREATE TABLE `quiz_caption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `filter_id` (`filter_id`),
  CONSTRAINT `quiz_caption_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_caption_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_caption` */

/*Table structure for table `quiz_caption_to_style` */

DROP TABLE IF EXISTS `quiz_caption_to_style`;

CREATE TABLE `quiz_caption_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `style_index` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `caption_id` (`caption_id`,`style_id`),
  KEY `style_id` (`style_id`),
  CONSTRAINT `quiz_caption_to_style_ibfk_1` FOREIGN KEY (`caption_id`) REFERENCES `quiz_caption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_caption_to_style_ibfk_2` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_caption_to_style` */

/*Table structure for table `quiz_character` */

DROP TABLE IF EXISTS `quiz_character`;

CREATE TABLE `quiz_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type_index` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filter_id` (`filter_id`),
  KEY `quiz_character_ibfk_1` (`quiz_id`),
  CONSTRAINT `quiz_character_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_character_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_character` */

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

/*Table structure for table `quiz_filter` */

DROP TABLE IF EXISTS `quiz_filter`;

CREATE TABLE `quiz_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `condition` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_filter_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_filter` */

/*Table structure for table `quiz_photo` */

DROP TABLE IF EXISTS `quiz_photo`;

CREATE TABLE `quiz_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type_index` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `filter_id` (`filter_id`),
  CONSTRAINT `quiz_photo_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_photo_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_photo` */

/*Table structure for table `quiz_photo_to_character` */

DROP TABLE IF EXISTS `quiz_photo_to_character`;

CREATE TABLE `quiz_photo_to_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `character_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_id` (`photo_id`),
  KEY `character_id` (`character_id`),
  CONSTRAINT `quiz_photo_to_character_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `quiz_photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_photo_to_character_ibfk_2` FOREIGN KEY (`character_id`) REFERENCES `quiz_character` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_photo_to_character` */

/*Table structure for table `quiz_photo_to_stype` */

DROP TABLE IF EXISTS `quiz_photo_to_stype`;

CREATE TABLE `quiz_photo_to_stype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `style_index` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `photo_id` (`photo_id`,`style_id`),
  KEY `style_id` (`style_id`),
  CONSTRAINT `quiz_photo_to_stype_ibfk_1` FOREIGN KEY (`photo_id`) REFERENCES `quiz_photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_photo_to_stype_ibfk_2` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_photo_to_stype` */

/*Table structure for table `quiz_question` */

DROP TABLE IF EXISTS `quiz_question`;

CREATE TABLE `quiz_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `audio_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `multiple_choice` tinyint(1) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_question` */

/*Table structure for table `quiz_random_param` */

DROP TABLE IF EXISTS `quiz_random_param`;

CREATE TABLE `quiz_random_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_random_param_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_random_param` */

/*Table structure for table `quiz_random_value` */

DROP TABLE IF EXISTS `quiz_random_value`;

CREATE TABLE `quiz_random_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `param_id` (`param_id`),
  CONSTRAINT `quiz_random_value_ibfk_1` FOREIGN KEY (`param_id`) REFERENCES `quiz_random_param` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_random_value` */

/*Table structure for table `quiz_result` */

DROP TABLE IF EXISTS `quiz_result`;

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `audio_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `filter_id` (`filter_id`),
  CONSTRAINT `quiz_result_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_result_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result` */

/*Table structure for table `quiz_result_selection` */

DROP TABLE IF EXISTS `quiz_result_selection`;

CREATE TABLE `quiz_result_selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answer_id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answer_id` (`answer_id`),
  KEY `result_id` (`result_id`),
  CONSTRAINT `quiz_result_selection_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `quiz_answer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_result_selection_ibfk_2` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result_selection` */

/*Table structure for table `quiz_result_to_caption` */

DROP TABLE IF EXISTS `quiz_result_to_caption`;

CREATE TABLE `quiz_result_to_caption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `caption_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `result_id` (`result_id`),
  KEY `caption_id` (`caption_id`),
  CONSTRAINT `quiz_result_to_caption_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_result_to_caption_ibfk_2` FOREIGN KEY (`caption_id`) REFERENCES `quiz_caption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result_to_caption` */

/*Table structure for table `quiz_result_to_caption_to_style` */

DROP TABLE IF EXISTS `quiz_result_to_caption_to_style`;

CREATE TABLE `quiz_result_to_caption_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_to_caption_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `style_index` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `result_to_caption_id` (`result_to_caption_id`),
  KEY `style_id` (`style_id`),
  CONSTRAINT `quiz_result_to_caption_to_style_ibfk_1` FOREIGN KEY (`result_to_caption_id`) REFERENCES `quiz_result_to_caption` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_result_to_caption_to_style_ibfk_2` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result_to_caption_to_style` */

/*Table structure for table `quiz_result_to_photo` */

DROP TABLE IF EXISTS `quiz_result_to_photo`;

CREATE TABLE `quiz_result_to_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `photo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `result_id` (`result_id`),
  KEY `photo_id` (`photo_id`),
  CONSTRAINT `quiz_result_to_photo_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_result_to_photo_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `quiz_photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result_to_photo` */

/*Table structure for table `quiz_result_to_photo_to_style` */

DROP TABLE IF EXISTS `quiz_result_to_photo_to_style`;

CREATE TABLE `quiz_result_to_photo_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_to_photo_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `style_index` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `style_id` (`style_id`),
  KEY `result_to_photo_id` (`result_to_photo_id`),
  CONSTRAINT `quiz_result_to_photo_to_style_ibfk_1` FOREIGN KEY (`result_to_photo_id`) REFERENCES `quiz_result_to_photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `quiz_result_to_photo_to_style_ibfk_2` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_result_to_photo_to_style` */

/*Table structure for table `quiz_style` */

DROP TABLE IF EXISTS `quiz_style`;

CREATE TABLE `quiz_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  CONSTRAINT `quiz_style_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `quiz_style` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
