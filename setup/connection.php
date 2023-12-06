<?php

if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
	$language = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
	$lang_file = '/../lang/' . $language . '.json';
	$lang_file_content = file_get_contents(__DIR__ . $lang_file);
	$translations = json_decode($lang_file_content, true);
}

$jsonFileDb = file_get_contents(__DIR__ . "/../etc/db-config.json");
$jsonFileDatabaseColumns = file_get_contents(__DIR__ . "/../etc/db-columns.json");
$json_config_array_db = json_decode($jsonFileDb, true);
$json_db_columns_array = json_decode($jsonFileDatabaseColumns, true);
/* ------------------------------------------------------------------------------------------------- */
$dbSettingsArray = $json_config_array_db["DbSettings"];
$privilegeLevelsArray = $json_config_array_db["PrivilegeLevels"];
/* ------------------------------------------------------------------------------------------------- */
$dbAgentArray = $json_db_columns_array["DB_AGENT"];

$dbUser = $dbSettingsArray["DbUser"];
$dbpassword = $dbSettingsArray["DbPassword"];
$dbName = $dbSettingsArray["DbName"];
$dbIP = $dbSettingsArray["DbIP"];
$dbPort = $dbSettingsArray["DbPort"];

$connection = mysqli_connect($dbIP, $dbUser, $dbpassword, $dbName, $dbPort) or die($translations["ERROR_CONNECTING_DATABASE"] . mysqli_error($connection));
