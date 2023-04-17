-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: patrimonio
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE="+00:00" */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(45) DEFAULT NULL,
  `model` varchar(45) DEFAULT NULL,
  `version` varchar(45) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `tpm` varchar(15) DEFAULT NULL,
  `mediaOp` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `funcionário`
--

DROP TABLE IF EXISTS `funcionário`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionário` (
  `id` int NOT NULL AUTO_INCREMENT,
  `regNum` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `extNum` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `course` varchar(45) DEFAULT NULL,
  `room` varchar(45) DEFAULT NULL,
  `faltas` int DEFAULT "0",
  `data_ultima_falta` varchar(10) DEFAULT NULL,
  `typeemployee` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=432 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `maintenances`
--

DROP TABLE IF EXISTS `maintenances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `maintenances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patrimonioFK` int DEFAULT NULL,
  `dataFormatacoesAnteriores` varchar(30) DEFAULT NULL,
  `modoServico` varchar(30) DEFAULT NULL,
  `changePilha` varchar(30) DEFAULT NULL,
  `ticketNum` int DEFAULT NULL,
  `agent` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1987 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `patrimonio`
--

DROP TABLE IF EXISTS `patrimonio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patrimonio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patrimonio` int DEFAULT NULL,
  `building` varchar(20) DEFAULT NULL,
  `room` varchar(10) DEFAULT NULL,
  `descricao` text,
  `namereceiver` varchar(50) DEFAULT NULL,
  `regNumreceiver` varchar(50) DEFAULT NULL,
  `extNum` varchar(15) DEFAULT NULL,
  `deliveryman` varchar(45) DEFAULT NULL,
  `deliveryDate` varchar(10) DEFAULT NULL,
  `note` text,
  `standard` varchar(15) DEFAULT "Funcionário",
  `serviceDate` varchar(10) DEFAULT NULL,
  `ad` varchar(5) DEFAULT NULL,
  `brand` varchar(30) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `serialNumber` varchar(50) DEFAULT NULL,
  `processor` varchar(100) DEFAULT NULL,
  `ram` varchar(50) DEFAULT NULL,
  `hd` varchar(30) DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `operatingSystem` varchar(70) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  `inUse` varchar(10) DEFAULT NULL,
  `sealNumber` varchar(30) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `mac` varchar(30) DEFAULT NULL,
  `ipAddress` varchar(30) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `model` varchar(40) DEFAULT NULL,
  `typeFW` varchar(10) DEFAULT NULL,
  `typeStorage` varchar(45) DEFAULT NULL,
  `gpu` varchar(100) DEFAULT NULL,
  `mediaOperationMode` varchar(45) DEFAULT NULL,
  `secBoot` varchar(45) DEFAULT NULL,
  `vt` varchar(45) DEFAULT NULL,
  `tpm` varchar(45) DEFAULT NULL,
  `changePilha` varchar(30) DEFAULT NULL,
  `ticketNum` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2041 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `status` int DEFAULT "0",
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-05 10:20:08
