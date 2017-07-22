/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.14 : Database - tiengtrunganhduong_com
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tiengtrunganhduong_com` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `tiengtrunganhduong_com`;

/*Table structure for table `quiz` */

DROP TABLE IF EXISTS `quiz`;

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `visible` int(11) DEFAULT NULL,
  `doindex` int(11) DEFAULT NULL,
  `dofollow` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `publish_time` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `updater_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx-quiz-creator_id` (`creator_id`),
  KEY `idx-quiz-updater_id` (`updater_id`),
  KEY `idx-quiz-image_id` (`image_id`),
  KEY `idx-quiz-category_id` (`category_id`),
  CONSTRAINT `fk-quiz-category_id` FOREIGN KEY (`category_id`) REFERENCES `quiz_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz-creator_id` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz-image_id` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz-updater_id` FOREIGN KEY (`updater_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_category` */

DROP TABLE IF EXISTS `quiz_category`;

CREATE TABLE `quiz_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `visible` int(11) DEFAULT NULL,
  `doindex` int(11) DEFAULT NULL,
  `dofollow` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `creator_id` int(11) NOT NULL,
  `updater_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx-quiz_category-creator_id` (`creator_id`),
  KEY `idx-quiz_category-updater_id` (`updater_id`),
  KEY `idx-quiz_category-image_id` (`image_id`),
  KEY `idx-quiz_category-parent_id` (`parent_id`),
  CONSTRAINT `fk-quiz_category-creator_id` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_category-image_id` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_category-parent_id` FOREIGN KEY (`parent_id`) REFERENCES `quiz_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_category-updater_id` FOREIGN KEY (`updater_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character` */

DROP TABLE IF EXISTS `quiz_character`;

CREATE TABLE `quiz_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `var_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `index` int(11) NOT NULL,
  `global_exec_order` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_character-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character_medium` */

DROP TABLE IF EXISTS `quiz_character_medium`;

CREATE TABLE `quiz_character_medium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `var_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `index` int(11) NOT NULL,
  `global_exec_order` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `character_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character_medium-quiz_id` (`quiz_id`),
  KEY `idx-quiz_character_medium-character_id` (`character_id`),
  CONSTRAINT `fk-quiz_character_medium-character_id` FOREIGN KEY (`character_id`) REFERENCES `quiz_character` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_character_medium-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character_medium_to_filter` */

DROP TABLE IF EXISTS `quiz_character_medium_to_filter`;

CREATE TABLE `quiz_character_medium_to_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_medium_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character_medium_to_filter-character_medium_id` (`character_medium_id`),
  KEY `idx-quiz_character_medium_to_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_character_medium_to_filter-character_medium_id` FOREIGN KEY (`character_medium_id`) REFERENCES `quiz_character_medium` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_character_medium_to_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character_medium_to_sorter` */

DROP TABLE IF EXISTS `quiz_character_medium_to_sorter`;

CREATE TABLE `quiz_character_medium_to_sorter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sorter_order` int(11) DEFAULT NULL,
  `character_medium_id` int(11) NOT NULL,
  `sorter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character_medium_to_sorter-character_medium_id` (`character_medium_id`),
  KEY `idx-quiz_character_medium_to_sorter-sorter_id` (`sorter_id`),
  CONSTRAINT `fk-quiz_character_medium_to_sorter-character_medium_id` FOREIGN KEY (`character_medium_id`) REFERENCES `quiz_character_medium` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_character_medium_to_sorter-sorter_id` FOREIGN KEY (`sorter_id`) REFERENCES `quiz_sorter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character_medium_to_style` */

DROP TABLE IF EXISTS `quiz_character_medium_to_style`;

CREATE TABLE `quiz_character_medium_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_order` int(11) DEFAULT NULL,
  `character_medium_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character_medium_to_style-character_medium_id` (`character_medium_id`),
  KEY `idx-quiz_character_medium_to_style-style_id` (`style_id`),
  CONSTRAINT `fk-quiz_character_medium_to_style-character_medium_id` FOREIGN KEY (`character_medium_id`) REFERENCES `quiz_character_medium` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_character_medium_to_style-style_id` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character_to_filter` */

DROP TABLE IF EXISTS `quiz_character_to_filter`;

CREATE TABLE `quiz_character_to_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character_to_filter-character_id` (`character_id`),
  KEY `idx-quiz_character_to_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_character_to_filter-character_id` FOREIGN KEY (`character_id`) REFERENCES `quiz_character` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_character_to_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_character_to_sorter` */

DROP TABLE IF EXISTS `quiz_character_to_sorter`;

CREATE TABLE `quiz_character_to_sorter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sorter_order` int(11) DEFAULT NULL,
  `character_id` int(11) NOT NULL,
  `sorter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_character_to_sorter-character_id` (`character_id`),
  KEY `idx-quiz_character_to_sorter-sorter_id` (`sorter_id`),
  CONSTRAINT `fk-quiz_character_to_sorter-character_id` FOREIGN KEY (`character_id`) REFERENCES `quiz_character` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_character_to_sorter-sorter_id` FOREIGN KEY (`sorter_id`) REFERENCES `quiz_sorter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_filter` */

DROP TABLE IF EXISTS `quiz_filter`;

CREATE TABLE `quiz_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `condition` text COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_filter-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_filter-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input` */

DROP TABLE IF EXISTS `quiz_input`;

CREATE TABLE `quiz_input` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `var_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `question` text COLLATE utf8_unicode_ci,
  `hint` text COLLATE utf8_unicode_ci,
  `row` int(11) DEFAULT NULL,
  `column` int(11) DEFAULT NULL,
  `input_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input-input_group_id` (`input_group_id`),
  CONSTRAINT `fk-quiz_input-input_group_id` FOREIGN KEY (`input_group_id`) REFERENCES `quiz_input_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input_group` */

DROP TABLE IF EXISTS `quiz_input_group`;

CREATE TABLE `quiz_input_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `global_exec_order` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input_group-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_input_group-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input_group_to_input_filter` */

DROP TABLE IF EXISTS `quiz_input_group_to_input_filter`;

CREATE TABLE `quiz_input_group_to_input_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input_group_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input_group_to_input_filter-input_group_id` (`input_group_id`),
  KEY `idx-quiz_input_group_to_input_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_input_group_to_input_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_input_group_to_input_filter-input_group_id` FOREIGN KEY (`input_group_id`) REFERENCES `quiz_input_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input_option` */

DROP TABLE IF EXISTS `quiz_input_option`;

CREATE TABLE `quiz_input_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `score` int(11) DEFAULT NULL,
  `interpretation` text COLLATE utf8_unicode_ci,
  `row` int(11) DEFAULT NULL,
  `column` int(11) DEFAULT NULL,
  `input_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input_option-input_id` (`input_id`),
  CONSTRAINT `fk-quiz_input_option-input_id` FOREIGN KEY (`input_id`) REFERENCES `quiz_input` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input_option_to_result_poll` */

DROP TABLE IF EXISTS `quiz_input_option_to_result_poll`;

CREATE TABLE `quiz_input_option_to_result_poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `votes` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `input_option_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input_option_to_result_poll-result_id` (`result_id`),
  KEY `idx-quiz_input_option_to_result_poll-input_option_id` (`input_option_id`),
  CONSTRAINT `fk-quiz_input_option_to_result_poll-input_option_id` FOREIGN KEY (`input_option_id`) REFERENCES `quiz_input_option` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_input_option_to_result_poll-result_id` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input_to_input_option_filter` */

DROP TABLE IF EXISTS `quiz_input_to_input_option_filter`;

CREATE TABLE `quiz_input_to_input_option_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input_to_input_option_filter-input_id` (`input_id`),
  KEY `idx-quiz_input_to_input_option_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_input_to_input_option_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_input_to_input_option_filter-input_id` FOREIGN KEY (`input_id`) REFERENCES `quiz_input` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_input_to_validator` */

DROP TABLE IF EXISTS `quiz_input_to_validator`;

CREATE TABLE `quiz_input_to_validator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `input_id` int(11) NOT NULL,
  `validator_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_input_to_validator-input_id` (`input_id`),
  KEY `idx-quiz_input_to_validator-validator_id` (`validator_id`),
  CONSTRAINT `fk-quiz_input_to_validator-input_id` FOREIGN KEY (`input_id`) REFERENCES `quiz_input` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_input_to_validator-validator_id` FOREIGN KEY (`validator_id`) REFERENCES `quiz_validator` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_param` */

DROP TABLE IF EXISTS `quiz_param`;

CREATE TABLE `quiz_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `var_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `global_exec_order` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_param-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_param-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result` */

DROP TABLE IF EXISTS `quiz_result`;

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(511) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `priority` int(11) DEFAULT NULL,
  `canvas_width` int(11) DEFAULT NULL,
  `canvas_height` int(11) DEFAULT NULL,
  `quiz_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_result-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result_to_character_medium` */

DROP TABLE IF EXISTS `quiz_result_to_character_medium`;

CREATE TABLE `quiz_result_to_character_medium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `character_medium_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result_to_character_medium-result_id` (`result_id`),
  KEY `idx-quiz_result_to_character_medium-character_medium_id` (`character_medium_id`),
  CONSTRAINT `fk-quiz_result_to_character_medium-character_medium_id` FOREIGN KEY (`character_medium_id`) REFERENCES `quiz_character_medium` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_result_to_character_medium-result_id` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result_to_character_medium_filter` */

DROP TABLE IF EXISTS `quiz_result_to_character_medium_filter`;

CREATE TABLE `quiz_result_to_character_medium_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result_to_character_medium_filter-result_id` (`result_id`),
  KEY `idx-quiz_result_to_character_medium_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_result_to_character_medium_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_result_to_character_medium_filter-result_id` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result_to_character_medium_to_style` */

DROP TABLE IF EXISTS `quiz_result_to_character_medium_to_style`;

CREATE TABLE `quiz_result_to_character_medium_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_order` int(11) DEFAULT NULL,
  `result_to_character_medium_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result_to_chr_md_to_style-result_to_chr_md_id` (`result_to_character_medium_id`),
  KEY `idx-quiz_result_to_character_medium_to_style-style_id` (`style_id`),
  CONSTRAINT `fk-quiz_result_to_character_medium_to_style-style_id` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_result_to_chr_md_to_style-result_to_chr_md_id` FOREIGN KEY (`result_to_character_medium_id`) REFERENCES `quiz_result_to_shape` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result_to_shape` */

DROP TABLE IF EXISTS `quiz_result_to_shape`;

CREATE TABLE `quiz_result_to_shape` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `shape_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result_to_shape-result_id` (`result_id`),
  KEY `idx-quiz_result_to_shape-shape_id` (`shape_id`),
  CONSTRAINT `fk-quiz_result_to_shape-result_id` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_result_to_shape-shape_id` FOREIGN KEY (`shape_id`) REFERENCES `quiz_shape` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result_to_shape_filter` */

DROP TABLE IF EXISTS `quiz_result_to_shape_filter`;

CREATE TABLE `quiz_result_to_shape_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result_to_shape_filter-result_id` (`result_id`),
  KEY `idx-quiz_result_to_shape_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_result_to_shape_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_result_to_shape_filter-result_id` FOREIGN KEY (`result_id`) REFERENCES `quiz_result` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_result_to_shape_to_style` */

DROP TABLE IF EXISTS `quiz_result_to_shape_to_style`;

CREATE TABLE `quiz_result_to_shape_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_order` int(11) DEFAULT NULL,
  `result_to_shape_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_result_to_shape_to_style-result_to_shape_id` (`result_to_shape_id`),
  KEY `idx-quiz_result_to_shape_to_style-style_id` (`style_id`),
  CONSTRAINT `fk-quiz_result_to_shape_to_style-result_to_shape_id` FOREIGN KEY (`result_to_shape_id`) REFERENCES `quiz_result_to_shape` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_result_to_shape_to_style-style_id` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_shape` */

DROP TABLE IF EXISTS `quiz_shape`;

CREATE TABLE `quiz_shape` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_shape-image_id` (`image_id`),
  KEY `idx-quiz_shape-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_shape-image_id` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_shape-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_shape_to_style` */

DROP TABLE IF EXISTS `quiz_shape_to_style`;

CREATE TABLE `quiz_shape_to_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_order` int(11) DEFAULT NULL,
  `shape_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_shape_to_style-shape_id` (`shape_id`),
  KEY `idx-quiz_shape_to_style-style_id` (`style_id`),
  CONSTRAINT `fk-quiz_shape_to_style-shape_id` FOREIGN KEY (`shape_id`) REFERENCES `quiz_shape` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_shape_to_style-style_id` FOREIGN KEY (`style_id`) REFERENCES `quiz_style` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_sorter` */

DROP TABLE IF EXISTS `quiz_sorter`;

CREATE TABLE `quiz_sorter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rule` text COLLATE utf8_unicode_ci,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_sorter-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_sorter-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_style` */

DROP TABLE IF EXISTS `quiz_style`;

CREATE TABLE `quiz_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `z_index` int(11) NOT NULL,
  `opacity` int(11) NOT NULL,
  `top` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `left` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `width` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `height` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_width` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_height` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `padding` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `border_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `border_width` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `border_radius` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `font` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line_height` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_align` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_stroke_color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text_stroke_width` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_style-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_style-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_to_character_filter` */

DROP TABLE IF EXISTS `quiz_to_character_filter`;

CREATE TABLE `quiz_to_character_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_to_character_filter-quiz_id` (`quiz_id`),
  KEY `idx-quiz_to_character_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_to_character_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_to_character_filter-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_to_input_group_filter` */

DROP TABLE IF EXISTS `quiz_to_input_group_filter`;

CREATE TABLE `quiz_to_input_group_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_to_input_group_filter-quiz_id` (`quiz_id`),
  KEY `idx-quiz_to_input_group_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_to_input_group_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_to_input_group_filter-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_to_result_filter` */

DROP TABLE IF EXISTS `quiz_to_result_filter`;

CREATE TABLE `quiz_to_result_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_to_result_filter-quiz_id` (`quiz_id`),
  KEY `idx-quiz_to_result_filter-filter_id` (`filter_id`),
  CONSTRAINT `fk-quiz_to_result_filter-filter_id` FOREIGN KEY (`filter_id`) REFERENCES `quiz_filter` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-quiz_to_result_filter-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `quiz_validator` */

DROP TABLE IF EXISTS `quiz_validator`;

CREATE TABLE `quiz_validator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `validation` text COLLATE utf8_unicode_ci NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-quiz_validator-quiz_id` (`quiz_id`),
  CONSTRAINT `fk-quiz_validator-quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
