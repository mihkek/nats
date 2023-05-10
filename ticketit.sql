-- MySQL dump 10.14  Distrib 5.5.60-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: fgvista_db
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

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
-- Table structure for table `ticketit_statuses`
--

DROP TABLE IF EXISTS `ticketit_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketit_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketit_statuses`
--

LOCK TABLES `ticketit_statuses` WRITE;
/*!40000 ALTER TABLE `ticketit_statuses` DISABLE KEYS */;
INSERT INTO `ticketit_statuses` VALUES (1,'Ожидает старта','#ff2600'),(2,'Выполняется','#ff9300'),(3,'Временно отложено','#979797'),(4,'Закрыто','#01a501');
/*!40000 ALTER TABLE `ticketit_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketit_priorities`
--

DROP TABLE IF EXISTS `ticketit_priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketit_priorities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketit_priorities`
--

LOCK TABLES `ticketit_priorities` WRITE;
/*!40000 ALTER TABLE `ticketit_priorities` DISABLE KEYS */;
INSERT INTO `ticketit_priorities` VALUES (1,'Низкий','#069900'),(2,'Нормальный','#e1d200'),(3,'Высокий','#ff8080'),(4,'Критический','#ff0000');
/*!40000 ALTER TABLE `ticketit_priorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketit_categories`
--

DROP TABLE IF EXISTS `ticketit_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketit_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketit_categories`
--

LOCK TABLES `ticketit_categories` WRITE;
/*!40000 ALTER TABLE `ticketit_categories` DISABLE KEYS */;
INSERT INTO `ticketit_categories` VALUES (1,'Техническая','#0014f4'),(2,'Финансовая','#2b9900'),(3,'Общая','#7e0099');
/*!40000 ALTER TABLE `ticketit_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticketit_categories_users`
--

DROP TABLE IF EXISTS `ticketit_categories_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketit_categories_users` (
  `category_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticketit_categories_users`
--

LOCK TABLES `ticketit_categories_users` WRITE;
/*!40000 ALTER TABLE `ticketit_categories_users` DISABLE KEYS */;
INSERT INTO `ticketit_categories_users` VALUES (1,40),(2,40),(3,40),(1,41),(2,41),(3,41),(1,42),(2,42),(3,42),(1,330),(2,330),(3,330);
/*!40000 ALTER TABLE `ticketit_categories_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-18 18:39:06
