CREATE TABLE `apcsdb`.`apcs_asset_processor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `procId` TINYINT NULL DEFAULT NULL,
  `procName` VARCHAR(100) NULL DEFAULT NULL,
  `procFrequency` INT NULL DEFAULT NULL,
  `procNumberOfCores` INT NULL DEFAULT NULL,
  `procNumberOfThreads` INT NULL DEFAULT NULL,
  `procCache` BIGINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_ram` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `ramAmount` BIGINT NULL DEFAULT NULL,
  `ramType` TINYINT NULL DEFAULT NULL,
  `ramFrequency` INT NULL DEFAULT NULL,
  `ramSerialNumber` VARCHAR(100) NULL DEFAULT NULL,
  `ramPartNumber` VARCHAR(100) NULL DEFAULT NULL,
  `ramManufacturer` VARCHAR(100) NULL DEFAULT NULL,
  `ramSlot` VARCHAR(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_operating_system` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `osName` VARCHAR(100) NULL DEFAULT NULL,
  `osVersion` VARCHAR(25) NULL DEFAULT NULL,
  `osBuild` VARCHAR(25) NULL DEFAULT NULL,
  `osArch` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE `apcsdb`.`apcs_asset_firmware` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `fwType` TINYINT NULL DEFAULT NULL,
  `fwVersion` VARCHAR(100) NULL DEFAULT NULL,
  `fwMediaOperationMode` TINYINT NULL DEFAULT NULL,
  `fwSecureBoot` TINYINT NULL DEFAULT NULL,
  `fwVirtualizationTechnology` TINYINT NULL DEFAULT NULL,
  `fwTpmVersion` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_location` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `locBuilding` TINYINT NULL DEFAULT NULL,
  `locRoomNumber` VARCHAR(10) NULL DEFAULT NULL,
  `locDeliveredToRegistrationNumber` VARCHAR(20) NULL DEFAULT NULL,
  `locLastDeliveryMadeBy` VARCHAR(50) NULL DEFAULT NULL,
  `locLastDeliveryDate` VARCHAR(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_video_card` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `vcId` TINYINT NULL DEFAULT NULL,
  `vcName` VARCHAR(100) NULL DEFAULT NULL,
  `vcRam` BIGINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_hardware` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `hwBrand` VARCHAR(100) NULL DEFAULT NULL,
  `hwType` TINYINT NULL DEFAULT NULL,
  `hwModel` VARCHAR(100) NULL DEFAULT NULL,
  `hwSerialNumber` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_network` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `netMacAddress` VARCHAR(18) NULL DEFAULT NULL,
  `netIpAddress` VARCHAR(16) NULL DEFAULT NULL,
  `netHostname` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `apcsdb`.`apcs_asset_storage` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `assetNumberFK` INT NULL DEFAULT NULL,
  `storId` TINYINT NULL DEFAULT NULL,
  `storType` TINYINT NULL DEFAULT NULL,
  `storSize` BIGINT NULL DEFAULT NULL,
  `storConnection` TINYINT NULL DEFAULT NULL,
  `storModel` VARCHAR(100) NULL DEFAULT NULL,
  `storSerialNumber` VARCHAR(100) NULL DEFAULT NULL,
  `storSmartStatus` TINYINT NULL DEFAULT NULL,
  PRIMARY KEY (`id`));

ALTER TABLE `apcsdb`.`asset` 
RENAME TO  `apcsdb`.`apcs_asset` ;

ALTER TABLE `apcsdb`.`agent` 
RENAME TO  `apcsdb`.`apcs_agent` ;

ALTER TABLE `apcsdb`.`employee` 
RENAME TO  `apcsdb`.`apcs_employee` ;

ALTER TABLE `apcsdb`.`model` 
RENAME TO  `apcsdb`.`apcs_model` ;

ALTER TABLE `apcsdb`.`maintenances` 
RENAME TO  `apcsdb`.`apcs_asset_maintenances` ;

ALTER TABLE `apcsdb`.`apcs_agent` 
ADD COLUMN `name` VARCHAR(45) NULL DEFAULT NULL AFTER `password`,
ADD COLUMN `surname` VARCHAR(45) NULL DEFAULT NULL AFTER `name`;

ALTER TABLE `apcsdb`.`apcs_asset` 
ADD COLUMN `assetHash` VARCHAR(64) NULL DEFAULT NULL AFTER `note`,
ADD COLUMN `hwHash` VARCHAR(64) NULL DEFAULT NULL AFTER `assethash`;

ALTER TABLE `apcsdb`.`apcs_asset_maintenances` 
CHANGE COLUMN `previousServiceDates` `mainServiceDate` VARCHAR(10) NULL DEFAULT NULL ,
CHANGE COLUMN `serviceType` `mainServiceType` TINYINT NULL DEFAULT NULL ,
CHANGE COLUMN `batteryChange` `mainBatteryChange` TINYINT NULL DEFAULT NULL ,
CHANGE COLUMN `ticketNumber` `mainTicketNumber` INT NULL DEFAULT NULL ,
CHANGE COLUMN `agentId` `mainAgentId` INT NULL DEFAULT NULL ;
--------------------------------------------------------
SET SQL_SAFE_UPDATES=0;
#--------------------------------------------------------------------------------------------#
insert into apcsdb.apcs_asset_hardware (`assetNumberFK`,`hwBrand`,`hwModel`,`hwType`,`hwSerialNumber`) select `assetNumber`,`brand`,`model`,`hwType`,`serialNumber` from apcsdb.apcs_asset;
#--------------------------------------------------------------------------------------------#
insert into apcsdb.apcs_asset_firmware (`assetNumberFK`,`fwType`,`fwVersion`,`fwMediaOperationMode`,`fwSecureBoot`,`fwVirtualizationTechnology`,`fwTpmVersion`) select `assetNumber`,`fwType`,`fwVersion`,`mediaOperationMode`,`secureBoot`,`virtualizationTechnology`,`tpmVersion` from apcsdb.apcs_asset;
#--------------------------------------------------------------------------------------------#
insert into apcsdb.apcs_asset_location (`assetNumberFK`,`locBuilding`,`locRoomNumber`,`locDeliveredToRegistrationNumber`,`locLastDeliveryMadeBy`,`locLastDeliveryDate`) select `assetNumber`,`building`,`roomNumber`,`deliveredToRegistrationNumber`,`lastDeliveryMadeBy`,`lastDeliveryDate` from apcsdb.apcs_asset;
#--------------------------------------------------------------------------------------------#
#insert into apcsdb.apcs_asset_maintenances (`assetNumberFK`,`mainServiceDate`,`mainServiceType`,`mainBatteryChange`,`mainTicketNumber`,`mainAgentId`) select `assetNumberFK`,`previousServiceDates`,`serviceType`,`batteryChange`,`ticketNumber`,`agentId` from apcsdb.apcs_maintenances;
#--------------------------------------------------------------------------------------------#
insert into apcsdb.apcs_asset_network (`assetNumberFK`,`netMacAddress`,`netIpAddress`,`netHostname`) select `assetNumber`,`macAddress`,`ipAddress`,`hostname` from apcsdb.apcs_asset;
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb.apcs_asset_operating_system (`assetNumberFK`,`osName`,`osBuild`,`osVersion`,`osArch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'0' FROM apcs_asset WHERE operatingSystem LIKE '%32 bits';
insert IGNORE into apcsdb.apcs_asset_operating_system (`assetNumberFK`,`osName`,`osBuild`,`osVersion`,`osArch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'0' FROM apcs_asset WHERE operatingSystem LIKE '%86)';
insert IGNORE into apcsdb.apcs_asset_operating_system (`assetNumberFK`,`osName`,`osBuild`,`osVersion`,`osArch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'1' FROM apcs_asset WHERE operatingSystem LIKE '%64 bits';
insert IGNORE into apcsdb.apcs_asset_operating_system (`assetNumberFK`,`osName`,`osBuild`,`osVersion`,`osArch`) SELECT `assetNumber`,SUBSTRING_INDEX(`operatingSystem`, ',', 1), substring_index(substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 3),'build ', -1), ' ', 1), substring_index(SUBSTRING_INDEX(`operatingSystem`, ',', 2),'v', -1),'1' FROM apcs_asset WHERE operatingSystem LIKE '%64)';
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb.apcs_asset_processor (`assetNumberFK`,`procId`,`procName`,`procFrequency`,`procNumberOfCores`,`procNumberOfThreads`) SELECT `assetNumber`, '0',`processor`, cast(substring_index(SUBSTRING_INDEX(`processor`, ' MHz', 1),' ', -1) as unsigned), cast(substring_index(SUBSTRING_INDEX(`processor`, 'C/', 1),'(', -1) as unsigned), cast(substring_index(SUBSTRING_INDEX(`processor`, 'T)', 1),'/', -1) as unsigned) FROM `apcsdb`.`apcs_asset`;
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb.apcs_asset_ram (`assetNumberFK`,`ramAmount`,`ramType`,`ramFrequency`,`ramSlot`) select `assetNumber`, substring_index(`ram`, ' ', 1), '24', substring_index(substring_index(`ram`, 'MHz', 1), ' ', -1), '0' from apcsdb.apcs_asset where `ram` like '%DDR3%';
insert IGNORE into apcsdb.apcs_asset_ram (`assetNumberFK`,`ramAmount`,`ramType`,`ramFrequency`,`ramSlot`) select `assetNumber`, substring_index(`ram`, ' ', 1), '22', substring_index(substring_index(`ram`, 'MHz', 1), ' ', -1), '0' from apcsdb.apcs_asset where `ram` like '%DDR2%';
insert IGNORE into apcsdb.apcs_asset_ram (`assetNumberFK`,`ramAmount`,`ramType`,`ramFrequency`,`ramSlot`) select `assetNumber`, substring_index(`ram`, ' ', 1), '26', substring_index(substring_index(`ram`, 'MHz', 1), ' ', -1), '0' from apcsdb.apcs_asset where `ram` like '%DDR4%';
update apcsdb.apcs_asset_ram set ramAmount = ramAmount * 1073741824;
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb.apcs_asset_video_card (`assetNumberFK`,`vcName`,`vcId`,`vcRam`) SELECT `assetNumber`, `videoCard`, '0', substring_index(substring_index(SUBSTRING_INDEX(`videoCard`, '%B)', 1),'(', -1), ' ', 1) FROM `apcsdb`.`apcs_asset` WHERE videoCard LIKE '%GB)';
update apcsdb.apcs_asset_video_card set vcRam = vcRam * 1073741824 WHERE `vcName` LIKE '%GB)';
insert IGNORE into apcsdb.apcs_asset_video_card (`assetNumberFK`,`vcName`,`vcId`,`vcRam`) SELECT `assetNumber`, `videoCard`, '0', substring_index(substring_index(SUBSTRING_INDEX(`videoCard`, '%B)', 1),'(', -1), ' ', 1) FROM `apcsdb`.`apcs_asset` WHERE videoCard LIKE '%MB)';
update apcsdb.apcs_asset_video_card set vcRam = vcRam * 1048576 WHERE `vcName` LIKE '%MB)';
#--------------------------------------------------------------------------------------------#
insert IGNORE into apcsdb.apcs_asset_storage (`assetNumberFK`,`storSize`,`storSmartStatus`,`storId`) select `assetNumber`, replace(substring_index(`storageSize`,' ', 1), ',', '.')*1000000000000.0,'0','0' from apcsdb.apcs_asset WHERE `storageSize` like '%,%';
insert IGNORE into apcsdb.apcs_asset_storage (`assetNumberFK`,`storSize`,`storSmartStatus`,`storId`) select `assetNumber`, replace(substring_index(`storageSize`,' ', 1), ',', '.')*1000000000,'0','0' from apcsdb.apcs_asset WHERE `storageSize` not like '%,%' and `storageSize` not like '%1 %' and `storageSize` not like '%2 %' and `storageSize` not like '%3 %' and `storageSize` not like '%4 %';


SET SQL_SAFE_UPDATES=1;

ALTER TABLE `apcsdb`.`apcs_asset` 
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