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
