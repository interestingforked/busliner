/*
SQLyog Ultimate v8.6 Beta2
MySQL - 5.1.40-community : Database - busliner
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `blocks` */

DROP TABLE IF EXISTS `blocks`;

CREATE TABLE `blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `type` varchar(20) NOT NULL,
  `plugin` varchar(32) DEFAULT NULL,
  `position` int(5) NOT NULL,
  `show_title` tinyint(1) DEFAULT '1',
  `title` varchar(32) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `blocks` */

insert  into `blocks`(`id`,`language_id`,`active`,`type`,`plugin`,`position`,`show_title`,`title`,`content`) values (1,3,1,'main_center','',1,0,'Mission statement','<h2 class=\"intro\">Mission statement</h2>\n<p>Mozilla\'s mission is to promote openness, innovation,  	  and opportunity on the web. We do this by creating  	  great software, like the Firefox browser, and building movements, like Drumbeat, that give people tools to take control of their online lives.</p>\n<p>As a non-profit organization, we define success in terms of building communities and enriching people&rsquo;s  	  lives instead of benefiting our shareholders (guess what: we don&rsquo;t even have shareholders). We believe  	  in the power and potential of the Internet and want to see it thrive for everyone, everywhere.</p>'),(2,3,1,'main_bottom','',2,0,'Our coaches','<h2 class=\"first_buses\">Our coaches</h2>\n<div id=\"f_coaches\"><em></em>some description here</div>\n<div id=\"f_coaches\"><em></em>some description here<br />more description<br />more description</div>'),(7,0,1,'page_right','',0,0,'Sidebar','<p>Здесь дополнительный блок, редактируемый из админки, типа сайдбар страницы</p>'),(8,3,1,'main_top','',0,0,'Request your quote','<div class=\"right_col\">\n<div id=\"phone\"><em>&nbsp;</em>1&nbsp;(425)&nbsp;346&nbsp;5332</div>\n<div id=\"quote\"><a href=\"#\">Request your quote</a></div>\n</div>');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT '0',
  `show` tinyint(1) DEFAULT '0',
  `slug` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rss_link` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug - unique` (`slug`),
  UNIQUE KEY `title - unique` (`title`),
  KEY `slug - normal` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) NOT NULL,
  `module_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `email` varchar(127) NOT NULL,
  `comment` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `ip_address` varchar(15) NOT NULL,
  `approved` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

