-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: ngcb
-- ------------------------------------------------------
-- Server version	5.7.19

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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `accounts_id` int(11) NOT NULL AUTO_INCREMENT,
  `accounts_fname` varchar(45) NOT NULL,
  `accounts_lname` varchar(45) NOT NULL,
  `accounts_username` varchar(45) NOT NULL,
  `accounts_password` varchar(45) NOT NULL,
  `accounts_type` varchar(45) NOT NULL,
  PRIMARY KEY (`accounts_id`),
  UNIQUE KEY `accounts_id_UNIQUE` (`accounts_id`),
  UNIQUE KEY `accounts_username_UNIQUE` (`accounts_username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Ray','Servidad','admin','admin','Admin'),(2,'Harold','Vinluan','h_vinluan','vinluan2011','View Only'),(3,'Mikka','Tuguinay','mikka_tuguinay19','mikkamikka','Materials Engineer');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL DEFAULT '1',
  `categories_name` varchar(45) NOT NULL,
  PRIMARY KEY (`categories_id`),
  UNIQUE KEY `categories_id_UNIQUE` (`categories_id`),
  UNIQUE KEY `categories_name_UNIQUE` (`categories_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'Electrical'),(1,'Formworks'),(3,'Plumbing');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `projects_id` int(11) NOT NULL DEFAULT '1',
  `projects_name` varchar(75) NOT NULL,
  `projects_address` varchar(100) NOT NULL,
  `projects_sdate` date NOT NULL,
  `projects_edate` date NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`projects_id`),
  UNIQUE KEY `projects_id_UNIQUE` (`projects_id`),
  UNIQUE KEY `projects_name_UNIQUE` (`projects_name`),
  UNIQUE KEY `projecst_address_UNIQUE` (`projects_address`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'NGCB Expansion Site','Luneta Hill, Baguio City','2017-07-12','2019-03-17','open'),(2,'SOGO Hotel Baguio','Engineers Hill, Baguio City','2018-03-06','2020-12-13','closed');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-13 13:17:12
