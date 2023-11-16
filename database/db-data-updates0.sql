CREATE TABLE `apcsdb_old`.`apcs_agent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `role` tinyint DEFAULT NULL,
  `privilegeLevel` tinyint DEFAULT NULL,
  `lastLoginDate` varchar(20) DEFAULT NULL,
  `blocked` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset` (
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
);

CREATE TABLE `apcsdb_old`.`apcs_asset_firmware` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `version` varchar(100) DEFAULT NULL,
  `mediaOperationMode` tinyint DEFAULT NULL,
  `secureBoot` tinyint DEFAULT NULL,
  `virtualizationTechnology` tinyint DEFAULT NULL,
  `tpmVersion` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_hardware` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `type` tinyint DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serialNumber` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `building` tinyint DEFAULT NULL,
  `roomNumber` varchar(10) DEFAULT NULL,
  `deliveredToRegistrationNumber` varchar(20) DEFAULT NULL,
  `lastDeliveryMadeBy` varchar(50) DEFAULT NULL,
  `lastDeliveryDate` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_maintenances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `serviceDate` varchar(10) DEFAULT NULL,
  `serviceType` tinyint DEFAULT NULL,
  `batteryChange` tinyint DEFAULT NULL,
  `ticketNumber` int DEFAULT NULL,
  `agentId` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_network` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `macAddress` varchar(18) DEFAULT NULL,
  `ipAddress` varchar(16) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_operating_system` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `version` varchar(25) DEFAULT NULL,
  `build` varchar(25) DEFAULT NULL,
  `arch` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_processor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `processorId` tinyint DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `frequency` int DEFAULT NULL,
  `numberOfCores` int DEFAULT NULL,
  `numberOfThreads` int DEFAULT NULL,
  `cache` bigint DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_asset_ram` (
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
);

CREATE TABLE `apcsdb_old`.`apcs_asset_storage` (
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
);

CREATE TABLE `apcsdb_old`.`apcs_asset_video_card` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assetNumberFK` int DEFAULT NULL,
  `vRam` bigint DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `videoCardId` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `apcsdb_old`.`apcs_employee` (
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
);

CREATE TABLE `apcsdb_old`.`apcs_model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `fwVersion` varchar(100) DEFAULT NULL,
  `fwType` tinyint DEFAULT NULL,
  `tpmVersion` tinyint DEFAULT NULL,
  `mediaOperationMode` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
);

SET SQL_SAFE_UPDATES=0;
insert into apcsdb_old.apcs_asset_hardware (`assetNumberFK`,`brand`,`model`,`type`,`serialNumber`) select `assetNumber`,`brand`,`model`,`hwType`,`serialNumber` from apcsdb_old.asset;
insert into apcsdb_old.apcs_asset_firmware (`assetNumberFK`,`type`,`version`,`mediaOperationMode`,`secureBoot`,`virtualizationTechnology`,`tpmVersion`) select `assetNumber`,`fwType`,`fwVersion`,`mediaOperationMode`,`secureBoot`,`virtualizationTechnology`,`tpmVersion` from apcsdb_old.asset;
insert into apcsdb_old.apcs_asset_location (`assetNumberFK`,`building`,`roomNumber`,`deliveredToRegistrationNumber`,`lastDeliveryMadeBy`,`lastDeliveryDate`) select `assetNumber`,`building`,`roomNumber`,`deliveredToRegistrationNumber`,`lastDeliveryMadeBy`,`lastDeliveryDate` from apcsdb_old.asset;
insert into apcsdb_old.apcs_asset_maintenances (`assetNumberFK`,`serviceDate`,`serviceType`,`batteryChange`,`ticketNumber`,`agentId`) select `assetNumberFK`,`previousServiceDates`,`serviceType`,`batteryChange`,`ticketNumber`,`agentId` from apcsdb_old.maintenances;
insert into apcsdb_old.apcs_asset_network (`assetNumberFK`,`macAddress`,`ipAddress`,`hostname`) select `assetNumber`,`macAddress`,`ipAddress`,`hostname` from apcsdb_old.asset;
insert into apcsdb_old.apcs_asset_operating_system (`assetNumberFK`,`name`) select `assetNumber`,`operatingSystem` from apcsdb_old.asset;
insert into apcsdb_old.apcs_asset_processor (`assetNumberFK`,`cpu_id`,`name`) select `assetNumber`,"0",`processor` from apcsdb_old.asset;
insert into apcsdb_old.apcs_asset_ram (`assetNumberFK`,`amount`) select `assetNumber`,`ram` from apcsdb_old.asset;
update apcsdb_old.apcs_asset_ram set amount = amount * 1073741824;
insert into apcsdb_old.apcs_asset_video_card (`assetNumberFK`,`name`,`gpuId`) select `assetNumber`,`videoCard`,"0" from apcsdb_old.asset;
SET SQL_SAFE_UPDATES=1;