<?php
require_once("connection.php");

$assetNumber = $_GET[$dbAssetArray["ASSET_NUMBER"]];
$sealNumber = $_GET[$dbAssetArray["SEAL_NUMBER"]];
$roomNumber = $_GET[$dbAssetArray["ROOM_NUMBER"]];
$building = $_GET[$dbAssetArray["BUILDING"]];
$adRegistered = $_GET[$dbAssetArray["AD_REGISTERED"]];
$standard = $_GET[$dbAssetArray["STANDARD"]];
$serviceDate = $_GET[$dbAssetArray["SERVICE_DATE"]];
$brand = $_GET[$dbAssetArray["BRAND"]];
$model = $_GET[$dbAssetArray["MODEL"]];
$serialNumber = $_GET[$dbAssetArray["SERIAL_NUMBER"]];
$processor = $_GET[$dbAssetArray["PROCESSOR"]];
$ram = $_GET[$dbAssetArray["RAM"]];
$storageSize = $_GET[$dbAssetArray["STORAGE_TOTAL_SIZE"]];
$operatingSystem = $_GET[$dbAssetArray["OPERATING_SYSTEM"]];
$hostname = $_GET[$dbAssetArray["HOSTNAME"]];
$macAddress = $_GET[$dbAssetArray["MAC_ADDRESS"]];
$ipAddress = $_GET[$dbAssetArray["IP_ADDRESS"]];
$fwVersion = $_GET[$dbAssetArray["FW_VERSION"]];
$inUse = $_GET[$dbAssetArray["IN_USE"]];
$tag = $_GET[$dbAssetArray["TAG"]];
$hwType = $_GET[$dbAssetArray["HW_TYPE"]];
$fwType = $_GET[$dbAssetArray["FW_TYPE"]];
$storageSummary = $_GET[$dbAssetArray["STORAGE_TYPE"]];
$videoCardName = $_GET[$dbAssetArray["VIDEO_CARD_NAME"]];
$videoCardRam = $_GET[$dbAssetArray["VIDEO_CARD_RAM"]];
$mediaOperationMode = $_GET[$dbAssetArray["MEDIA_OPERATION_MODE"]];
$secureBoot = $_GET[$dbAssetArray["SECURE_BOOT"]];
$virtualizationTechnology = $_GET[$dbAssetArray["VIRTUALIZATION_TECHNOLOGY"]];
$tpmVersion = $_GET[$dbAssetArray["TPM_VERSION"]];
$batteryChange = $_GET[$dbMaintenancesArray["BATTERY_CHANGE"]];
$ticketNumber = $_GET[$dbMaintenancesArray["TICKET_NUMBER"]];
$agent = $_GET[$dbMaintenancesArray["AGENT_ID"]];

$serviceType = $serviceTypesArray[0];

$queryGetAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryGetAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["SEAL_NUMBER"] . " = '$sealNumber', " . $dbAssetArray["ROOM_NUMBER"] . " = '$roomNumber', " . $dbAssetArray["BUILDING"] . " = '$building', " . $dbAssetArray["AD_REGISTERED"] . " = '$adRegistered', " . $dbAssetArray["STANDARD"] . " = '$standard', " . $dbAssetArray["SERVICE_DATE"] . " = '$serviceDate', " . $dbAssetArray["BRAND"] . " = '$brand', " . $dbAssetArray["MODEL"] . " = '$model', " . $dbAssetArray["SERIAL_NUMBER"] . " = '$serialNumber', " . $dbAssetArray["PROCESSOR"] . " = '$processor', " . $dbAssetArray["RAM"] . " = '$ram', " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . " = '$storageSize', " . $dbAssetArray["OPERATING_SYSTEM"] . " = '$operatingSystem', " . $dbAssetArray["HOSTNAME"] . " = '$hostname', " . $dbAssetArray["FW_VERSION"] . " = '$fwVersion', " . $dbAssetArray["MAC_ADDRESS"] . " = '$macAddress', " . $dbAssetArray["IP_ADDRESS"] . " = '$ipAddress', " . $dbAssetArray["IN_USE"] . " = '$inUse', " . $dbAssetArray["TAG"] . " = '$tag', " . $dbAssetArray["HW_TYPE"] . " = '$hwType', " . $dbAssetArray["FW_TYPE"] . " = '$fwType', " . $dbAssetArray["STORAGE_TYPE"] . " = '$storageSummary', " . $dbAssetArray["VIDEO_CARD_NAME"] . " = '$videoCardName', " . $dbAssetArray["VIDEO_CARD_RAM"] . " = '$videoCardRam', " . $dbAssetArray["MEDIA_OPERATION_MODE"] . " = '$mediaOperationMode', " . $dbAssetArray["SECURE_BOOT"] . " = '$secureBoot', " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . " = '$virtualizationTechnology', " . $dbAssetArray["TPM_VERSION"] . " = '$tpmVersion' where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber';") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	
	$queryFormatPrevious = mysqli_query($connection, "insert into " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " (" . $dbMaintenancesArray["ASSET_NUMBER_FK"] . ", " . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["AGENT_ID"] . ") values('$assetNumber', '$serviceDate', '$serviceType', '$batteryChange', '$ticketNumber', '$agent');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	$message = $translations["EXISTING_ASSET_UPDATING_DATA"];
} else {
	$query = mysqli_query($connection, "insert into " . $dbAssetArray["ASSET_TABLE"] . " (" . $dbAssetArray["ASSET_NUMBER"] . ", " . $dbAssetArray["DISCARDED"] . ", " . $dbAssetArray["SEAL_NUMBER"] . ", " . $dbAssetArray["ROOM_NUMBER"] . ", " . $dbAssetArray["BUILDING"] . ", " . $dbAssetArray["AD_REGISTERED"] . ", " . $dbAssetArray["STANDARD"] . ", " . $dbAssetArray["SERVICE_DATE"] . ", " . $dbAssetArray["BRAND"] . ", " . $dbAssetArray["MODEL"] . ", " . $dbAssetArray["SERIAL_NUMBER"] . ", " . $dbAssetArray["PROCESSOR"] . ", " . $dbAssetArray["RAM_AMOUNT"] . ", " . $dbAssetArray["RAM_TYPE"] . ", " . $dbAssetArray["RAM_FREQUENCY"] . ", " . $dbAssetArray["RAM_OCCUPIED_SLOTS"] . ", " . $dbAssetArray["RAM_TOTAL_SLOTS"] . ", " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . ", " . $dbAssetArray["OPERATING_SYSTEM"] . ", " . $dbAssetArray["HOSTNAME"] . ", " . $dbAssetArray["FW_VERSION"] . ", " . $dbAssetArray["MAC_ADDRESS"] . ", " . $dbAssetArray["IP_ADDRESS"] . ", " . $dbAssetArray["IN_USE"] . ", " . $dbAssetArray["TAG"] . ", " . $dbAssetArray["HW_TYPE"] . ", " . $dbAssetArray["FW_TYPE"] . ", " . $dbAssetArray["STORAGE_TYPE"] . ", " . $dbAssetArray["VIDEO_CARD_NAME"] . ", " . $dbAssetArray["VIDEO_CARD_RAM"] . ", " . $dbAssetArray["MEDIA_OPERATION_MODE"] . ", " . $dbAssetArray["SECURE_BOOT"] . ", " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . ", " . $dbAssetArray["TPM_VERSION"] . ") values('$assetNumber', 0, '$sealNumber', '$roomNumber', '$building', '$adRegistered', '$standard', '$serviceDate', '$brand', '$model', '$serialNumber', '$processor', '$ramAmount', '$ramType', '$ramFrequency', '$ramOccupiedSlots', '$ramTotalSlots', '$storageSize', '$operatingSystem', '$hostname', '$fwVersion', '$macAddress', '$ipAddress', '$inUse', '$tag', '$hwType', '$fwType', '$storageSummary', '$videoCardName', '$videoCardRam', '$mediaOperationMode', '$secureBoot', '$virtualizationTechnology', '$tpmVersion');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	
	$queryFormatPrevious = mysqli_query($connection, "insert into " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " (" . $dbMaintenancesArray["ASSET_NUMBER_FK"] . ", " . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["AGENT_ID"] . ") values('$assetNumber', '$serviceDate', '$serviceType', '$batteryChange', '$ticketNumber', '$agent');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
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