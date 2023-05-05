-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: apcsdb
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `privilegeLevel` tinyint DEFAULT NULL,
  `lastLoginDate` varchar(20) DEFAULT NULL,
  `blocked` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumber` int DEFAULT NULL,
  `discarded` tinyint DEFAULT NULL,
  `building` varchar(100) DEFAULT NULL,
  `roomNumber` varchar(10) DEFAULT NULL,
  `deliveredToRegistrationNumber` varchar(20) DEFAULT NULL,
  `lastDeliveryMadeBy` varchar(50) DEFAULT NULL,
  `lastDeliveryDate` varchar(10) DEFAULT NULL,
  `note` text,
  `standard` tinyint DEFAULT NULL,
  `serviceDate` varchar(10) DEFAULT NULL,
  `adRegistered` tinyint DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serialNumber` varchar(100) DEFAULT NULL,
  `processor` varchar(100) DEFAULT NULL,
  `ram` varchar(100) DEFAULT NULL,
  `storageSize` varchar(100) DEFAULT NULL,
  `operatingSystem` varchar(100) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  `inUse` tinyint DEFAULT NULL,
  `sealNumber` varchar(50) DEFAULT NULL,
  `tag` tinyint DEFAULT NULL,
  `macAddress` varchar(18) DEFAULT NULL,
  `ipAddress` varchar(16) DEFAULT NULL,
  `hwType` tinyint DEFAULT NULL,
  `fwVersion` varchar(100) DEFAULT NULL,
  `fwType` tinyint DEFAULT NULL,
  `storageType` varchar(100) DEFAULT NULL,
  `videoCard` varchar(100) DEFAULT NULL,
  `mediaOperationMode` tinyint DEFAULT NULL,
  `secureBoot` tinyint DEFAULT NULL,
  `virtualizationTechnology` tinyint DEFAULT NULL,
  `tpmVersion` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `registrationNumber` int DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phoneExtension` varchar(5) DEFAULT NULL,
  `phoneNumber` varchar(11) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `roomNumber` varchar(5) DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `maintenances`
--

DROP TABLE IF EXISTS `maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `previousServiceDates` varchar(10) DEFAULT NULL,
  `serviceType` tinyint DEFAULT NULL,
  `batteryChange` tinyint DEFAULT NULL,
  `ticketNumber` int DEFAULT NULL,
  `agentId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `fwVersion` varchar(100) DEFAULT NULL,
  `fwType` tinyint DEFAULT NULL,
  `tpmVersion` tinyint DEFAULT NULL,
  `mediaOperationMode` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-05  9:20:23