/*Table structure for table `contents` */

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `language_id` int(11) unsigned NOT NULL,
  `content_title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `page_css` text,
  `page_js` text,
  `sidebar` text,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contents_ibfk_1` (`page_id`),
  KEY `contents_ibfk_2` (`language_id`),
  CONSTRAINT `contents_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contents_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `contents` */

insert  into `contents`(`id`,`page_id`,`language_id`,`content_title`,`body`,`meta_title`,`meta_keywords`,`meta_description`,`page_css`,`page_js`,`sidebar`,`created`,`created_by`,`updated`,`updated_by`) values (1,1,3,'Our mission','<p>The licenses for most software are designed to take away yourfreedom to share and change it. &nbsp;By contrast, the GNU General PublicLicense is intended to guarantee your freedom to share and change freesoftware--to make sure the software is free for all its users. &nbsp;ThisGeneral Public License applies to most of the Free SoftwareFoundation\'s software and to any other program whose authors commit tousing it. &nbsp;(Some other Free Software Foundation software is covered bythe GNU Library General Public License instead.) &nbsp;You can apply it toyour programs, too.</p>\n<p>When we speak of free software, we are referring to freedom, notprice. &nbsp;Our General Public Licenses are designed to make sure that youhave the freedom to distribute copies of free software (and charge forthis service if you wish), that you receive source code or can get itif you want it, that you can change the software or use pieces of itin new free programs; and that you know you can do these things.</p>\n<p>To protect your rights, we need to make restrictions that forbidanyone to deny you these rights or to ask you to surrender the rights.These restrictions translate to certain responsibilities for you if youdistribute copies of the software, or if you modify it.</p>','','','','','','','2011-06-12 20:37:52',1,NULL,NULL),(2,2,3,'Fleet pictures','<p>The licenses for most software are designed to take away yourfreedom to share and change it. &nbsp;By contrast, the GNU General PublicLicense is intended to guarantee your freedom to share and change freesoftware--to make sure the software is free for all its users. &nbsp;ThisGeneral Public License applies to most of the Free SoftwareFoundation\'s software and to any other program whose authors commit tousing it. &nbsp;(Some other Free Software Foundation software is covered bythe GNU Library General Public License instead.) &nbsp;You can apply it toyour programs, too.</p>\n<p>When we speak of free software, we are referring to freedom, notprice. &nbsp;Our General Public Licenses are designed to make sure that youhave the freedom to distribute copies of free software (and charge forthis service if you wish), that you receive source code or can get itif you want it, that you can change the software or use pieces of itin new free programs; and that you know you can do these things.</p>\n<p>To protect your rights, we need to make restrictions that forbidanyone to deny you these rights or to ask you to surrender the rights.These restrictions translate to certain responsibilities for you if youdistribute copies of the software, or if you modify it.</p>','','','','','','','2011-06-12 20:38:20',1,NULL,NULL),(3,3,3,'References','<p>The licenses for most software are designed to take away yourfreedom to share and change it. &nbsp;By contrast, the GNU General PublicLicense is intended to guarantee your freedom to share and change freesoftware--to make sure the software is free for all its users. &nbsp;ThisGeneral Public License applies to most of the Free SoftwareFoundation\'s software and to any other program whose authors commit tousing it. &nbsp;(Some other Free Software Foundation software is covered bythe GNU Library General Public License instead.) &nbsp;You can apply it toyour programs, too.</p>\n<p>When we speak of free software, we are referring to freedom, notprice. &nbsp;Our General Public Licenses are designed to make sure that youhave the freedom to distribute copies of free software (and charge forthis service if you wish), that you receive source code or can get itif you want it, that you can change the software or use pieces of itin new free programs; and that you know you can do these things.</p>\n<p>To protect your rights, we need to make restrictions that forbidanyone to deny you these rights or to ask you to surrender the rights.These restrictions translate to certain responsibilities for you if youdistribute copies of the software, or if you modify it.</p>','','','','','','','2011-06-12 20:38:51',1,NULL,NULL),(4,4,3,'Quote request','<p>The licenses for most software are designed to take away yourfreedom to share and change it. &nbsp;By contrast, the GNU General PublicLicense is intended to guarantee your freedom to share and change freesoftware--to make sure the software is free for all its users. &nbsp;ThisGeneral Public License applies to most of the Free SoftwareFoundation\'s software and to any other program whose authors commit tousing it. &nbsp;(Some other Free Software Foundation software is covered bythe GNU Library General Public License instead.) &nbsp;You can apply it toyour programs, too.</p>\n<p>When we speak of free software, we are referring to freedom, notprice. &nbsp;Our General Public Licenses are designed to make sure that youhave the freedom to distribute copies of free software (and charge forthis service if you wish), that you receive source code or can get itif you want it, that you can change the software or use pieces of itin new free programs; and that you know you can do these things.</p>\n<p>To protect your rights, we need to make restrictions that forbidanyone to deny you these rights or to ask you to surrender the rights.These restrictions translate to certain responsibilities for you if youdistribute copies of the software, or if you modify it.</p>','','','','','','','2011-06-12 20:39:17',1,NULL,NULL),(5,5,3,'Booking form','<p>The licenses for most software are designed to take away yourfreedom to share and change it. &nbsp;By contrast, the GNU General PublicLicense is intended to guarantee your freedom to share and change freesoftware--to make sure the software is free for all its users. &nbsp;ThisGeneral Public License applies to most of the Free SoftwareFoundation\'s software and to any other program whose authors commit tousing it. &nbsp;(Some other Free Software Foundation software is covered bythe GNU Library General Public License instead.) &nbsp;You can apply it toyour programs, too.</p>\n<p>When we speak of free software, we are referring to freedom, notprice. &nbsp;Our General Public Licenses are designed to make sure that youhave the freedom to distribute copies of free software (and charge forthis service if you wish), that you receive source code or can get itif you want it, that you can change the software or use pieces of itin new free programs; and that you know you can do these things.</p>\n<p>To protect your rights, we need to make restrictions that forbidanyone to deny you these rights or to ask you to surrender the rights.These restrictions translate to certain responsibilities for you if youdistribute copies of the software, or if you modify it.</p>','','','','','','','2011-06-12 20:39:34',1,NULL,NULL),(6,6,3,'Contact information','<p>The licenses for most software are designed to take away yourfreedom to share and change it. &nbsp;By contrast, the GNU General PublicLicense is intended to guarantee your freedom to share and change freesoftware--to make sure the software is free for all its users. &nbsp;ThisGeneral Public License applies to most of the Free SoftwareFoundation\'s software and to any other program whose authors commit tousing it. &nbsp;(Some other Free Software Foundation software is covered bythe GNU Library General Public License instead.) &nbsp;You can apply it toyour programs, too.</p>\n<p>When we speak of free software, we are referring to freedom, notprice. &nbsp;Our General Public Licenses are designed to make sure that youhave the freedom to distribute copies of free software (and charge forthis service if you wish), that you receive source code or can get itif you want it, that you can change the software or use pieces of itin new free programs; and that you know you can do these things.</p>\n<p>To protect your rights, we need to make restrictions that forbidanyone to deny you these rights or to ask you to surrender the rights.These restrictions translate to certain responsibilities for you if youdistribute copies of the software, or if you modify it.</p>','','','','','','','2011-06-12 20:39:46',1,NULL,NULL);

/*Table structure for table `languages` */

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(2) NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL,
  `position` int(2) DEFAULT NULL,
  `default` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `languages` */

insert  into `languages`(`id`,`locale`,`show`,`title`,`position`,`default`,`created`,`created_by`) values (3,'en',1,'English',NULL,1,'2010-12-18 13:55:04',1);

/*Table structure for table `media` */

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_fkey_page_id` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `media` */

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL DEFAULT '0',
  `language_id` int(11) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `intro` text NOT NULL,
  `body` text,
  `status` enum('draft','published') DEFAULT 'draft',
  `dontshow` tinyint(1) DEFAULT '0',
  `actual` tinyint(1) DEFAULT '0',
  `new` tinyint(1) DEFAULT '0',
  `competition` tinyint(1) DEFAULT '0',
  `rss_enabled` tinyint(1) DEFAULT '0',
  `comments_enabled` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_ibfk_2` (`language_id`),
  KEY `news_ibfk_1` (`category_id`),
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `news` */

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT '0',
  `layout_id` int(11) unsigned NOT NULL,
  `position` int(5) DEFAULT NULL,
  `status` enum('draft','published','deleted') DEFAULT 'draft',
  `module` varchar(32) DEFAULT NULL,
  `module_id` int(11) DEFAULT '0',
  `rss_enabled` tinyint(1) DEFAULT '0',
  `comments_enabled` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`id`,`parent_id`,`layout_id`,`position`,`status`,`module`,`module_id`,`rss_enabled`,`comments_enabled`,`created`,`created_by`,`updated`,`updated_by`) values (1,0,0,1,'published','',0,0,0,'2011-06-12 20:37:52',1,NULL,NULL),(2,0,0,2,'published','',0,0,0,'2011-06-12 20:38:20',1,NULL,NULL),(3,0,0,3,'published','references',0,0,0,'2011-06-12 20:38:51',1,NULL,NULL),(4,0,0,4,'published','',0,0,0,'2011-06-12 20:39:17',1,NULL,NULL),(5,0,0,5,'published','',0,0,0,'2011-06-12 20:39:34',1,NULL,NULL),(6,0,0,6,'published','',0,0,0,'2011-06-12 20:39:46',1,NULL,NULL);

/*Table structure for table `profiles` */

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `language` varchar(2) DEFAULT 'en',
  `gender` set('m','f','') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `skype_handle` varchar(100) DEFAULT NULL,
  `msn_handle` varchar(100) DEFAULT NULL,
  `twitter_handle` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_ibfk_1` (`user_id`),
  CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `profiles` */

