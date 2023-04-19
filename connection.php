<?php

require("functions.php");

$language = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
$lang_file = '/lang/' . $language . '.json';
$lang_file_content = file_get_contents(__DIR__ . $lang_file);
$translations = json_decode($lang_file_content, true);

$jsonFileDb = file_get_contents(__DIR__ . "/etc/db-config.json");
$jsonFileParameters = file_get_contents(__DIR__ . "/etc/parameters.json");
$jsonFileConstants = file_get_contents(__DIR__ . "/etc/constants.json");
$json_config_array_db = json_decode($jsonFileDb, true);
$json_parameters_array = json_decode($jsonFileParameters, true);
$json_constants_array = json_decode($jsonFileConstants, true);

$timezone = gatherJsonTypes($json_config_array_db, "Locale", null);
date_default_timezone_set($timezone);
$buildingArray = gatherJsonTypes($json_parameters_array, "Definitions", "Buildings");
$hwTypesArray = gatherJsonTypes($json_parameters_array, "Definitions", "HardwareTypes");
$fwTypesArray = gatherJsonTypes($json_parameters_array, "Definitions", "FirmwareTypes");
$tpmTypesArray = gatherJsonTypes($json_parameters_array, "Definitions", "TpmTypes");
$mediaOpTypesArray = gatherJsonTypes($json_parameters_array, "Definitions", "MediaOperationTypes");
$secureBootArray = gatherJsonTypes($json_parameters_array, "Definitions", "SecureBootStates");
$virtualizationTechnologyArray = gatherJsonTypes($json_parameters_array, "Definitions", "VirtualizationTechnologyStates");
$serviceTypesArray = gatherJsonTypes($json_parameters_array, "Definitions", "ServiceTypes");
$orgDataArray = gatherJsonTypes($json_config_array_db, "OrgData", null);
$dbSettingsArray = gatherJsonTypes($json_config_array_db, "DbSettings", null);
$privilegeLevelsArray = gatherJsonTypes($json_config_array_db, "PrivilegeLevels", null);
$entityTypesArray = gatherJsonTypes($json_config_array_db, "EntityTypes", null);
$employeeTypesArray = gatherJsonTypes($json_config_array_db, "EmployeeTypes", null);
$imgArray = gatherJsonTypes($json_constants_array, "IMG", null);
$colorArray = gatherJsonTypes($json_constants_array, "COLOR", null);
$dbAssetArray = gatherJsonTypes($json_constants_array, "DB_ASSET", null);
$dbMaintenancesArray = gatherJsonTypes($json_constants_array, "DB_MAINTENANCES", null);
$dbAgentsArray = gatherJsonTypes($json_constants_array, "DB_AGENTS", null);
$dbEmployeeArray = gatherJsonTypes($json_constants_array, "DB_EMPLOYEE", null);
$dbModelArray = gatherJsonTypes($json_constants_array, "DB_MODEL", null);

$orgFullName = $orgDataArray["OrganizationFullName"];
$orgAcronym = $orgDataArray["OrganizationAcronym"];
$depFullName = $orgDataArray["DepartamentFullName"];
$depAcronym = $orgDataArray["DepartamentAcronym"];
$subDepFullName = $orgDataArray["SubDepartamentFullName"];
$subDepAcronym = $orgDataArray["SubDepartamentAcronym"];
$email = $orgDataArray["Email"];
$phoneNumber = $orgDataArray["Phone"];

$dbUser = $dbSettingsArray["DbUser"];
$dbpassword = $dbSettingsArray["DbPassword"];
$dbName = $dbSettingsArray["DbName"];
$dbIP = $dbSettingsArray["DbIP"];
$dbPort = $dbSettingsArray["DbPort"];

$connection = mysqli_connect($dbIP, $dbUser, $dbpassword, $dbName, $dbPort) or die($translations["ERROR_CONNECTING_DATABASE"] . mysqli_error($connection));
