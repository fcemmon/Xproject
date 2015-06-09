/*
SQLyog Community v11.11 (32 bit)
MySQL - 5.5.24-log : Database - conscio0_xappapi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`conscio0_xappapi` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `conscio0_xappapi`;

/*Table structure for table `tbl_services` */

DROP TABLE IF EXISTS `tbl_services`;

CREATE TABLE `tbl_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creater_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(100) DEFAULT NULL,
  `phone_type` tinyint(1) DEFAULT NULL COMMENT '0:Mobile',
  `email` varchar(100) DEFAULT NULL,
  `email_type` tinyint(1) DEFAULT NULL COMMENT '0:Work',
  `address` varchar(250) DEFAULT NULL,
  `address_type` tinyint(1) DEFAULT NULL COMMENT '0:Home',
  `service_name` varchar(255) DEFAULT NULL COMMENT 'service name',
  `latitude` double DEFAULT NULL COMMENT 'yu',
  `longitude` double DEFAULT NULL COMMENT 'gy',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_services` */

insert  into `tbl_services`(`id`,`creater_id`,`username`,`photo`,`phonenumber`,`phone_type`,`email`,`email_type`,`address`,`address_type`,`service_name`,`latitude`,`longitude`,`updated_at`,`created_at`) values (1,1,'alexandra','http://192.168.0.192/xappapi/uploads/1/photo/coordinate.jpg','123',0,'',0,'',0,'',43.91413,125.3981,NULL,NULL),(2,2,'','http://192.168.0.192/xappapi/uploads/9/photo/image.jpg','',0,'',0,'',0,'',0,0,'2015-06-03 20:55:10',NULL),(3,3,'','http://192.168.0.192/xappapi/uploads/12/photo/image.jpg','',0,'',0,'',0,'',43.85724,125.359872,'2015-06-06 05:58:05',NULL);

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_token` varchar(50) DEFAULT NULL,
  `platform` varchar(10) DEFAULT 'ios' COMMENT 'ios or android',
  `last_login` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`auth_token`,`platform`,`last_login`,`created_at`) values (1,'49F9533A-0231-4238-9C83-47EB4794D594',NULL,'2015-06-03 06:37:34',NULL),(2,'C0D9311F-C70F-4402-B586-125D16743D44',NULL,'2015-06-03 11:43:11',NULL),(3,'A3F2B474-4A3F-4950-9483-A32083B92381',NULL,'2015-06-06 05:57:04',NULL);

/*Table structure for table `tbl_viewers` */

DROP TABLE IF EXISTS `tbl_viewers`;

CREATE TABLE `tbl_viewers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `service_id` bigint(20) NOT NULL,
  `like` tinyint(1) DEFAULT '0' COMMENT '1:like, 0:no',
  `favorite` tinyint(1) DEFAULT '0' COMMENT '1:favorite, 0:no',
  `comment` text,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_viewers` */

insert  into `tbl_viewers`(`id`,`user_id`,`service_id`,`like`,`favorite`,`comment`,`updated_at`,`created_at`) values (1,1,2,1,1,'comment1','2015-06-01 20:55:44',NULL),(2,1,3,1,0,NULL,'2015-06-01 20:55:46',NULL),(3,2,1,1,0,'123','2015-06-02 05:53:52',NULL),(4,2,3,1,1,'','2015-06-02 09:49:39',NULL),(5,3,1,1,0,NULL,'2015-06-02 12:18:08',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
