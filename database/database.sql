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
-- Table structure for table `bios`
--

DROP TABLE IF EXISTS `bios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(45) DEFAULT NULL,
  `modelo` varchar(45) DEFAULT NULL,
  `versao` varchar(45) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `tpm` varchar(15) DEFAULT NULL,
  `mediaOp` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siape` varchar(45) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `ramal` varchar(45) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `curso` varchar(45) DEFAULT NULL,
  `sala` varchar(45) DEFAULT NULL,
  `faltas` int DEFAULT "0",
  `data_ultima_falta` varchar(10) DEFAULT NULL,
  `tipoServidor` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=432 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manutencoes`
--

DROP TABLE IF EXISTS `manutencoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manutencoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patrimonioFK` int DEFAULT NULL,
  `dataFormatacoesAnteriores` varchar(30) DEFAULT NULL,
  `modoServico` varchar(30) DEFAULT NULL,
  `trocaPilha` varchar(30) DEFAULT NULL,
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
  `predio` varchar(20) DEFAULT NULL,
  `sala` varchar(10) DEFAULT NULL,
  `descricao` text,
  `nomeRecebedor` varchar(50) DEFAULT NULL,
  `siapeRecebedor` varchar(50) DEFAULT NULL,
  `ramal` varchar(15) DEFAULT NULL,
  `entregador` varchar(45) DEFAULT NULL,
  `dataEntrega` varchar(10) DEFAULT NULL,
  `observacao` text,
  `padrao` varchar(15) DEFAULT "Funcionário",
  `dataFormatacao` varchar(10) DEFAULT NULL,
  `ad` varchar(5) DEFAULT NULL,
  `marca` varchar(30) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `numSerie` varchar(50) DEFAULT NULL,
  `processador` varchar(100) DEFAULT NULL,
  `memoria` varchar(50) DEFAULT NULL,
  `hd` varchar(30) DEFAULT NULL,
  `idUsuario` int DEFAULT NULL,
  `sistemaOperacional` varchar(70) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  `emUso` varchar(10) DEFAULT NULL,
  `lacre` varchar(30) DEFAULT NULL,
  `etiqueta` varchar(10) DEFAULT NULL,
  `mac` varchar(30) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `bios` varchar(40) DEFAULT NULL,
  `tipoFW` varchar(10) DEFAULT NULL,
  `tipoArmaz` varchar(45) DEFAULT NULL,
  `gpu` varchar(100) DEFAULT NULL,
  `modoArmaz` varchar(45) DEFAULT NULL,
  `secBoot` varchar(45) DEFAULT NULL,
  `vt` varchar(45) DEFAULT NULL,
  `tpm` varchar(45) DEFAULT NULL,
  `trocaPilha` varchar(30) DEFAULT NULL,
  `ticketNum` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2041 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `nivel` varchar(5) DEFAULT NULL,
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
