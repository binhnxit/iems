CREATE DATABASE  IF NOT EXISTS `ies` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `ies`;
-- MySQL dump 10.13  Distrib 5.7.9, for osx10.9 (x86_64)
--
-- Host: 127.0.0.1    Database: ies
-- ------------------------------------------------------
-- Server version	5.7.11

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
-- Table structure for table `ie_data`
--

DROP TABLE IF EXISTS `ie_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ie_data` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `note` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `ie_by` int(255) unsigned NOT NULL,
  `ie_type` int(1) unsigned NOT NULL,
  `cat_id` int(255) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id_idx` (`cat_id`),
  KEY `ie_by_idx` (`ie_by`),
  CONSTRAINT `cat_id` FOREIGN KEY (`cat_id`) REFERENCES `ie_cat` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ie_by` FOREIGN KEY (`ie_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ie_data`
--

LOCK TABLES `ie_data` WRITE;
/*!40000 ALTER TABLE `ie_data` DISABLE KEYS */;
INSERT INTO `ie_data` VALUES (4,1000,'Tien luong',1,1,4,'2016-04-22 01:59:17','2016-05-22 02:00:14'),(5,25000,'luong backup ',1,1,4,'2016-05-22 02:00:38','2016-05-22 02:00:38'),(6,8000,'sf',1,2,3,'2016-05-22 02:24:20','2016-05-22 02:24:20'),(7,87000,'sf',1,2,4,'2016-05-22 02:24:39','2016-05-22 02:24:39'),(8,900,'sf',2,2,5,'2016-05-22 03:50:07','2016-05-22 03:50:07');
/*!40000 ALTER TABLE `ie_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-20 16:00:34
