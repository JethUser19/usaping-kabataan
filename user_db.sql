/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - user_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`user_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `user_db`;

/*Table structure for table `anonymous_posts` */

DROP TABLE IF EXISTS `anonymous_posts`;

CREATE TABLE `anonymous_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `anonymous_posts` */

LOCK TABLES `anonymous_posts` WRITE;

UNLOCK TABLES;

/*Table structure for table `bayanihan_events` */

DROP TABLE IF EXISTS `bayanihan_events`;

CREATE TABLE `bayanihan_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_date` date NOT NULL,
  `description` text NOT NULL,
  `event_time` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `bayanihan_events` */

LOCK TABLES `bayanihan_events` WRITE;

UNLOCK TABLES;

/*Table structure for table `mood_entries` */

DROP TABLE IF EXISTS `mood_entries`;

CREATE TABLE `mood_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `mood` varchar(20) NOT NULL,
  `question_index` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `mood_entries` */

LOCK TABLES `mood_entries` WRITE;

insert  into `mood_entries`(`id`,`user_id`,`mood`,`question_index`,`created_at`) values 
(1,2,'happy',0,'2025-05-11 03:10:13'),
(2,2,'happy',1,'2025-05-11 03:10:13'),
(3,2,'happy',2,'2025-05-11 03:10:13'),
(4,2,'happy',3,'2025-05-11 03:10:13'),
(5,2,'happy',4,'2025-05-11 03:10:13'),
(6,2,'happy',5,'2025-05-11 03:10:13'),
(7,2,'happy',6,'2025-05-11 03:10:13'),
(8,2,'happy',7,'2025-05-11 03:10:13'),
(9,2,'happy',8,'2025-05-11 03:10:13'),
(10,2,'happy',9,'2025-05-11 03:10:13'),
(11,2,'anxious',0,'2025-05-11 03:14:22'),
(12,2,'anxious',1,'2025-05-11 03:14:22'),
(13,2,'anxious',2,'2025-05-11 03:14:22'),
(14,2,'anxious',3,'2025-05-11 03:14:22'),
(15,2,'anxious',4,'2025-05-11 03:14:22'),
(16,2,'anxious',5,'2025-05-11 03:14:22'),
(17,2,'anxious',6,'2025-05-11 03:14:22'),
(18,2,'anxious',7,'2025-05-11 03:14:22'),
(19,2,'anxious',8,'2025-05-11 03:14:22'),
(20,2,'anxious',9,'2025-05-11 03:14:22');

UNLOCK TABLES;

/*Table structure for table `moods` */

DROP TABLE IF EXISTS `moods`;

CREATE TABLE `moods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mood` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `moods_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `moods` */

LOCK TABLES `moods` WRITE;

UNLOCK TABLES;

/*Table structure for table `reflections` */

DROP TABLE IF EXISTS `reflections`;

