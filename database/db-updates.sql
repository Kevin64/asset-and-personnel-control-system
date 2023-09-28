CREATE TABLE `apcsdb`.`apcs_asset_ram` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `amount` INT NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `frequency` INT NULL DEFAULT NULL,
  `occupiedSlots` TINYINT NULL DEFAULT NULL,
  `totalSlots` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `apcsdb`.`apcs_asset_operating_system` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `name` VARCHAR(50) NULL DEFAULT NULL,
  `version` VARCHAR(25) NULL DEFAULT NULL,
  `build` VARCHAR(25) NULL DEFAULT NULL,
  `arch` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `apcsdb`.`apcs_asset_firmware` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `fwType` TINYINT NULL DEFAULT NULL,
  `fwVersion` VARCHAR(100) NULL DEFAULT NULL,
  `mediaOperationMode` TINYINT NULL DEFAULT NULL,
  `secureBoot` TINYINT NULL DEFAULT NULL,
  `virtualizationTechnology` TINYINT NULL DEFAULT NULL,
  `tpmVersion` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `building` TINYINT NULL DEFAULT NULL,
  `roomNumber` VARCHAR(10) NULL DEFAULT NULL,
  `deliveredToRegistrationNumber` VARCHAR(20) NULL DEFAULT NULL,
  `lastDeliveryMadeBy` VARCHAR(50) NULL DEFAULT NULL,
  `lastDeliveryDate` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_video_card` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `gpuId` TINYINT NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `vRam` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_hardware` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `brand` VARCHAR(100) NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `model` VARCHAR(100) NULL DEFAULT NULL,
  `processor` VARCHAR(100) NULL DEFAULT NULL,
  `serialNumber` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_network` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `macAddress` VARCHAR(18) NULL DEFAULT NULL,
  `ipAddress` VARCHAR(16) NULL DEFAULT NULL,
  `hostname` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));





CREATE TABLE `apcsdb`.`apcs_asset_storage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `storageId` TINYINT NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `size` BIGINT NULL DEFAULT NULL,
  `connection` TINYINT NULL DEFAULT NULL,
  `model` VARCHAR(100) NULL DEFAULT NULL,
  `serialNumber` VARCHAR(100) NULL DEFAULT NULL,
  `smartStatus` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));



ALTER TABLE `apcsdb`.`asset` 
CHANGE COLUMN `ram` `ramAmount` INT NULL DEFAULT NULL ;
CHANGE COLUMN `storageType` `storageSummary` VARCHAR(100) NULL DEFAULT NULL ;
ADD COLUMN `ramType` TINYINT NULL DEFAULT NULL AFTER `ramAmount`,
ADD COLUMN `ramFrequency` INT NULL DEFAULT NULL AFTER `ramType`,
ADD COLUMN `ramTotalSlots` TINYINT NULL DEFAULT NULL AFTER `ramFrequency`,
ADD COLUMN `ramOccupiedSlots` TINYINT NULL DEFAULT NULL AFTER `totalRamSlots`,
CHANGE COLUMN `storageSize` `storageTotalSize` INT NULL DEFAULT NULL ;
UPDATE apcsdb.asset SET ramAmount=ramAmount*1024;
RENAME TO  `apcsdb`.`apcs_asset` ;

ALTER TABLE `apcsdb`.`agent` 
RENAME TO  `apcsdb`.`apcs_agent` ;

ALTER TABLE `apcsdb`.`employee` 
RENAME TO  `apcsdb`.`apcs_employee` ;

ALTER TABLE `apcsdb`.`maintenances` 
RENAME TO  `apcsdb`.`apcs_maintenances` ;

ALTER TABLE `apcsdb`.`model` 
RENAME TO  `apcsdb`.`apcs_model` ;

ALTER TABLE `apcsdb`.`apcs_asset` 
ADD COLUMN `operatingSystemVersion` VARCHAR(20) NULL DEFAULT NULL AFTER `operatingSystemName`,
ADD COLUMN `operatingSystemBuild` VARCHAR(20) NULL DEFAULT NULL AFTER `operatingSystemVersion`,
ADD COLUMN `operatingSystemArch` INT NULL DEFAULT NULL AFTER `operatingSystemBuild`,
CHANGE COLUMN `operatingSystem` `operatingSystemName` VARCHAR(20) NULL DEFAULT NULL ;

ALTER TABLE `apcsdb`.`apcs_asset` 
ADD COLUMN `videoCardRam` INT NULL DEFAULT NULL AFTER `videoCardName`,
CHANGE COLUMN `videoCard` `videoCardName` VARCHAR(100) NULL DEFAULT NULL ;

ALTER TABLE `apcsdb`.`apcs_maintenances` 
RENAME TO  `apcsdb`.`apcs_asset_maintenances` ;

ALTER TABLE `apcsdb`.`apcs_asset_firmware` 
CHANGE COLUMN `fwType` `type` TINYINT NULL DEFAULT NULL ,
CHANGE COLUMN `fwVersion` `version` VARCHAR(100) NULL DEFAULT NULL ;

ALTER TABLE `apcsdb`.`apcs_asset_maintenances` 
CHANGE COLUMN `previousServiceDates` `serviceDate` VARCHAR(10) NULL DEFAULT NULL ;







ALTER TABLE `apcsdb`.`apcs_asset` 
DROP COLUMN `tpmVersion`,
DROP COLUMN `virtualizationTechnology`,
DROP COLUMN `secureBoot`,
DROP COLUMN `mediaOperationMode`,
DROP COLUMN `videoCardRam`,
DROP COLUMN `videoCardName`,
DROP COLUMN `fwType`,
DROP COLUMN `fwVersion`,
DROP COLUMN `hwType`,
DROP COLUMN `ipAddress`,
DROP COLUMN `macAddress`,
DROP COLUMN `hostname`,
DROP COLUMN `operatingSystemArch`,
DROP COLUMN `operatingSystemBuild`,
DROP COLUMN `operatingSystemVersion`,
DROP COLUMN `operatingSystemName`,
DROP COLUMN `ramOccupiedSlots`,
DROP COLUMN `ramTotalSlots`,
DROP COLUMN `ramFrequency`,
DROP COLUMN `ramType`,
DROP COLUMN `ramAmount`,
DROP COLUMN `processor`,
DROP COLUMN `serialNumber`,
DROP COLUMN `model`,
DROP COLUMN `brand`,
DROP COLUMN `serviceDateOld`,
DROP COLUMN `lastDeliveryDate`,
DROP COLUMN `lastDeliveryMadeBy`,
DROP COLUMN `deliveredToRegistrationNumber`,
DROP COLUMN `roomNumber`,
DROP COLUMN `building`;
DROP COLUMN `storageTotalSize`;

ALTER TABLE `apcsdb`.`apcs_employee` 
CHANGE COLUMN `roomNumber` `room` VARCHAR(5) NULL DEFAULT NULL ;
