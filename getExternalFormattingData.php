<?php
require_once("connection.php");

$assetNumber = $_GET["assetNumber"];
$sealNumber = $_GET["sealNumber"];
$roomNumber = $_GET["roomNumber"];
$building = $_GET["building"];
$adRegistered = $_GET["adRegistered"];
$standard = $_GET["standard"];
$serviceDate = $_GET["serviceDate"];
$brand = $_GET["brand"];
$model = $_GET["model"];
$serialNumber = $_GET["serialNumber"];
$processor = $_GET["processor"];
$ram = $_GET["ram"];
$storageSize = $_GET["storageSize"];
$operatingSystem = $_GET["operatingSystem"];
$hostname = $_GET["hostname"];
$macAddress = $_GET["macAddress"];
$ipAddress = $_GET["ipAddress"];
$fwVersion = $_GET["fwVersion"];
$inUse = $_GET["inUse"];
$tag = $_GET["tag"];
$hwType = $_GET["hwType"];
$fwType = $_GET["fwType"];
$storageType = $_GET["storageType"];
$videoCard = $_GET["videoCard"];
$mediaOperationMode = $_GET["mediaOperationMode"];
$secureBoot = $_GET["secureBoot"];
$virtualizationTechnology = $_GET["virtualizationTechnology"];
$tpmVersion = $_GET["tpmVersion"];
$batteryChange = $_GET["batteryChange"];
$ticketNumber = $_GET["ticketNumber"];
$agent = $_GET["agent"];

$serviceType = $serviceTypesArray[0];

$queryGetAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryGetAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["SEAL_NUMBER"] . " = '$sealNumber', " . $dbAssetArray["ROOM_NUMBER"] . " = '$roomNumber', " . $dbAssetArray["BUILDING"] . " = '$building', " . $dbAssetArray["AD_REGISTERED"] . " = '$adRegistered', " . $dbAssetArray["STANDARD"] . " = '$standard', " . $dbAssetArray["SERVICE_DATE"] . " = '$serviceDate', " . $dbAssetArray["BRAND"] . " = '$brand', " . $dbAssetArray["MODEL"] . " = '$model', " . $dbAssetArray["SERIAL_NUMBER"] . " = '$serialNumber', " . $dbAssetArray["PROCESSOR"] . " = '$processor', " . $dbAssetArray["RAM"] . " = '$ram', " . $dbAssetArray["STORAGE_SIZE"] . " = '$storageSize', " . $dbAssetArray["OPERATING_SYSTEM"] . " = '$operatingSystem', " . $dbAssetArray["HOSTNAME"] . " = '$hostname', " . $dbAssetArray["FW_VERSION"] . " = '$fwVersion', " . $dbAssetArray["MAC_ADDRESS"] . " = '$macAddress', " . $dbAssetArray["IP_ADDRESS"] . " = '$ipAddress', " . $dbAssetArray["IN_USE"] . " = '$inUse', " . $dbAssetArray["TAG"] . " = '$tag', " . $dbAssetArray["HW_TYPE"] . " = '$hwType', " . $dbAssetArray["FW_TYPE"] . " = '$fwType', " . $dbAssetArray["STORAGE_TYPE"] . " = '$storageType', " . $dbAssetArray["VIDEO_CARD"] . " = '$videoCard', " . $dbAssetArray["MEDIA_OPERATION_MODE"] . " = '$mediaOperationMode', " . $dbAssetArray["SECURE_BOOT"] . " = '$secureBoot', " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . " = '$virtualizationTechnology', " . $dbAssetArray["TPM_VERSION"] . " = '$tpmVersion' where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber';") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	
	$queryFormatPrevious = mysqli_query($connection, "insert into " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " (" . $dbMaintenancesArray["ASSET_NUMBER_FK"] . ", " . $dbMaintenancesArray["PREVIOUS_SERVICE_DATE"] . ", " . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["AGENT"] . ") values('$assetNumber', '$serviceDate', '$serviceType', '$batteryChange', '$ticketNumber', '$agent');") or die("Erro ao incluir os dados! " . mysqli_error($connection));
	$message = $translations["EXISTING_ASSET_UPDATING_DATA"];
} else {
	$query = mysqli_query($connection, "insert into " . $dbAssetArray["ASSET_TABLE"] . " (" . $dbAssetArray["ASSET_NUMBER"] . ", " . $dbAssetArray["DISCARDED"] . ", " . $dbAssetArray["SEAL_NUMBER"] . ", " . $dbAssetArray["ROOM_NUMBER"] . ", " . $dbAssetArray["BUILDING"] . ", " . $dbAssetArray["AD_REGISTERED"] . ", " . $dbAssetArray["STANDARD"] . ", " . $dbAssetArray["SERVICE_DATE"] . ", " . $dbAssetArray["BRAND"] . ", " . $dbAssetArray["MODEL"] . ", " . $dbAssetArray["SERIAL_NUMBER"] . ", " . $dbAssetArray["PROCESSOR"] . ", " . $dbAssetArray["RAM"] . ", " . $dbAssetArray["STORAGE_SIZE"] . ", " . $dbAssetArray["OPERATING_SYSTEM"] . ", " . $dbAssetArray["HOSTNAME"] . ", " . $dbAssetArray["FW_VERSION"] . ", " . $dbAssetArray["MAC_ADDRESS"] . ", " . $dbAssetArray["IP_ADDRESS"] . ", " . $dbAssetArray["IN_USE"] . ", " . $dbAssetArray["TAG"] . ", " . $dbAssetArray["HW_TYPE"] . ", " . $dbAssetArray["FW_TYPE"] . ", " . $dbAssetArray["STORAGE_TYPE"] . ", " . $dbAssetArray["VIDEO_CARD"] . ", " . $dbAssetArray["MEDIA_OPERATION_MODE"] . ", " . $dbAssetArray["SECURE_BOOT"] . ", " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . ", " . $dbAssetArray["TPM_VERSION"] . ") values('$assetNumber', 0, '$sealNumber', '$roomNumber', '$building', '$adRegistered', '$standard', '$serviceDate', '$brand', '$model', '$serialNumber', '$processor', '$ram', '$storageSize', '$operatingSystem', '$hostname', '$fwVersion', '$macAddress', '$ipAddress', '$inUse', '$tag', '$hwType', '$fwType', '$storageType', '$videoCard', '$mediaOperationMode', '$secureBoot', '$virtualizationTechnology', '$tpmVersion');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	
	$queryFormatPrevious = mysqli_query($connection, "insert into " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " (" . $dbMaintenancesArray["ASSET_NUMBER_FK"] . ", " . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["AGENT"] . ") values('$assetNumber', '$serviceDate', '$serviceType', '$batteryChange', '$ticketNumber', '$agent');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	$message = $translations["NEW_ASSET_REGISTERING_DATA"];
}

?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body bgcolor=green>
	<center>
		<hr style="height:0pt; visibility:hidden;" />
		<font size=3 color=white><b><?php echo $message; ?></b></font>
		</td>
	</center>
</body>

</html>