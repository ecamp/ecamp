-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `camp`
--

DROP TABLE IF EXISTS `camp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `camp` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) DEFAULT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `group_name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `slogan` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `is_course` smallint(1) NOT NULL,
  `jstype` smallint(6) NOT NULL,
  `type` smallint(6) NOT NULL,
  `type_text` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `creator_user_id` mediumint(8) unsigned DEFAULT NULL,
  `ca_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ca_street` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ca_zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ca_city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ca_tel` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ca_coor` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `t_created` int(10) DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `creator_userid` (`creator_user_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `camp_ibfk_1` FOREIGN KEY (`creator_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste der Camps';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `form_type` tinyint(3) unsigned DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `camp` (`camp_id`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste der Kategorien pro Camp';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `course_aim`
--

DROP TABLE IF EXISTS `course_aim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_aim` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned DEFAULT NULL,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `aim` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `camp_id` (`camp_id`),
  CONSTRAINT `course_aim_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `course_aim` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_aim_ibfk_2` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `course_checklist`
--

DROP TABLE IF EXISTS `course_checklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_checklist` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) unsigned DEFAULT NULL,
  `short` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `short_1` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `short_2` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `selectable` tinyint(4) NOT NULL DEFAULT '1',
  `valid` tinyint(4) NOT NULL DEFAULT '1',
  `course_type` tinyint(4) DEFAULT NULL,
  `checklist_type` tinyint(4) DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  CONSTRAINT `course_checklist_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `course_checklist` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `course_type`
--

DROP TABLE IF EXISTS `course_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `scout_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `js_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_type`
--

LOCK TABLES `course_type` WRITE;
/*!40000 ALTER TABLE `course_type` DISABLE KEYS */;
INSERT INTO `course_type` VALUES (1,'Anderer Kurs','','','2009-07-02 09:46:00');
/*!40000 ALTER TABLE `course_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `day`
--

DROP TABLE IF EXISTS `day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `day` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `subcamp_id` mediumint(8) unsigned NOT NULL,
  `day_offset` smallint(5) unsigned NOT NULL DEFAULT '0',
  `story` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique day offset` (`subcamp_id`,`day_offset`),
  KEY `subcamp_id` (`subcamp_id`),
  KEY `day_offset` (`day_offset`),
  CONSTRAINT `day_ibfk_1` FOREIGN KEY (`subcamp_id`) REFERENCES `subcamp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste der Days pro Subcamp';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dropdown`
--

DROP TABLE IF EXISTS `dropdown`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dropdown` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `list` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `item_nr` mediumint(8) NOT NULL,
  `entry` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Liste von Dropdown-Menus';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dropdown`
--

