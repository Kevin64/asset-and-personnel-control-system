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
$fwVersion = $_GET[$dbAssetArray["FIRMWARE"]["FW_VERSION"]];
$inUse = $_GET[$dbAssetArray["IN_USE"]];
$tag = $_GET[$dbAssetArray["TAG"]];
$hwType = $_GET[$dbAssetArray["HW_TYPE"]];
$fwType = $_GET[$dbAssetArray["FIRMWARE"]["FW_TYPE"]];
$storageType = $_GET[$dbAssetArray["STORAGE_TYPE"]];
$videoCardName = $_GET[$dbAssetArray["VIDEO_CARD"]["NAME"]];
$mediaOperationMode = $_GET[$dbAssetArray["FIRMWARE"]["MEDIA_OPERATION_MODE"]];
$secureBoot = $_GET[$dbAssetArray["FIRMWARE"]["SECURE_BOOT"]];
$virtualizationTechnology = $_GET[$dbAssetArray["FIRMWARE"]["VIRTUALIZATION_TECHNOLOGY"]];
$tpmVersion = $_GET[$dbAssetArray["FIRMWARE"]["TPM_VERSION"]];
$batteryChange = $_GET[$dbMaintenanceArray["BATTERY_CHANGE"]];
$ticketNumber = $_GET[$dbMaintenanceArray["TICKET_NUMBER"]];
$agent = $_GET[$dbMaintenanceArray["AGENT_ID"]];

$serviceType = $serviceTypesArray[1];

$queryGetAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryGetAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["SEAL_NUMBER"] . " = '$sealNumber', " . $dbAssetArray["ROOM_NUMBER"] . " = '$roomNumber', " . $dbAssetArray["BUILDING"] . " = '$building', " . $dbAssetArray["AD_REGISTERED"] . " = '$adRegistered', " . $dbAssetArray["STANDARD"] . " = '$standard', " . $dbAssetArray["SERVICE_DATE"] . " = '$serviceDate', " . $dbAssetArray["BRAND"] . " = '$brand', " . $dbAssetArray["MODEL"] . " = '$model', " . $dbAssetArray["SERIAL_NUMBER"] . " = '$serialNumber', " . $dbAssetArray["PROCESSOR"] . " = '$processor', " . $dbAssetArray["RAM"] . " = '$ram', " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . " = '$storageSize', " . $dbAssetArray["OPERATING_SYSTEM"] . " = '$operatingSystem', " . $dbAssetArray["HOSTNAME"] . " = '$hostname', " . $dbAssetArray["FIRMWARE"]["FW_VERSION"] . " = '$fwVersion', " . $dbAssetArray["MAC_ADDRESS"] . " = '$macAddress', " . $dbAssetArray["IP_ADDRESS"] . " = '$ipAddress', " . $dbAssetArray["IN_USE"] . " = '$inUse', " . $dbAssetArray["TAG"] . " = '$tag', " . $dbAssetArray["HW_TYPE"] . " = '$hwType', " . $dbAssetArray["FIRMWARE"]["FW_TYPE"] . " = '$fwType', " . $dbAssetArray["STORAGE_TYPE"] . " = '$storageType', " . $dbAssetArray["VIDEO_CARD"]["NAME"] . " = '$videoCardName', " . $dbAssetArray["FIRMWARE"]["MEDIA_OPERATION_MODE"] . " = '$mediaOperationMode', " . $dbAssetArray["FIRMWARE"]["SECURE_BOOT"] . " = '$secureBoot', " . $dbAssetArray["FIRMWARE"]["VIRTUALIZATION_TECHNOLOGY"] . " = '$virtualizationTechnology', " . $dbAssetArray["FIRMWARE"]["TPM_VERSION"] . " = '$tpmVersion' where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber';") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

	$queryFormatPrevious = mysqli_query($connection, "insert into " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " (" . $dbMaintenanceArray["ASSET_NUMBER_FK"] . ", " . $dbMaintenanceArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenanceArray["SERVICE_TYPE"] . ", " . $dbMaintenanceArray["BATTERY_CHANGE"] . ", " . $dbMaintenanceArray["TICKET_NUMBER"] . ", " . $dbMaintenanceArray["AGENT_ID"] . ") values('$assetNumber', '$serviceDate', '$serviceType', '$batteryChange', '$ticketNumber', '$agent');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	$message = $translations["EXISTING_ASSET_UPDATING_DATA"];
	?>

	<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<title></title>
	</head>

	<body bgcolor=<?php echo $colorArray["SUCCESS_REGISTER_BACKGROUND"] ?>>
		<center>
			<hr style="height:0pt; visibility:hidden;" />
			<font size=3 color=white><b><?php echo $message; ?></b></font>
			</td>
		</center>
	</body>
	<?php
} else {
	$message = $translations["NEED_FORMATTING_FIRST"];
	?>

	<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<title></title>
	</head>

	<body bgcolor=<?php echo $colorArray["ERROR"] ?>>
		<center>
			<hr style="height:0pt; visibility:hidden;" />
			<font size=3 color=white><b><?php echo $message; ?></b></font>
			</td>
		</center>
	</body>

	</html>
	<?php
}
?>