insert  into `profiles`(`id`,`user_id`,`display_name`,`first_name`,`last_name`,`company`,`language`,`gender`,`phone`,`mobile`,`address`,`skype_handle`,`msn_handle`,`twitter_handle`,`website`) values (1,1,'Administrator','Pavel','Ivanov','','ru','m','','+371 29219792','','','','','');

/*Table structure for table `protocols` */

DROP TABLE IF EXISTS `protocols`;

CREATE TABLE `protocols` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `module` varchar(32) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `action` varchar(20) NOT NULL,
  `message` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `protocols` */

insert  into `protocols`(`id`,`user_id`,`module`,`module_id`,`action`,`message`,`created`) values (1,1,'languages',1,'delete','','2011-06-12 20:27:50'),(2,1,'pages',1,'create','','2011-06-12 20:37:52'),(3,1,'pages',2,'create','','2011-06-12 20:38:20'),(4,1,'pages',3,'create','','2011-06-12 20:38:51'),(5,1,'pages',1,'status_change','','2011-06-12 20:38:55'),(6,1,'pages',2,'status_change','','2011-06-12 20:38:56'),(7,1,'pages',3,'status_change','','2011-06-12 20:38:57'),(8,1,'pages',4,'create','','2011-06-12 20:39:17'),(9,1,'pages',5,'create','','2011-06-12 20:39:34'),(10,1,'pages',6,'create','','2011-06-12 20:39:46'),(11,1,'pages',6,'status_change','','2011-06-12 20:39:53'),(12,1,'pages',5,'status_change','','2011-06-12 20:39:54'),(13,1,'pages',4,'status_change','','2011-06-12 20:39:55'),(14,1,'blocks',7,'edit','','2011-06-12 20:51:45');

