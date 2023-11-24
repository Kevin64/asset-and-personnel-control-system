CREATE TABLE `apcsdb_old`.`apcs_asset_processor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `processorId` TINYINT NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `frequency` INT NULL DEFAULT NULL,
  `numberOfCores` INT NULL DEFAULT NULL,
  `numberOfThreads` INT NULL DEFAULT NULL,
  `cache` BIGINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_ram` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `amount` BIGINT NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `frequency` INT NULL DEFAULT NULL,
  `serialNumber` VARCHAR(100) NULL DEFAULT NULL,
  `partNumber` VARCHAR(100) NULL DEFAULT NULL,
  `manufacturer` VARCHAR(100) NULL DEFAULT NULL,
  `slot` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_operating_system` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `version` VARCHAR(25) NULL DEFAULT NULL,
  `build` VARCHAR(25) NULL DEFAULT NULL,
  `arch` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `apcsdb_old`.`apcs_asset_firmware` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `version` VARCHAR(100) NULL DEFAULT NULL,
  `mediaOperationMode` TINYINT NULL DEFAULT NULL,
  `secureBoot` TINYINT NULL DEFAULT NULL,
  `virtualizationTechnology` TINYINT NULL DEFAULT NULL,
  `tpmVersion` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `building` TINYINT NULL DEFAULT NULL,
  `roomNumber` VARCHAR(10) NULL DEFAULT NULL,
  `deliveredToRegistrationNumber` VARCHAR(20) NULL DEFAULT NULL,
  `lastDeliveryMadeBy` VARCHAR(50) NULL DEFAULT NULL,
  `lastDeliveryDate` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_video_card` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `videoCardId` TINYINT NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `vRam` BIGINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_hardware` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `brand` VARCHAR(100) NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `model` VARCHAR(100) NULL DEFAULT NULL,
  `serialNumber` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_network` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `macAddress` VARCHAR(18) NULL DEFAULT NULL,
  `ipAddress` VARCHAR(16) NULL DEFAULT NULL,
  `hostname` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb_old`.`apcs_asset_storage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `storageId` TINYINT NULL DEFAULT NULL,
  `type` TINYINT NULL DEFAULT NULL,
  `size` BIGINT NULL DEFAULT NULL,
  `connection` TINYINT NULL DEFAULT NULL,
  `model` VARCHAR(100) NULL DEFAULT NULL,
  `serialNumber` VARCHAR(100) NULL DEFAULT NULL,
  `smartStatus` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `apcsdb_old`.`asset` 
RENAME TO  `apcsdb_old`.`apcs_asset` ;

ALTER TABLE `apcsdb_old`.`agent` 
RENAME TO  `apcsdb_old`.`apcs_agent` ;

ALTER TABLE `apcsdb_old`.`employee` 
RENAME TO  `apcsdb_old`.`apcs_employee` ;

ALTER TABLE `apcsdb_old`.`model` 
RENAME TO  `apcsdb_old`.`apcs_model` ;

ALTER TABLE `apcsdb_old`.`maintenances` 
RENAME TO  `apcsdb_old`.`apcs_asset_maintenances` ;

ALTER TABLE `apcsdb_old`.`apcs_agent` 
ADD COLUMN `name` VARCHAR(45) NULL DEFAULT NULL AFTER `password`,
ADD COLUMN `surname` VARCHAR(45) NULL DEFAULT NULL AFTER `name`;

ALTER TABLE `apcsdb_old`.`apcs_asset` 
ADD COLUMN `assetHash` VARCHAR(64) NULL DEFAULT NULL AFTER `note`,
ADD COLUMN `hwHash` VARCHAR(64) NULL DEFAULT NULL AFTER `assethash`;

