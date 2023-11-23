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
-- Table structure for table `apcs_agent`
--

DROP TABLE IF EXISTS `apcs_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `privilegeLevel` tinyint DEFAULT NULL,
  `lastLoginDate` varchar(20) DEFAULT NULL,
  `blocked` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset`
--

DROP TABLE IF EXISTS `apcs_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumber` int DEFAULT NULL,
  `discarded` tinyint DEFAULT NULL,
  `standard` tinyint DEFAULT NULL,
  `adRegistered` tinyint DEFAULT NULL,
  `inUse` tinyint DEFAULT NULL,
  `sealNumber` varchar(50) DEFAULT NULL,
  `tag` tinyint DEFAULT NULL,
  `note` text,
  `assetHash` varchar(64) DEFAULT NULL,
  `hwHash` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_firmware`
--

DROP TABLE IF EXISTS `apcs_asset_firmware`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_firmware` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `version` varchar(100) DEFAULT NULL,
  `mediaOperationMode` tinyint DEFAULT NULL,
  `secureBoot` tinyint DEFAULT NULL,
  `virtualizationTechnology` tinyint DEFAULT NULL,
  `tpmVersion` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_hardware`
--

DROP TABLE IF EXISTS `apcs_asset_hardware`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_hardware` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serialNumber` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_location`
--

DROP TABLE IF EXISTS `apcs_asset_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `building` tinyint DEFAULT NULL,
  `roomNumber` varchar(10) DEFAULT NULL,
  `deliveredToRegistrationNumber` varchar(20) DEFAULT NULL,
  `lastDeliveryMadeBy` varchar(50) DEFAULT NULL,
  `lastDeliveryDate` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_maintenances`
--

DROP TABLE IF EXISTS `apcs_asset_maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_maintenances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `serviceDate` varchar(10) DEFAULT NULL,
  `serviceType` tinyint DEFAULT NULL,
  `batteryChange` tinyint DEFAULT NULL,
  `ticketNumber` int DEFAULT NULL,
  `agentId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_network`
--

DROP TABLE IF EXISTS `apcs_asset_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_network` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `macAddress` varchar(18) DEFAULT NULL,
  `ipAddress` varchar(16) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_operating_system`
--

DROP TABLE IF EXISTS `apcs_asset_operating_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_operating_system` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `version` varchar(25) DEFAULT NULL,
  `build` varchar(25) DEFAULT NULL,
  `arch` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_processor`
--

DROP TABLE IF EXISTS `apcs_asset_processor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_processor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `processorId` tinyint DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `frequency` int DEFAULT NULL,
  `numberOfCores` int DEFAULT NULL,
  `numberOfThreads` int DEFAULT NULL,
  `cache` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_ram`
--

DROP TABLE IF EXISTS `apcs_asset_ram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_ram` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `amount` bigint DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `frequency` int DEFAULT NULL,
  `serialNumber` varchar(100) DEFAULT NULL,
  `partNumber` varchar(100) DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `slot` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_storage`
--

DROP TABLE IF EXISTS `apcs_asset_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_storage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `storageId` tinyint DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `size` bigint DEFAULT NULL,
  `connection` tinyint DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serialNumber` varchar(100) DEFAULT NULL,
  `smartStatus` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_asset_video_card`
--

DROP TABLE IF EXISTS `apcs_asset_video_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_asset_video_card` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `vRam` bigint DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `videoCardId` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apcs_employee`
--

DROP TABLE IF EXISTS `apcs_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_employee` (
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
-- Table structure for table `apcs_model`
--

DROP TABLE IF EXISTS `apcs_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apcs_model` (
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

-- Dump completed on 2023-11-22 13:00:03