CREATE TABLE `reflections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `mood_value` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reflections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `reflections` */

LOCK TABLES `reflections` WRITE;

insert  into `reflections`(`id`,`user_id`,`question_id`,`mood_value`,`created_at`) values 
(1,2,0,'happy','2025-05-11 02:27:59'),
(2,2,1,'happy','2025-05-11 02:27:59'),
(3,2,2,'happy','2025-05-11 02:27:59'),
(4,2,3,'happy','2025-05-11 02:27:59'),
(5,2,4,'happy','2025-05-11 02:27:59'),
(6,2,5,'happy','2025-05-11 02:27:59'),
(7,2,6,'happy','2025-05-11 02:27:59'),
(8,2,7,'happy','2025-05-11 02:27:59'),
(9,2,8,'happy','2025-05-11 02:27:59'),
(10,2,9,'happy','2025-05-11 02:27:59'),
(11,2,0,'tired','2025-05-11 02:28:21'),
(12,2,1,'tired','2025-05-11 02:28:21'),
(13,2,2,'tired','2025-05-11 02:28:21'),
(14,2,3,'tired','2025-05-11 02:28:21'),
(15,2,4,'tired','2025-05-11 02:28:21'),
(16,2,5,'tired','2025-05-11 02:28:21'),
(17,2,6,'tired','2025-05-11 02:28:21'),
(18,2,7,'tired','2025-05-11 02:28:21'),
(19,2,8,'tired','2025-05-11 02:28:21'),
(20,2,9,'tired','2025-05-11 02:28:21'),
(21,2,0,'happy','2025-05-11 02:32:06'),
(22,2,1,'happy','2025-05-11 02:32:06'),
(23,2,2,'happy','2025-05-11 02:32:06'),
(24,2,3,'happy','2025-05-11 02:32:06'),
(25,2,4,'happy','2025-05-11 02:32:06'),
(26,2,5,'happy','2025-05-11 02:32:06'),
(27,2,6,'happy','2025-05-11 02:32:06'),
(28,2,7,'happy','2025-05-11 02:32:06'),
(29,2,8,'happy','2025-05-11 02:32:06'),
(30,2,9,'happy','2025-05-11 02:32:06'),
(31,2,0,'happy','2025-05-11 03:05:29'),
(32,2,1,'happy','2025-05-11 03:05:29'),
(33,2,2,'happy','2025-05-11 03:05:29'),
(34,2,3,'happy','2025-05-11 03:05:29'),
(35,2,4,'happy','2025-05-11 03:05:29'),
(36,2,5,'happy','2025-05-11 03:05:29'),
(37,2,6,'happy','2025-05-11 03:05:29'),
(38,2,7,'happy','2025-05-11 03:05:29'),
(39,2,8,'happy','2025-05-11 03:05:29'),
(40,2,9,'happy','2025-05-11 03:05:29'),
(41,2,0,'sad','2025-05-11 03:07:51'),
(42,2,1,'sad','2025-05-11 03:07:51'),
(43,2,2,'sad','2025-05-11 03:07:51'),
(44,2,3,'sad','2025-05-11 03:07:51'),
(45,2,4,'sad','2025-05-11 03:07:51'),
(46,2,5,'sad','2025-05-11 03:07:51'),
(47,2,6,'sad','2025-05-11 03:07:51'),
(48,2,7,'sad','2025-05-11 03:07:51'),
(49,2,8,'sad','2025-05-11 03:07:51'),
(50,2,9,'sad','2025-05-11 03:07:51'),
(51,2,0,'happy','2025-05-11 03:10:13'),
(52,2,1,'happy','2025-05-11 03:10:13'),
(53,2,2,'happy','2025-05-11 03:10:13'),
(54,2,3,'happy','2025-05-11 03:10:13'),
(55,2,4,'happy','2025-05-11 03:10:13'),
(56,2,5,'happy','2025-05-11 03:10:13'),
(57,2,6,'happy','2025-05-11 03:10:13'),
(58,2,7,'happy','2025-05-11 03:10:13'),
(59,2,8,'happy','2025-05-11 03:10:13'),
(60,2,9,'happy','2025-05-11 03:10:13'),
(61,2,0,'anxious','2025-05-11 03:14:22'),
(62,2,1,'anxious','2025-05-11 03:14:22'),
(63,2,2,'anxious','2025-05-11 03:14:22'),
(64,2,3,'anxious','2025-05-11 03:14:22'),
(65,2,4,'anxious','2025-05-11 03:14:22'),
(66,2,5,'anxious','2025-05-11 03:14:22'),
(67,2,6,'anxious','2025-05-11 03:14:22'),
(68,2,7,'anxious','2025-05-11 03:14:22'),
(69,2,8,'anxious','2025-05-11 03:14:22'),
(70,2,9,'anxious','2025-05-11 03:14:22');

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`id`,`email`,`password`,`name`,`surname`) values 
(1,'user@example.com','$2y$10$U/6QIxUbmlkYOfBOfR3woesWHRIJKxpSExU3j8c5uxw/bd3NSbg3a',NULL,NULL),
(2,'Galera@gmail.com','$2y$10$oLnAjbFeiRicUAXpoH.TROmG6AYn/JkU4vM0WmERWV3S1SkMIQVZ6','Jethro','Galera');

UNLOCK TABLES;

/*Table structure for table `users_setting` */

DROP TABLE IF EXISTS `users_setting`;

CREATE TABLE `users_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_code` varchar(10) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users_setting` */

LOCK TABLES `users_setting` WRITE;

insert  into `users_setting`(`id`,`full_name`,`email`,`phone_code`,`phone_number`,`date_of_birth`,`country`,`profile_image`) values 
(1,'Zabersnes Riss T. Girmina Jr.','Girmina@gmail.com','+64','971 409 1970','1978-01-09','Philippines','');