/*Table structure for table `references` */

DROP TABLE IF EXISTS `references`;

CREATE TABLE `references` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `postcode` varchar(10) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `e_mail` varchar(128) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `reference_text` text NOT NULL,
  `www` varchar(200) DEFAULT NULL,
  `file` varchar(250) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `approved` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `references` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`description`) values (1,'login','Login privileges, granted after account confirmation'),(2,'admin','Administrative user, has access to everything.'),(3,'editor','Site editor, who can only create or edit pages');

/*Table structure for table `roles_users` */

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `roles_users` */

insert  into `roles_users`(`user_id`,`role_id`) values (1,1),(1,2),(1,3);

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` text,
  `type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `settings` */

insert  into `settings`(`id`,`key`,`name`,`value`,`type`) values (1,'meta_title','Meta title','Busliner','input'),(2,'meta_description','Meta description','Busliner','textarea'),(3,'meta_keywords','Meta keywords','Busliner','textarea'),(5,'cache','Cache','0','checkbox'),(6,'cache_instance','Cache instance','file','input');

/*Table structure for table `titles` */

DROP TABLE IF EXISTS `titles`;

CREATE TABLE `titles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `language_id` int(11) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `long_slug` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `url_target` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_slug_uniq` (`slug`),
  KEY `titles_fkey_page_id` (`page_id`),
  KEY `titles_fkey_language_id` (`language_id`),
  CONSTRAINT `titles_fkey_language_id` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `titles_fkey_page_id` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `titles` */

insert  into `titles`(`id`,`page_id`,`language_id`,`slug`,`long_slug`,`title`,`url`,`url_target`) values (1,1,3,'our-mission','our-mission','Our mission','','_blank'),(2,2,3,'fleet-pictures','fleet-pictures','Fleet pictures','','_blank'),(3,3,3,'references','references','References','','_blank'),(4,4,3,'quote-request','quote-request','Quote request','','_blank'),(5,5,3,'booking-form','booking-form','Booking form','','_blank'),(6,6,3,'contact-information','contact-information','Contact information','','_blank');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`email`,`username`,`password`,`active`,`logins`,`last_login`) values (1,'info@balthost.eu','admin','8ba5b71640fd16df7c01321a0ea941948aa08cb5e79270f0a6',1,144,1307898264);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