LOCK TABLES `dropdown` WRITE;
/*!40000 ALTER TABLE `dropdown` DISABLE KEYS */;
INSERT INTO `dropdown` VALUES (1,'function_camp',1,'AL','50','2009-11-02 19:40:35'),(2,'function_camp',2,'Lagerleiter','50','2009-11-02 19:40:47'),(3,'function_camp',3,'Leiter','40','2009-11-02 19:43:02'),(4,'function_camp',5,'Gast','20','2009-11-02 19:43:24'),(5,'function_camp',0,'Support','0','2009-11-02 19:43:15'),(6,'sex',1,'Männlich','','2008-10-05 16:49:44'),(7,'sex',2,'Weiblich','','2008-10-05 16:49:44'),(8,'jsedu',0,'-','','2008-10-05 16:49:44'),(9,'jsedu',1,'Gruppenleiter','','2008-10-05 16:49:44'),(10,'jsedu',2,'Lagerleiter','','2008-10-05 16:49:44'),(11,'jsedu',3,'Ausbildner','','2008-10-05 16:49:44'),(12,'jsedu',4,'Experte','','2008-10-05 16:49:44'),(20,'pbsedu',0,'-','','2008-10-05 16:49:44'),(21,'pbsedu',1,'Basiskurs','','2008-10-05 16:49:44'),(22,'pbsedu',2,'Aufbaukurs','','2008-10-05 16:49:44'),(23,'pbsedu',3,'Panokurs','','2008-10-05 16:49:44'),(24,'pbsedu',4,'Spektrum','','2008-10-05 16:49:44'),(25,'pbsedu',5,'Topkurs','','2008-10-05 16:49:44'),(26,'pbsedu',6,'Gillwell','','2008-10-05 16:49:44'),(34,'form',0,'kein Detailprogramm','0','2008-08-18 15:27:28'),(35,'form',1,'Lagersport','1','2008-10-05 16:38:43'),(36,'form',2,'Lageraktivität','2','2008-10-05 16:38:43'),(37,'form',3,'Sonstiges Lagerprogramm','3','2008-10-05 16:38:43'),(38,'form',4,'Ausbildungsblock','4','2008-10-05 16:38:43'),(39,'camptype',0,'J&S-Lager','0','2008-08-11 09:07:33'),(41,'coursetype',1,'1. Stufe Basiskurs','1','2009-09-22 18:40:59'),(42,'coursetype',2,'1. Stufe Aufbaukurs','3','2009-09-22 18:40:59'),(43,'coursetype',3,'2. Stufe Basiskurs','2','2009-09-22 18:40:59'),(44,'coursetype',4,'2. Stufe Aufbaukurs','4','2009-09-22 18:40:59'),(45,'coursetype',99,'Anderer Kurs','99','2017-10-18 16:42:19'),(46,'function_camp',4,'Coach','20','2009-11-02 19:44:23'),(47,'function_course',0,'Support','0','2009-11-02 19:46:33'),(48,'function_course',1,'Kursleiter','50','2009-11-02 19:46:33'),(49,'function_course',2,'Mitleiter','40','2009-11-02 19:53:38'),(50,'function_course',3,'LKB','20','2009-11-02 19:46:33'),(51,'function_course',4,'Gast','20','2009-11-02 19:46:33'),(52,'jstype',1,'J+S Kids','1','2009-12-10 00:59:34'),(53,'jstype',2,'J+S Teen','2','2009-12-10 00:59:34'),(54,'jstype',3,'Nicht J+S','3','2009-12-10 00:59:46'),(55,'coursetype',5,'Wolfsstufe Basiskurs','11','2011-12-06 21:40:09'),(56,'coursetype',6,'Wolfsstufe Aufbaukurs','13','2011-12-06 23:34:45'),(57,'coursetype',7,'Pfadistufe Basiskurs','12','2011-12-06 23:35:26'),(58,'coursetype',8,'Pfadistufe Aufbaukurs','14','2011-12-06 21:40:44'),(59,'coursetype',21,'Basiskurs Wolfsstufe','21','2017-10-18 16:37:37'),(60,'coursetype',22,'Basiskurs Pfadistufe','22','2017-10-18 16:38:29'),(61,'coursetype',23,'Aufbaukurs Wolfsstufe','23','2017-10-18 16:38:29'),(62,'coursetype',24,'Aufbaukurs Pfadistufe','24','2017-10-18 16:39:15'),(63,'coursetype',25,'Aufbaukurs Wolfs-/Pfadistufe','25','2017-10-18 16:39:15'),(64,'coursetype',26,'Einführungskurs Wolfsstufe','26','2017-10-18 16:39:50'),(65,'coursetype',27,'Einführungskurs Pfadistufe','27','2017-10-18 16:39:50'),(66,'coursetype',28,'Einführungskurs Piostufe','28','2017-10-18 16:40:40');
/*!40000 ALTER TABLE `dropdown` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `category_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `story` text COLLATE utf8_unicode_ci NOT NULL,
  `aim` text COLLATE utf8_unicode_ci NOT NULL,
  `method` text COLLATE utf8_unicode_ci NOT NULL,
  `topics` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `seco` text COLLATE utf8_unicode_ci NOT NULL,
  `progress` smallint(6) NOT NULL DEFAULT '0',
  `in_edition_by` mediumint(9) NOT NULL,
  `in_edition_time` int(10) DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `camp_id` (`camp_id`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Events pro Day';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_aim`
--

DROP TABLE IF EXISTS `event_aim`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_aim` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `aim_id` mediumint(8) unsigned NOT NULL,
  `event_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `checklist_id` (`aim_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_aim_ibfk_1` FOREIGN KEY (`aim_id`) REFERENCES `course_aim` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_aim_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_aim`
--

LOCK TABLES `event_aim` WRITE;
/*!40000 ALTER TABLE `event_aim` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_aim` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_checklist`
--

DROP TABLE IF EXISTS `event_checklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_checklist` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `checklist_id` mediumint(8) unsigned NOT NULL,
  `event_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `checklist_id` (`checklist_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_checklist_ibfk_1` FOREIGN KEY (`checklist_id`) REFERENCES `course_checklist` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_checklist_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_checklist`
--

LOCK TABLES `event_checklist` WRITE;
/*!40000 ALTER TABLE `event_checklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_checklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_comment`
--

DROP TABLE IF EXISTS `event_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `t_created` int(10) unsigned DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event` (`event_id`),
  CONSTRAINT `event_comment_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Kommentare zu Events';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_comment`
--

LOCK TABLES `event_comment` WRITE;
/*!40000 ALTER TABLE `event_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_detail`
--

DROP TABLE IF EXISTS `event_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_detail` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(8) unsigned NOT NULL,
  `prev_id` mediumint(8) unsigned DEFAULT NULL,
  `time` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `resp` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `sorting` mediumint(8) unsigned NOT NULL,
  `revision` int(11) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prev_id_2` (`prev_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_detail_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_detail_ibfk_3` FOREIGN KEY (`prev_id`) REFERENCES `event_detail` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Details pro Event';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_document`
--

DROP TABLE IF EXISTS `event_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_document` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `print` tinyint(6) NOT NULL,
  `time` int(11) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `event_document_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='PDFs an Events anhängen';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_document`
--

LOCK TABLES `event_document` WRITE;
/*!40000 ALTER TABLE `event_document` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_instance`
--

DROP TABLE IF EXISTS `event_instance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_instance` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(8) unsigned NOT NULL,
  `day_id` mediumint(8) unsigned NOT NULL,
  `starttime` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'min',
  `length` smallint(5) unsigned NOT NULL DEFAULT '60' COMMENT 'min',
  `dleft` float NOT NULL DEFAULT '0',
  `width` float NOT NULL DEFAULT '1',
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `day_id` (`day_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_instance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_instance_ibfk_2` FOREIGN KEY (`day_id`) REFERENCES `day` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Event_dummys um Events zu Spliten';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_responsible`
--

DROP TABLE IF EXISTS `event_responsible`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_responsible` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `event_id` mediumint(8) unsigned NOT NULL,
  `who` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `main` tinyint(1) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `event_responsible_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_responsible_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Zuweisung, wer für welche Events verantwortlich ist';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Feedbacks ablegen';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `short_prefix` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `pid` mediumint(8) unsigned DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`pid`),
  KEY `active` (`active`),
  CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Gruppierung / Strukturierung der Pfadi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `job_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `show_gp` tinyint(1) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `camp` (`camp_id`),
  CONSTRAINT `job_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Jobs für jede Lager';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `job_day`
--

DROP TABLE IF EXISTS `job_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_day` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `job_id` mediumint(8) unsigned NOT NULL,
  `day_id` mediumint(8) unsigned NOT NULL,
  `user_camp_id` mediumint(8) unsigned DEFAULT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_day` (`job_id`,`day_id`),
  KEY `day_id` (`day_id`),
  KEY `job_id` (`job_id`),
  KEY `user_camp_id` (`user_camp_id`),
  CONSTRAINT `job_day_ibfk_5` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`) ON DELETE CASCADE,
  CONSTRAINT `job_day_ibfk_6` FOREIGN KEY (`day_id`) REFERENCES `day` (`id`) ON DELETE CASCADE,
  CONSTRAINT `job_day_ibfk_7` FOREIGN KEY (`user_camp_id`) REFERENCES `user_camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Zuweisung, wer welchen Job an welchem Tag machen muss';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mat_article`
--

DROP TABLE IF EXISTS `mat_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mat_article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `price` float unsigned NOT NULL,
  `buy_place` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `notice` text COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Sammelliste von Einkaufsgegenständen';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mat_article`
--

LOCK TABLES `mat_article` WRITE;
/*!40000 ALTER TABLE `mat_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `mat_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mat_article_alias`
--

DROP TABLE IF EXISTS `mat_article_alias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mat_article_alias` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mat_article_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mat_article_id` (`mat_article_id`),
  CONSTRAINT `mat_article_alias_ibfk_1` FOREIGN KEY (`mat_article_id`) REFERENCES `mat_article` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mat_article_alias`
--

LOCK TABLES `mat_article_alias` WRITE;
/*!40000 ALTER TABLE `mat_article_alias` DISABLE KEYS */;
/*!40000 ALTER TABLE `mat_article_alias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mat_event`
--

DROP TABLE IF EXISTS `mat_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mat_event` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(8) unsigned NOT NULL,
  `user_camp_id` mediumint(8) unsigned DEFAULT NULL,
  `mat_list_id` mediumint(8) unsigned DEFAULT NULL,
  `mat_article_id` mediumint(8) unsigned DEFAULT NULL,
  `article_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `organized` tinyint(1) NOT NULL DEFAULT '0',
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_camp_id`),
  KEY `mat_list_id` (`mat_list_id`),
  KEY `mat_article_id` (`mat_article_id`),
  CONSTRAINT `mat_event_ibfk_23` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mat_event_ibfk_24` FOREIGN KEY (`user_camp_id`) REFERENCES `user_camp` (`id`) ON DELETE SET NULL,
  CONSTRAINT `mat_event_ibfk_25` FOREIGN KEY (`mat_list_id`) REFERENCES `mat_list` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mat_event_ibfk_26` FOREIGN KEY (`mat_article_id`) REFERENCES `mat_article` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von zu organisierendem Material';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mat_event`
--

LOCK TABLES `mat_event` WRITE;
/*!40000 ALTER TABLE `mat_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `mat_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mat_list`
--

DROP TABLE IF EXISTS `mat_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mat_list` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `camp_id` (`camp_id`),
  CONSTRAINT `mat_list_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `postit`
--

DROP TABLE IF EXISTS `postit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `postit` (
  `id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `maximized` tinyint(1) DEFAULT NULL,
  `x` float NOT NULL,
  `y` float NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `postit_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Speichert, wer einen Kommentar schon gesehen hat.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postit`
--

LOCK TABLES `postit` WRITE;
/*!40000 ALTER TABLE `postit` DISABLE KEYS */;
/*!40000 ALTER TABLE `postit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pre_user`
--

DROP TABLE IF EXISTS `pre_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pre_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `function_id` smallint(5) unsigned NOT NULL,
  `mail` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `scoutname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` smallint(5) unsigned DEFAULT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `homenr` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `mobilnr` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` int(10) unsigned DEFAULT NULL,
  `ahv` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `sex` mediumint(8) NOT NULL,
  `jspersnr` int(10) unsigned DEFAULT NULL,
  `jsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `pbsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `regtime` int(10) unsigned DEFAULT NULL,
  `t_edited` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `Mail` (`mail`),
  KEY `camp_id` (`camp_id`),
  KEY `function_id` (`function_id`),
  CONSTRAINT `pre_user_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von User, welche noch nicht Systemuser sind';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pre_user`
--

LOCK TABLES `pre_user` WRITE;
/*!40000 ALTER TABLE `pre_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `pre_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcamp`
--

DROP TABLE IF EXISTS `subcamp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcamp` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `start` int(8) unsigned NOT NULL DEFAULT '0',
  `length` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `camp_id` (`camp_id`),
  CONSTRAINT `subcamp_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Liste von Subcamps pro Camp';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `todo`
--

DROP TABLE IF EXISTS `todo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `short` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `camp_id` (`camp_id`),
  CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `todo_user_camp`
--

DROP TABLE IF EXISTS `todo_user_camp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo_user_camp` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_camp_id` mediumint(8) unsigned NOT NULL,
  `todo_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_camp_id` (`user_camp_id`),
  KEY `todo_id` (`todo_id`),
  CONSTRAINT `todo_user_camp_ibfk_1` FOREIGN KEY (`user_camp_id`) REFERENCES `user_camp` (`id`) ON DELETE CASCADE,
  CONSTRAINT `todo_user_camp_ibfk_2` FOREIGN KEY (`todo_id`) REFERENCES `todo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_user_camp`
--

LOCK TABLES `todo_user_camp` WRITE;
/*!40000 ALTER TABLE `todo_user_camp` DISABLE KEYS */;
/*!40000 ALTER TABLE `todo_user_camp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mail` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `scoutname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` smallint(5) unsigned DEFAULT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `homenr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mobilnr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` int(5) DEFAULT NULL,
  `ahv` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `jspersnr` mediumint(9) DEFAULT NULL,
  `jsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `pbsedu` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `last_camp` mediumint(8) NOT NULL,
  `regtime` int(10) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `acode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `image` blob,
  `news` text COLLATE utf8_unicode_ci NOT NULL,
  `copyspace` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registrierte User im System';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_camp`
--

DROP TABLE IF EXISTS `user_camp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_camp` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `camp_id` mediumint(8) unsigned NOT NULL,
  `function_id` smallint(3) unsigned NOT NULL,
  `invitation_id` mediumint(8) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL,
  `t_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `camp_id` (`camp_id`),
  KEY `invitation_id` (`invitation_id`),
  CONSTRAINT `user_camp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_camp_ibfk_2` FOREIGN KEY (`camp_id`) REFERENCES `camp` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Zuweisung, welche User zu welchen Camps zugang haben';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `v_all_days`
--

DROP TABLE IF EXISTS `v_all_days`;
/*!50001 DROP VIEW IF EXISTS `v_all_days`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_all_days` (
  `camp_id` tinyint NOT NULL,
  `id` tinyint NOT NULL,
  `subcamp_id` tinyint NOT NULL,
  `day_offset` tinyint NOT NULL,
  `story` tinyint NOT NULL,
  `notes` tinyint NOT NULL,
  `t_edited` tinyint NOT NULL,
  `start` tinyint NOT NULL,
  `daynr` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v_event_nr`
--

DROP TABLE IF EXISTS `v_event_nr`;
/*!50001 DROP VIEW IF EXISTS `v_event_nr`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v_event_nr` (
  `event_id` tinyint NOT NULL,
  `event_instance_id` tinyint NOT NULL,
  `day_nr` tinyint NOT NULL,
  `event_nr` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `v_all_days`
--

/*!50001 DROP TABLE IF EXISTS `v_all_days`*/;
/*!50001 DROP VIEW IF EXISTS `v_all_days`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_all_days` AS select `camp`.`id` AS `camp_id`,`day`.`id` AS `id`,`day`.`subcamp_id` AS `subcamp_id`,`day`.`day_offset` AS `day_offset`,`day`.`story` AS `story`,`day`.`notes` AS `notes`,`day`.`t_edited` AS `t_edited`,`subcamp`.`start` AS `start`,((select count(0) AS `count(*)` from (`day` `sday` join `subcamp` `ssubcamp`) where (((`ssubcamp`.`start` + `sday`.`day_offset`) < (`subcamp`.`start` + `day`.`day_offset`)) and (`ssubcamp`.`id` = `sday`.`subcamp_id`) and (`ssubcamp`.`camp_id` = `subcamp`.`camp_id`))) + 1) AS `daynr` from ((`camp` join `subcamp`) join `day`) where ((`subcamp`.`camp_id` = `camp`.`id`) and (`day`.`subcamp_id` = `subcamp`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_event_nr`
--

/*!50001 DROP TABLE IF EXISTS `v_event_nr`*/;
/*!50001 DROP VIEW IF EXISTS `v_event_nr`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_event_nr` AS select `event`.`id` AS `event_id`,`event_instance`.`id` AS `event_instance_id`,(((select ifnull(sum(`sub_subcamp`.`length`),0) AS `IFNULL( sum( sub_subcamp.length ), 0)` from `subcamp` `sub_subcamp` where ((`subcamp`.`camp_id` = `sub_subcamp`.`camp_id`) and (`subcamp`.`start` > `sub_subcamp`.`start`))) + `day`.`day_offset`) + 1) AS `day_nr`,(select count(`event_instance_down`.`id`) AS `count(event_instance_down.id)` from (((`event_instance` `event_instance_up` join `event_instance` `event_instance_down`) join `event`) join `category`) where ((`event_instance_up`.`id` = `event_instance`.`id`) and (`event_instance_up`.`day_id` = `event_instance_down`.`day_id`) and (`event_instance_down`.`event_id` = `event`.`id`) and (`event`.`category_id` = `category`.`id`) and (`category`.`form_type` > 0) and ((`event_instance_down`.`starttime` < `event_instance_up`.`starttime`) or ((`event_instance_down`.`starttime` = `event_instance_up`.`starttime`) and ((`event_instance_down`.`dleft` < `event_instance_up`.`dleft`) or ((`event_instance_down`.`dleft` = `event_instance_up`.`dleft`) and (`event_instance_down`.`id` <= `event_instance_up`.`id`))))))) AS `event_nr` from (((`event_instance` join `event`) join `day`) join `subcamp`) where ((`event`.`id` = `event_instance`.`event_id`) and (`event_instance`.`day_id` = `day`.`id`) and (`day`.`subcamp_id` = `subcamp`.`id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-31 20:00:40
