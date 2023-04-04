<?php

require("functions.php");

$language = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
$lang_file = '/lang/' . $language . '.json';
$lang_file_content = file_get_contents(__DIR__ . $lang_file);
$translations = json_decode($lang_file_content, true);

$jsonFile = file_get_contents(__DIR__ . "/etc/config.json");
$json_config_array = json_decode($jsonFile, true);

$timezone = gatherJsonTypes($json_config_array, "Locale", null);
date_default_timezone_set($timezone);

$buildingArray = gatherJsonTypes($json_config_array, "Definitions", "Buildings");
$hwTypesArray = gatherJsonTypes($json_config_array, "Definitions", "HardwareTypes");
$fwTypesArray = gatherJsonTypes($json_config_array, "Definitions", "FirmwareTypes");
$tpmTypesArray = gatherJsonTypes($json_config_array, "Definitions", "TpmTypes");
$mediaOpTypesArray = gatherJsonTypes($json_config_array, "Definitions", "MediaOperationTypes");
$secureBootArray = gatherJsonTypes($json_config_array, "Definitions", "SecureBootStates");
$virtualizationTechnologyArray = gatherJsonTypes($json_config_array, "Definitions", "VirtualizationTechnologyStates");
$serviceTypesArray = gatherJsonTypes($json_config_array, "Definitions", "ServiceTypes");
$orgDataArray = gatherJsonTypes($json_config_array, "OrgData", null);
$dbSettingsArray = gatherJsonTypes($json_config_array, "DbSettings", null);
$privilegeLevelsArray = gatherJsonTypes($json_config_array, "PrivilegeLevels", null);
$entityTypesArray = gatherJsonTypes($json_config_array, "EntityTypes", null);
$employeeTypesArray = gatherJsonTypes($json_config_array, "EmployeeTypes", null);

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
