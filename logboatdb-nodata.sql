-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: us-cdbr-azure-central-a.cloudapp.net    Database: cs3380-logboat-db
-- ------------------------------------------------------
-- Server version	5.5.40-log

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
-- Table structure for table `batch`
--

DROP TABLE IF EXISTS `batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL AUTO_INCREMENT,
  `beer_name` varchar(20) DEFAULT NULL,
  `sched_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sched_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(20) NOT NULL,
  PRIMARY KEY (`batch_id`),
  KEY `beer_name` (`beer_name`),
  CONSTRAINT `batch_ibfk_1` FOREIGN KEY (`beer_name`) REFERENCES `beer` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `beer`
--

DROP TABLE IF EXISTS `beer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beer` (
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `beer_beertype`
--

DROP TABLE IF EXISTS `beer_beertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beer_beertype` (
  `beer_name` varchar(20) DEFAULT NULL,
  `beer_type` varchar(20) DEFAULT NULL,
  KEY `beer_name` (`beer_name`),
  KEY `beer_type` (`beer_type`),
  CONSTRAINT `beer_beertype_ibfk_1` FOREIGN KEY (`beer_name`) REFERENCES `beer` (`name`),
  CONSTRAINT `beer_beertype_ibfk_2` FOREIGN KEY (`beer_type`) REFERENCES `beer_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `beer_ingredient`
--

DROP TABLE IF EXISTS `beer_ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beer_ingredient` (
  `beer_name` varchar(20) DEFAULT NULL,
  `ingredient_name` varchar(20) DEFAULT NULL,
  KEY `beer_name` (`beer_name`),
  KEY `beer_ingredient_ibfk_1` (`ingredient_name`),
  CONSTRAINT `beer_ingredient_ibfk_1` FOREIGN KEY (`ingredient_name`) REFERENCES `ingredient` (`name`) ON DELETE CASCADE,
  CONSTRAINT `beer_ingredient_ibfk_2` FOREIGN KEY (`ingredient_name`) REFERENCES `ingredient` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `beer_type`
--

DROP TABLE IF EXISTS `beer_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beer_type` (
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fermentation`
--

DROP TABLE IF EXISTS `fermentation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fermentation` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `ft_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `value` float NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`f_id`),
  KEY `ft_id` (`ft_id`),
  KEY `unit_id` (`unit_id`),
  KEY `fermentation_ibfk_1` (`batch_id`),
  CONSTRAINT `fermentation_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`) ON DELETE CASCADE,
  CONSTRAINT `fermentation_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  CONSTRAINT `fermentation_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fermentation_type`
--

DROP TABLE IF EXISTS `fermentation_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fermentation_type` (
  `ft_id` int(11) NOT NULL AUTO_INCREMENT,
  `ph` float NOT NULL,
  `specific_gravity` float NOT NULL,
  PRIMARY KEY (`ft_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredient` (
  `name` varchar(20) NOT NULL,
  `inventory` int(11) NOT NULL,
  `lot_number` varchar(20) NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `keg`
--

DROP TABLE IF EXISTS `keg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keg` (
  `keg_id` int(11) NOT NULL,
  `location` varchar(20) NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`keg_id`),
  KEY `keg_ibfk_1` (`batch_id`),
  CONSTRAINT `keg_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_`
--

DROP TABLE IF EXISTS `order_`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `ingredient_name` varchar(20) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiration_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`order_id`),
  KEY `order__ibfk_1` (`ingredient_name`),
  CONSTRAINT `order__ibfk_1` FOREIGN KEY (`ingredient_name`) REFERENCES `ingredient` (`name`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `salt` varchar(20) DEFAULT NULL,
  `hashed_password` varchar(256) DEFAULT NULL,
  `usertype` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-17  3:44:03
