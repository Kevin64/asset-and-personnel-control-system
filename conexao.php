<?php
$jsonFile = file_get_contents(__DIR__ . "/etc/config.json");
$json_config_array = json_decode($jsonFile, true);

$building_array = $json_config_array["Definitions"]["Buildings"];
$hwtype_array = $json_config_array["Definitions"]["HWTypes"];

$orgFullName = $json_config_array["OrgData"]["OrganizationFullName"];
$orgAcronym = $json_config_array["OrgData"]["OrganizationAcronym"];
$depFullName = $json_config_array["OrgData"]["DepartamentFullName"];
$depAcronym = $json_config_array["OrgData"]["DepartamentAcronym"];
$subDepFullName = $json_config_array["OrgData"]["SubDepartamentFullName"];
$subDepAcronym = $json_config_array["OrgData"]["SubDepartamentAcronym"];
$email = $json_config_array["OrgData"]["Email"];
$phone = $json_config_array["OrgData"]["Phone"];

$dbUser = $json_config_array["DbSettings"]["DbUser"];
$dbpassword = $json_config_array["DbSettings"]["DbPassword"];
$dbName = $json_config_array["DbSettings"]["DbName"];
$dbIP = $json_config_array["DbSettings"]["DbIP"];
$dbPort = $json_config_array["DbSettings"]["DbPort"];

$conexao = mysqli_connect($dbIP, $dbUser, $dbpassword, $dbName, $dbPort) or die("Erro ao tentar conectar no servidor mysql! " . mysqli_error($conexao));