UNLOCK TABLES;

/* Procedure structure for procedure `DeleteAnonymousPost` */

/*!50003 DROP PROCEDURE IF EXISTS  `DeleteAnonymousPost` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `DeleteAnonymousPost`(IN p_id INT)
BEGIN
    DELETE FROM anonymous_posts WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `DeleteBayanihanEvent` */

/*!50003 DROP PROCEDURE IF EXISTS  `DeleteBayanihanEvent` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `DeleteBayanihanEvent`(IN p_id INT)
BEGIN
    DELETE FROM bayanihan_events WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `DeleteMood` */

/*!50003 DROP PROCEDURE IF EXISTS  `DeleteMood` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `DeleteMood`(IN p_id INT)
BEGIN
    DELETE FROM moods WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `DeleteMoodEntry` */

/*!50003 DROP PROCEDURE IF EXISTS  `DeleteMoodEntry` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `DeleteMoodEntry`(IN p_id INT)
BEGIN
    DELETE FROM mood_entries WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `DeleteReflection` */

/*!50003 DROP PROCEDURE IF EXISTS  `DeleteReflection` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `DeleteReflection`(IN p_id INT)
BEGIN
    DELETE FROM reflections WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `DeleteUserSetting` */

/*!50003 DROP PROCEDURE IF EXISTS  `DeleteUserSetting` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `DeleteUserSetting`(IN p_id INT)
BEGIN
    DELETE FROM users_setting WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateAnonymousPost` */

/*!50003 DROP PROCEDURE IF EXISTS  `UpdateAnonymousPost` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateAnonymousPost`(
    IN p_id INT,
    IN p_content TEXT
)
BEGIN
    UPDATE anonymous_posts 
    SET content = p_content 
    WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateBayanihanEvent` */

/*!50003 DROP PROCEDURE IF EXISTS  `UpdateBayanihanEvent` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateBayanihanEvent`(
    IN p_id INT,
    IN p_event_date DATE,
    IN p_description TEXT,
    IN p_event_time VARCHAR(100),
    IN p_location VARCHAR(255)
)
BEGIN
    UPDATE bayanihan_events 
    SET event_date = p_event_date,
        description = p_description,
        event_time = p_event_time,
        location = p_location
    WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateMood` */

/*!50003 DROP PROCEDURE IF EXISTS  `UpdateMood` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateMood`(
    IN p_id INT,
    IN p_mood VARCHAR(50)
)
BEGIN
    UPDATE moods SET mood = p_mood WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateMoodEntry` */

/*!50003 DROP PROCEDURE IF EXISTS  `UpdateMoodEntry` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateMoodEntry`(
    IN p_id INT,
    IN p_mood VARCHAR(20),
    IN p_question_index INT
)
BEGIN
    UPDATE mood_entries 
    SET mood = p_mood, question_index = p_question_index 
    WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateReflection` */

/*!50003 DROP PROCEDURE IF EXISTS  `UpdateReflection` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateReflection`(
    IN p_id INT,
    IN p_question_id INT,
    IN p_mood_value VARCHAR(50)
)
BEGIN
    UPDATE reflections 
    SET question_id = p_question_id, mood_value = p_mood_value 
    WHERE id = p_id;
END */$$
DELIMITER ;

/* Procedure structure for procedure `UpdateUserSetting` */

/*!50003 DROP PROCEDURE IF EXISTS  `UpdateUserSetting` */;

DELIMITER $$

/*!50003 CREATE PROCEDURE `UpdateUserSetting`(
    IN p_id INT,
    IN p_full_name VARCHAR(100),
    IN p_email VARCHAR(100),
    IN p_phone_code VARCHAR(10),
    IN p_phone_number VARCHAR(20),
    IN p_date_of_birth DATE,
    IN p_country VARCHAR(100),
    IN p_profile_image VARCHAR(255)
)
BEGIN
    UPDATE users_setting 
    SET full_name = p_full_name,
        email = p_email,
        phone_code = p_phone_code,
        phone_number = p_phone_number,
        date_of_birth = p_date_of_birth,
        country = p_country,
        profile_image = p_profile_image
    WHERE id = p_id;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
