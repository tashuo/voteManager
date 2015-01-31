-- MySQL dump 10.14  Distrib 5.5.38-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: mama_toupiao
-- ------------------------------------------------------
-- Server version	5.5.38-MariaDB

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
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) NOT NULL,
  `is_active` tinyint(3) NOT NULL,
  `dateline` int(10) NOT NULL,
  `start_time` int(10) NOT NULL,
  `end_time` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `login_require` tinyint(3) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `del` tinyint(1) NOT NULL DEFAULT '0',
  `submitnum` int(10) unsigned NOT NULL DEFAULT '1',
  `see_able` tinyint(1) DEFAULT NULL,
  `vote_rule` varchar(15) DEFAULT NULL,
  `register_allow_times` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `project_fields`
--

DROP TABLE IF EXISTS `project_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_fields` (
  `pid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `options` text NOT NULL,
  `options_count` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `project_each_action`
--

DROP TABLE IF EXISTS `project_each_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_each_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `dateline` int(10) NOT NULL,
  `action` text NOT NULL,
  `action_day` int(8) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-09 17:04:04