ALTER TABLE `apcsdb_old`.`apcs_asset_maintenances` 
CHANGE COLUMN `previousServiceDates` `serviceDate` VARCHAR(10) NULL DEFAULT NULL ;
--------------------------------------------------------
SET SQL_SAFE_UPDATES=0;
#--------------------------------------------------------------------------------------------#
insert into apcsdb_old.apcs_asset_hardware (`assetNumberFK`,`brand`,`model`,`type`,`serialNumber`) select `assetNumber`,`brand`,`model`,`hwType`,`serialNumber` from apcsdb_old.apcs_asset;
#--------------------------------------------------------------------------------------------#
insert into apcsdb_old.apcs_asset_firmware (`assetNumberFK`,`type`,`version`,`mediaOperationMode`,`secureBoot`,`virtualizationTechnology`,`tpmVersion`) select `assetNumber`,`fwType`,`fwVersion`,`mediaOperationMode`,`secureBoot`,`virtualizationTechnology`,`tpmVersion` from apcsdb_old.apcs_asset;
#--------------------------------------------------------------------------------------------#
insert into apcsdb_old.apcs_asset_location (`assetNumberFK`,`building`,`roomNumber`,`deliveredToRegistrationNumber`,`lastDeliveryMadeBy`,`lastDeliveryDate`) select `assetNumber`,`building`,`roomNumber`,`deliveredToRegistrationNumber`,`lastDeliveryMadeBy`,`lastDeliveryDate` from apcsdb_old.apcs_asset;
#--------------------------------------------------------------------------------------------#
#insert into apcsdb_old.apcs_asset_maintenances (`assetNumberFK`,`serviceDate`,`serviceType`,`batteryChange`,`ticketNumber`,`agentId`) select `assetNumberFK`,`previousServiceDates`,`serviceType`,`batteryChange`,`ticketNumber`,`agentId` from apcsdb_old.apcs_maintenances;
#--------------------------------------------------------------------------------------------#
insert into apcsdb_old.apcs_asset_network (`assetNumberFK`,`macAddress`,`ipAddress`,`hostname`) select `assetNumber`,`macAddress`,`ipAddress`,`hostname` from apcsdb_old.apcs_asset;
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb_old.apcs_asset_operating_system (`assetNumberFK`,`name`,`build`,`version`,`arch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'0' FROM apcs_asset WHERE operatingSystem LIKE '%32 bits';
insert IGNORE into apcsdb_old.apcs_asset_operating_system (`assetNumberFK`,`name`,`build`,`version`,`arch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'0' FROM apcs_asset WHERE operatingSystem LIKE '%86)';
insert IGNORE into apcsdb_old.apcs_asset_operating_system (`assetNumberFK`,`name`,`build`,`version`,`arch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'1' FROM apcs_asset WHERE operatingSystem LIKE '%64 bits';
insert IGNORE into apcsdb_old.apcs_asset_operating_system (`assetNumberFK`,`name`,`build`,`version`,`arch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'1' FROM apcs_asset WHERE operatingSystem LIKE '%64)';
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb_old.apcs_asset_processor (`assetNumberFK`,`processorId`,`name`,`frequency`,`numberOfCores`,`numberOfThreads`) SELECT `assetNumber`, '0',`processor`, cast(substring_index(SUBSTRING_INDEX(`processor`, ' MHz', 1),' ', -1) as unsigned), cast(substring_index(SUBSTRING_INDEX(`processor`, 'C/', 1),'(', -1) as unsigned), cast(substring_index(SUBSTRING_INDEX(`processor`, 'T)', 1),'/', -1) as unsigned) FROM `apcsdb_old`.`apcs_asset`;
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb_old.apcs_asset_ram (`assetNumberFK`,`amount`,`type`,`frequency`,`slot`) select `assetNumber`, substring_index(`ram`, ' ', 1), '24', substring_index(substring_index(`ram`, 'MHz', 1), ' ', -1), '0' from apcsdb_old.apcs_asset where `ram` like '%DDR3%';
insert IGNORE into apcsdb_old.apcs_asset_ram (`assetNumberFK`,`amount`,`type`,`frequency`,`slot`) select `assetNumber`, substring_index(`ram`, ' ', 1), '22', substring_index(substring_index(`ram`, 'MHz', 1), ' ', -1), '0' from apcsdb_old.apcs_asset where `ram` like '%DDR2%';
insert IGNORE into apcsdb_old.apcs_asset_ram (`assetNumberFK`,`amount`,`type`,`frequency`,`slot`) select `assetNumber`, substring_index(`ram`, ' ', 1), '26', substring_index(substring_index(`ram`, 'MHz', 1), ' ', -1), '0' from apcsdb_old.apcs_asset where `ram` like '%DDR4%';
update apcsdb_old.apcs_asset_ram set amount = amount * 1073741824;
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb_old.apcs_asset_video_card (`assetNumberFK`,`name`,`videoCardId`,`vRam`) SELECT `assetNumber`, `videoCard`, '0', substring_index(substring_index(SUBSTRING_INDEX(`videoCard`, '%B)', 1),'(', -1), ' ', 1) FROM `apcsdb_old`.`apcs_asset` WHERE videoCard LIKE '%GB)';
update apcsdb_old.apcs_asset_video_card set vRam = vRam * 1073741824 WHERE `name` LIKE '%GB)';
insert IGNORE into apcsdb_old.apcs_asset_video_card (`assetNumberFK`,`name`,`videoCardId`,`vRam`) SELECT `assetNumber`, `videoCard`, '0', substring_index(substring_index(SUBSTRING_INDEX(`videoCard`, '%B)', 1),'(', -1), ' ', 1) FROM `apcsdb_old`.`apcs_asset` WHERE videoCard LIKE '%MB)';
update apcsdb_old.apcs_asset_video_card set vRam = vRam * 1048576 WHERE `name` LIKE '%MB)';
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb_old.apcs_asset_storage (`assetNumberFK`,`size`,`smartStatus`,`storageId`) select `assetNumber`, replace(substring_index(`storageSize`,' ', 1), ',', '.')*1000000000000.0,'0','0' from apcsdb_old.apcs_asset WHERE `storageSize` like '%,%';
insert IGNORE into apcsdb_old.apcs_asset_storage (`assetNumberFK`,`size`,`smartStatus`,`storageId`) select `assetNumber`, replace(substring_index(`storageSize`,' ', 1), ',', '.')*1000000000,'0','0' from apcsdb_old.apcs_asset WHERE `storageSize` not like '%,%' and `storageSize` not like '%1 %' and `storageSize` not like '%2 %' and `storageSize` not like '%3 %' and `storageSize` not like '%4 %';


SET SQL_SAFE_UPDATES=1;

ALTER TABLE `apcsdb_old`.`apcs_asset` 
DROP COLUMN `tpmVersion`,
DROP COLUMN `virtualizationTechnology`,
DROP COLUMN `secureBoot`,
DROP COLUMN `mediaOperationMode`,
DROP COLUMN `videoCard`,
DROP COLUMN `fwType`,
DROP COLUMN `fwVersion`,
DROP COLUMN `hwType`,
DROP COLUMN `ipAddress`,
DROP COLUMN `macAddress`,
DROP COLUMN `hostname`,
DROP COLUMN `operatingSystem`,
DROP COLUMN `ram`,
DROP COLUMN `processor`,
DROP COLUMN `serialNumber`,
DROP COLUMN `model`,
DROP COLUMN `brand`,
DROP COLUMN `serviceDate`,
DROP COLUMN `lastDeliveryDate`,
DROP COLUMN `lastDeliveryMadeBy`,
DROP COLUMN `deliveredToRegistrationNumber`,
DROP COLUMN `roomNumber`,
DROP COLUMN `building`,
DROP COLUMN `storageSize`,
DROP COLUMN `storageType`;