<?php

require("functions.php");

if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
	$language = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
	$lang_file = '/lang/' . $language . '.json';
	$lang_file_content = file_get_contents(__DIR__ . $lang_file);
	$translations = json_decode($lang_file_content, true);
}
$gitHubVersion = null;
$line = null;

$jsonFileDb = file_get_contents(__DIR__ . "/etc/db-config.json");
$jsonFileParameters = file_get_contents(__DIR__ . "/etc/parameters.json");
$jsonFileConstants = file_get_contents(__DIR__ . "/etc/constants.json");
$json_config_array_db = json_decode($jsonFileDb, true);
$json_parameters_array = json_decode($jsonFileParameters, true);
$json_constants_array = json_decode($jsonFileConstants, true);
/* ------------------------------------------------------------------------------------------------- */
$timezone = $json_config_array_db["Locale"];
date_default_timezone_set($timezone);
$buildingArray = $json_parameters_array["Parameters"]["Buildings"];
$hwTypesArray = $json_parameters_array["Parameters"]["HardwareTypes"];
$operatingSystemArchArray = $json_parameters_array["Parameters"]["OperatingSystemArchTypes"];
$fwTypesArray = $json_parameters_array["Parameters"]["FirmwareTypes"];
$tpmTypesArray = $json_parameters_array["Parameters"]["TpmTypes"];
$mediaOpTypesArray = $json_parameters_array["Parameters"]["MediaOperationTypes"];
$secureBootArray = $json_parameters_array["Parameters"]["SecureBootStates"];
$virtualizationTechnologyArray = $json_parameters_array["Parameters"]["VirtualizationTechnologyStates"];
$serviceTypesArray = $json_parameters_array["Parameters"]["ServiceTypes"];
$storageTypesArray = $json_parameters_array["Parameters"]["StorageTypes"];
$connectionTypesArray = $json_parameters_array["Parameters"]["ConnectionTypes"];
/* ------------------------------------------------------------------------------------------------- */
$orgDataArray = $json_config_array_db["OrgData"];
$dbSettingsArray = $json_config_array_db["DbSettings"];
$privilegeLevelsArray = $json_config_array_db["PrivilegeLevels"];
$entityTypesArray = $json_config_array_db["EntityTypes"];
$employeeTypesArray = $json_config_array_db["EmployeeTypes"];
$roleTypesArray = $json_config_array_db["RoleTypes"];
/* ------------------------------------------------------------------------------------------------- */
$imgArray = $json_constants_array["IMG"];
$colorArray = $json_constants_array["COLOR"];
$dbAssetArray = $json_constants_array["DB_ASSET"];
$dbOperatingSystemArray = $json_constants_array["DB_ASSET"]["OPERATING_SYSTEM"];
$dbRamArray = $json_constants_array["DB_ASSET"]["HARDWARE"]["RAM"];
$dbLocationArray = $json_constants_array["DB_ASSET"]["LOCATION"];
$dbFirmwareArray = $json_constants_array["DB_ASSET"]["FIRMWARE"];
$dbHardwareArray = $json_constants_array["DB_ASSET"]["HARDWARE"];
$dbProcessorArray = $json_constants_array["DB_ASSET"]["HARDWARE"]["PROCESSOR"];
$dbStorageArray = $json_constants_array["DB_ASSET"]["HARDWARE"]["STORAGE"];
$dbVideoCardArray = $json_constants_array["DB_ASSET"]["HARDWARE"]["VIDEO_CARD"];
$dbNetworkArray = $json_constants_array["DB_ASSET"]["NETWORK"];
$dbMaintenanceArray = $json_constants_array["DB_ASSET"]["MAINTENANCES"];
$dbAgentArray = $json_constants_array["DB_AGENT"];
$dbEmployeeArray = $json_constants_array["DB_EMPLOYEE"];
$dbModelArray = $json_constants_array["DB_MODEL"];
/* ------------------------------------------------------------------------------------------------- */
$orgFullName = $orgDataArray["OrganizationFullName"];
$orgAcronym = $orgDataArray["OrganizationAcronym"];
$orgURL = $orgDataArray["OrganizationURL"];
$depFullName = $orgDataArray["DepartamentFullName"];
$depAcronym = $orgDataArray["DepartamentAcronym"];
$depURL = $orgDataArray["DepartamentURL"];
$subDepFullName = $orgDataArray["SubDepartamentFullName"];
$subDepAcronym = $orgDataArray["SubDepartamentAcronym"];
$subURL = $orgDataArray["SubDepartamentURL"];
$email = $orgDataArray["Email"];
$phoneNumber = $orgDataArray["Phone"];
$location = $orgDataArray["LocationCoordinates"];

$location = str_replace(",","%2C",$location);

$dbUser = $dbSettingsArray["DbUser"];
$dbpassword = $dbSettingsArray["DbPassword"];
$dbName = $dbSettingsArray["DbName"];
$dbIP = $dbSettingsArray["DbIP"];
$dbPort = $dbSettingsArray["DbPort"];

$connection = mysqli_connect($dbIP, $dbUser, $dbpassword, $dbName, $dbPort) or die($translations["ERROR_CONNECTING_DATABASE"] . mysqli_error($connection));

if ($file = fopen(__DIR__ . "/etc/version", "r")) {
	while (!feof($file)) {
		$line = fgets($file);
	}
	fclose($file);
}