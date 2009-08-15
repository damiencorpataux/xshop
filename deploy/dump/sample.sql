-- MySQL dump 10.11
--
-- Host: localhost    Database: xshop
-- ------------------------------------------------------
-- Server version	5.0.51a-24+lenny1

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
-- Table structure for table `Category`
--

DROP TABLE IF EXISTS `Category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Category` (
  `id` int(11) NOT NULL auto_increment,
  `fk_category_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Category`
--

LOCK TABLES `Category` WRITE;
/*!40000 ALTER TABLE `Category` DISABLE KEYS */;
/*!40000 ALTER TABLE `Category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Category_Product`
--

DROP TABLE IF EXISTS `Category_Product`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Category_Product` (
  `fk_category_id` int(11) NOT NULL,
  `fk_product_id` int(11) NOT NULL,
  PRIMARY KEY  (`fk_category_id`,`fk_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Category_Product`
--

LOCK TABLES `Category_Product` WRITE;
/*!40000 ALTER TABLE `Category_Product` DISABLE KEYS */;
/*!40000 ALTER TABLE `Category_Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Category_description`
--

DROP TABLE IF EXISTS `Category_description`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Category_description` (
  `fk_category_id` int(11) NOT NULL,
  `lang` varchar(2) collate utf8_unicode_ci NOT NULL,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
  `description` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`fk_category_id`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Category_description`
--

LOCK TABLES `Category_description` WRITE;
/*!40000 ALTER TABLE `Category_description` DISABLE KEYS */;
/*!40000 ALTER TABLE `Category_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Customer`
--

DROP TABLE IF EXISTS `Customer`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Customer` (
  `id` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `email` varchar(255) collate utf8_unicode_ci NOT NULL,
  `lang` varchar(2) collate utf8_unicode_ci NOT NULL default 'en',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_2` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Customer`
--

LOCK TABLES `Customer` WRITE;
/*!40000 ALTER TABLE `Customer` DISABLE KEYS */;
INSERT INTO `Customer` VALUES (0,'2009-08-14 21:45:39','d@mien.ch','en');
/*!40000 ALTER TABLE `Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Customer_address`
--

DROP TABLE IF EXISTS `Customer_address`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Customer_address` (
  `id` int(11) NOT NULL auto_increment,
  `fk_customer_id` int(11) NOT NULL,
  `compliment` varchar(24) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  `surname` varchar(255) collate utf8_unicode_ci NOT NULL,
  `street` varchar(255) collate utf8_unicode_ci NOT NULL,
  `street_complement` varchar(255) collate utf8_unicode_ci default NULL,
  `zip` varchar(12) collate utf8_unicode_ci NOT NULL,
  `city` varchar(64) collate utf8_unicode_ci NOT NULL,
  `state` varchar(64) collate utf8_unicode_ci NOT NULL,
  `country` varchar(64) collate utf8_unicode_ci NOT NULL,
  `cellphone` varchar(32) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Customer_address`
--

LOCK TABLES `Customer_address` WRITE;
/*!40000 ALTER TABLE `Customer_address` DISABLE KEYS */;
INSERT INTO `Customer_address` VALUES (1,1,'Monsieur','Damien','Corpataux','Av. de Villardin 8b',NULL,'1009','Pully','VD','Suisse','+41 79 321 32 01');
/*!40000 ALTER TABLE `Customer_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order`
--

DROP TABLE IF EXISTS `Order`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Order` (
  `id` int(11) NOT NULL auto_increment,
  `creation_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ordered_date` timestamp NULL default NULL,
  `processed_date` timestamp NULL default NULL,
  `cancelled_date` timestamp NULL default NULL,
  `fk_customer_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Order`
--

LOCK TABLES `Order` WRITE;
/*!40000 ALTER TABLE `Order` DISABLE KEYS */;
INSERT INTO `Order` VALUES (116,'2009-08-15 19:19:27',NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `Order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Order_Product`
--

DROP TABLE IF EXISTS `Order_Product`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Order_Product` (
  `fk_order_id` int(11) NOT NULL,
  `fk_product_id` int(11) NOT NULL,
  `quantity` smallint(6) NOT NULL default '1',
  `add_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`fk_order_id`,`fk_product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Order_Product`
--

LOCK TABLES `Order_Product` WRITE;
/*!40000 ALTER TABLE `Order_Product` DISABLE KEYS */;
/*!40000 ALTER TABLE `Order_Product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Products` (
  `id` int(11) NOT NULL auto_increment,
  `creation_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL default '1',
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `measure_unit` varchar(2) collate utf8_unicode_ci NOT NULL,
  `picturefile` varchar(128) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (1,'2009-08-08 20:24:19',1,10.95,25,3,'g','1.jpg'),(2,'2009-08-08 21:12:32',1,49.95,5,100,'g','2.jpg');
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products_custom`
--

DROP TABLE IF EXISTS `Products_custom`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Products_custom` (
  `fk_product_id` int(11) NOT NULL,
  `gluten_free` tinyint(1) NOT NULL,
  `lactose_free` tinyint(1) NOT NULL,
  `cholesterol_free` tinyint(1) NOT NULL,
  PRIMARY KEY  (`fk_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Products_custom`
--

LOCK TABLES `Products_custom` WRITE;
/*!40000 ALTER TABLE `Products_custom` DISABLE KEYS */;
INSERT INTO `Products_custom` VALUES (1,1,1,0),(2,1,0,1);
/*!40000 ALTER TABLE `Products_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products_description`
--

DROP TABLE IF EXISTS `Products_description`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Products_description` (
  `fk_product_id` int(11) NOT NULL,
  `lang` varchar(2) collate utf8_unicode_ci NOT NULL,
  `name` varchar(32) collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`fk_product_id`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Products_description`
--

LOCK TABLES `Products_description` WRITE;
/*!40000 ALTER TABLE `Products_description` DISABLE KEYS */;
INSERT INTO `Products_description` VALUES (1,'de','Testprodukt','Dieser Produkt soll hier nicht anschauen'),(1,'en','Test product','This product belongs to the test assets and should not show up here'),(1,'fr','Produit de test','Ce produit ne devrait pas etre affiche ici car il fait partie l\'assortiment de test'),(2,'fr','Autre produit de test','Ce produit est un produit de test qui ne devrait pas apparaitre ici');
/*!40000 ALTER TABLE `Products_description` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-08-15 20:03:15
