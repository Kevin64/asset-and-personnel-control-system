#SELECT LEFT(`operatingSystem`, (LOCATE(',', `operatingSystem`, 1)) - 1) FROM `apcsdb_old`.`asset`;

#DROP TEMPORARY TABLE TempTable;
#CREATE TEMPORARY TABLE IF NOT EXISTS TempTable (versionColumn VARCHAR(100)); 
#INSERT INTO TempTable (SELECT RIGHT(`operatingSystem`, length(`operatingSystem`) - (LOCATE('v', `operatingSystem`, 1)) + 1) FROM `apcsdb_old`.`asset`);
#SELECT LEFT (TempTable.versionColumn, LOCATE(',', TempTable.versionColumn, 1) - 1) FROM TempTable;

#DROP TEMPORARY TABLE TempTable2;
#CREATE TEMPORARY TABLE IF NOT EXISTS TempTable2 (buildColumn VARCHAR(100)); 
#INSERT INTO TempTable2 (SELECT RIGHT(`operatingSystem`, length(`operatingSystem`) - (LOCATE('b', `operatingSystem`)) - 5) FROM `apcsdb_old`.`asset`);
#SELECT LEFT (TempTable2.buildColumn, LOCATE(',', TempTable2.buildColumn) - 1) FROM TempTable2;

DROP TEMPORARY TABLE TempTable3;
CREATE TEMPORARY TABLE IF NOT EXISTS TempTable3 (archColumn VARCHAR(100)); 
INSERT INTO TempTable3 (SELECT RIGHT(`operatingSystem`, length(`operatingSystem`) - (LOCATE('b', `operatingSystem`)) - 5) FROM `apcsdb_old`.`asset`);
SELECT LEFT (TempTable3.archColumn, LOCATE(',', TempTable3.archColumn) - 1) FROM TempTable2;