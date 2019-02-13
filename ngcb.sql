-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
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
  `accounts_password` varchar(70) NOT NULL,
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
INSERT INTO `accounts` VALUES (1,'Ray','Servidad','admin','$2y$10$rklvP.megbM93JjCOJTwjea27Cdi/fp/bGd3zS9ltypKkRKV8Nsg.','Admin'),(2,'Harold','Vinluan','h_vinluan','$2y$10$zyzTlLHByz6wTIxnNI6tz.wErkL3iL3PEhSY2U4Rf9vFYaUViuPlO','View Only'),(3,'Mikka','Tuguinay','mikka_tuguinay19','$2y$10$JXX0lU4kxG3zZHXhnzB6kO3FuKLD.2/xPHwejwpTUpDEipt9tc2ye','Materials Engineer');
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
-- Table structure for table `hauling`
--

DROP TABLE IF EXISTS `hauling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hauling` (
  `hauling_id` int(11) NOT NULL AUTO_INCREMENT,
  `hauling_no` varchar(45) NOT NULL,
  `hauling_date` date NOT NULL,
  `hauling_deliverTo` varchar(45) NOT NULL,
  `hauling_hauledFrom` varchar(45) NOT NULL,
  `hauling_quantity` varchar(45) DEFAULT NULL,
  `hauling_unit` varchar(45) DEFAULT NULL,
  `hauling_articles` varchar(70) DEFAULT NULL,
  `hauling_hauledBy` varchar(45) DEFAULT NULL,
  `hauling_warehouseman` varchar(45) DEFAULT NULL,
  `hauling_approvedBy` varchar(45) DEFAULT NULL,
  `hauling_truckDetailsType` varchar(45) DEFAULT NULL,
  `hauling_truckDetailsPlateNo` varchar(45) DEFAULT NULL,
  `hauling_truckDetailsPO` varchar(45) DEFAULT NULL,
  `hauling_truckDetailsHaulerDR` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`hauling_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hauling`
--

LOCK TABLES `hauling` WRITE;
/*!40000 ALTER TABLE `hauling` DISABLE KEYS */;
/*!40000 ALTER TABLE `hauling` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `materials_id` int(11) NOT NULL AUTO_INCREMENT,
  `materials_name` varchar(45) NOT NULL,
  `mat_prevStock` int(11) DEFAULT NULL,
  `mat_deliveredMat` int(11) DEFAULT NULL,
  `mat_matPullOut` int(11) DEFAULT NULL,
  `mat_totalMatDelivered` int(11) DEFAULT NULL,
  `mat_matOnSite` int(11) DEFAULT NULL,
  `mat_project` varchar(100) NOT NULL,
  `mat_quantifier` varchar(45) NOT NULL,
  `mat_categ` varchar(50) NOT NULL,
  PRIMARY KEY (`materials_id`),
  UNIQUE KEY `materials_id_UNIQUE` (`materials_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (1,'A-Clamp Assymbly',42,0,0,42,42,'SM Baguio Expansion','pcs','Formworks'),(2,'Bolt & Nut 1/2x4 w/ washer',100,200,0,300,300,'SOGO Hotel Baguio','pcs','Formworks'),(3,'Grounding Wire 60mmsg',60,0,0,60,60,'SM Baguio Expansion Site','mtrs','Electrical'),(4,'THHN Wire 3.5mm2',1,2,0,3,3,'SOGO Hotel Baguio','rolls','Electrical'),(5,'Bushing 3\"',3,0,0,3,3,'SOGO Hotel Baguio','pcs','Plumbing'),(6,'PVC Pipe 3\" x 3m',1,0,0,1,1,'SM Baguio Expansion Site','pcs','Plumbing'),(7,'Cup Brush 4\"',0,50,0,50,50,'SOGO Hotel Baguio','pcs','Blades'),(8,'Cutting Disc 4\"',70,50,0,120,120,'SM Baguio Expansion Site','pcs','Blades'),(9,'Beam Hanger',249,627,0,876,876,'SM Baguio Expansion Site','pcs','Tableforms'),(10,'Table Form T1 (3.353 x 6.990)',10,13,0,23,23,'SOGO Hotel','pcs','Tableforms'),(11,'Christmas Gift',1,0,0,1,1,'SOGO Hotel','box','Others'),(12,'Anchor Bolt w/ Nut 20mm x 50mm',304,0,0,304,304,'SM Baguio Expansion Site','pcs','Others');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
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

--
-- Table structure for table `stockcards_deliveredin`
--

DROP TABLE IF EXISTS `stockcards_deliveredin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockcards_deliveredin` (
  `idstockCards_id` int(11) NOT NULL AUTO_INCREMENT,
  `stockCards_date` date NOT NULL,
  `stockCards_quantity` int(11) NOT NULL,
  `stockCards_unit` varchar(45) NOT NULL,
  `stockCards_suppliedBy` varchar(50) NOT NULL,
  PRIMARY KEY (`idstockCards_id`),
  UNIQUE KEY `idstockCards_id_UNIQUE` (`idstockCards_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockcards_deliveredin`
--

LOCK TABLES `stockcards_deliveredin` WRITE;
/*!40000 ALTER TABLE `stockcards_deliveredin` DISABLE KEYS */;
INSERT INTO `stockcards_deliveredin` VALUES (1,'2018-10-15',350,'pcs','Rimando Inc.'),(2,'2019-02-10',69,'set','Dela Peña Inc.');
/*!40000 ALTER TABLE `stockcards_deliveredin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stockcards_usagein`
--

DROP TABLE IF EXISTS `stockcards_usagein`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stockcards_usagein` (
  `stockCard_id` int(11) NOT NULL AUTO_INCREMENT,
  `stockCard_date` date NOT NULL,
  `stockCard_quantity` int(11) NOT NULL,
  `stockCard_unit` varchar(45) NOT NULL,
  `stockCards_PulledOutBy` varchar(45) NOT NULL,
  `stockCards_AreaOfUsage` varchar(45) NOT NULL,
  PRIMARY KEY (`stockCard_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stockcards_usagein`
--

LOCK TABLES `stockcards_usagein` WRITE;
/*!40000 ALTER TABLE `stockcards_usagein` DISABLE KEYS */;
INSERT INTO `stockcards_usagein` VALUES (1,'2018-11-23',3,'pcs','Laroza','SM B-up'),(2,'2018-11-24',45,'pcs','Dulce','PH-2'),(3,'2018-11-24',17,'pcs','Bisaya','PH-2 B-3'),(4,'2018-11-24',3,'pcs','Vinaya','Foot'),(5,'2018-11-24',59,'pcs','Pepito','B-up'),(6,'2018-11-24',69,'pcs','Pepito','PH-1 B-up');
/*!40000 ALTER TABLE `stockcards_usagein` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-13 21:37:17
