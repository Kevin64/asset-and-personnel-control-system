<?php

header("Content-Type:application/json");

if (isset($_POST)) {
	require("../connection.php");
	$json = file_get_contents('php://input');
	$newAsset = json_decode($json, true);

	$assetTable = $dbAssetArray["ASSET_TABLE"];
	$assetNumber = $dbAssetArray["ASSET_NUMBER"];
	$discarded = $dbAssetArray["DISCARDED"];
	$sealNumber = $dbAssetArray["SEAL_NUMBER"];
	$roomNumber = $dbAssetArray["ROOM_NUMBER"];
	$building = $dbAssetArray["BUILDING"];
	$adRegistered = $dbAssetArray["AD_REGISTERED"];
	$standard = $dbAssetArray["STANDARD"];
	$serviceDate = $dbAssetArray["SERVICE_DATE"];
	$brand = $dbAssetArray["BRAND"];
	$model = $dbAssetArray["MODEL"];
	$serialNumber = $dbAssetArray["SERIAL_NUMBER"];
	$processor = $dbAssetArray["PROCESSOR"];
	$ram = $dbAssetArray["RAM"];
	$storageSize = $dbAssetArray["STORAGE_SIZE"];
	$operatingSystem = $dbAssetArray["OPERATING_SYSTEM"];
	$hostname = $dbAssetArray["HOSTNAME"];
	$fwVersion = $dbAssetArray["FW_VERSION"];
	$macAddress = $dbAssetArray["MAC_ADDRESS"];
	$ipAddress = $dbAssetArray["IP_ADDRESS"];
	$inUse = $dbAssetArray["IN_USE"];
	$tag = $dbAssetArray["TAG"];
	$hwType = $dbAssetArray["HW_TYPE"];
	$fwType = $dbAssetArray["FW_TYPE"];
	$storageType = $dbAssetArray["STORAGE_TYPE"];
	$videoCard = $dbAssetArray["VIDEO_CARD"];
	$mediaOperationMode = $dbAssetArray["MEDIA_OPERATION_MODE"];
	$secureBoot = $dbAssetArray["SECURE_BOOT"];
	$virtualizationTechnology = $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"];
	$tpmVersion = $dbAssetArray["TPM_VERSION"];

	$maintenancesTable = $dbMaintenancesArray["MAINTENANCES_TABLE"];
	$assetNumberFK = $dbMaintenancesArray["ASSET_NUMBER_FK"];
	$previousServiceDates = $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"];
	$serviceType = $dbMaintenancesArray["SERVICE_TYPE"];
	$batteryChange = $dbMaintenancesArray["BATTERY_CHANGE"];
	$ticketNumber = $dbMaintenancesArray["TICKET_NUMBER"];
	$agentId = $dbMaintenancesArray["AGENT_ID"];

	$queryGetAsset = mysqli_query($connection, "select * from " . $assetTable . " where " . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$total = mysqli_num_rows($queryGetAsset);

	if ($total >= 1) {
		$query = mysqli_query($connection, "update " . $assetTable . " set " .
			$sealNumber . " = '$newAsset[$sealNumber]', " .
			$roomNumber . " = '$newAsset[$roomNumber]', " .
			$building . " = '$newAsset[$building]', " .
			$adRegistered . " = '$newAsset[$adRegistered]', " .
			$standard . " = '$newAsset[$standard]', " .
			$serviceDate . " = '$newAsset[$serviceDate]', " .
			$brand . " = '$newAsset[$brand]', " .
			$model . " = '$newAsset[$model]', " .
			$serialNumber . " = '$newAsset[$serialNumber]', " .
			$processor . " = '$newAsset[$processor]', " .
			$ram . " = '$newAsset[$ram]', " .
			$storageSize . " = '$newAsset[$storageSize]', " .
			$operatingSystem . " = '$newAsset[$operatingSystem]', " .
			$hostname . " = '$newAsset[$hostname]', " .
			$fwVersion . " = '$newAsset[$fwVersion]', " .
			$macAddress . " = '$newAsset[$macAddress]', " .
			$ipAddress . " = '$newAsset[$ipAddress]', " .
			$inUse . " = '$newAsset[$inUse]', " .
			$tag . " = '$newAsset[$tag]', " .
			$hwType . " = '$newAsset[$hwType]', " .
			$fwType . " = '$newAsset[$fwType]', " .
			$storageType . " = '$newAsset[$storageType]', " .
			$videoCard . " = '$newAsset[$videoCard]', " .
			$mediaOperationMode . " = '$newAsset[$mediaOperationMode]', " .
			$secureBoot . " = '$newAsset[$secureBoot]', " .
			$virtualizationTechnology . " = '$newAsset[$virtualizationTechnology]', " .
			$tpmVersion . " = '$newAsset[$tpmVersion]' 
			where " . $assetNumber . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	} else {
		$query = mysqli_query($connection, "insert into " . $assetTable . " ($assetNumber,$discarded,$sealNumber,$roomNumber,$building,$adRegistered,$standard,$serviceDate,$brand,$model,$serialNumber,$processor,$ram,$storageSize,$operatingSystem,$hostname,$fwVersion,$macAddress,$ipAddress,$inUse,$tag,$hwType,$fwType,$storageType,$videoCard,$mediaOperationMode,$secureBoot,$virtualizationTechnology,$tpmVersion) values ('$newAsset[$assetNumber]','$newAsset[$discarded]','$newAsset[$sealNumber]','$newAsset[$roomNumber]','$newAsset[$building]','$newAsset[$adRegistered]','$newAsset[$standard]','$newAsset[$serviceDate]','$newAsset[$brand]','$newAsset[$model]','$newAsset[$serialNumber]','$newAsset[$processor]','$newAsset[$ram]','$newAsset[$storageSize]','$newAsset[$operatingSystem]','$newAsset[$hostname]','$newAsset[$fwVersion]','$newAsset[$macAddress]','$newAsset[$ipAddress]','$newAsset[$inUse]','$newAsset[$tag]','$newAsset[$hwType]','$newAsset[$fwType]','$newAsset[$storageType]','$newAsset[$videoCard]','$newAsset[$mediaOperationMode]','$newAsset[$secureBoot]','$newAsset[$virtualizationTechnology]','$newAsset[$tpmVersion]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	}
	$queryFormatPrevious = mysqli_query($connection, "insert into " . $maintenancesTable . " ($assetNumberFK,$previousServiceDates,$serviceType,$batteryChange,$ticketNumber,$agentId) values ('$newAsset[$assetNumber]','$newAsset[$serviceDate]','$newAsset[$serviceType]','$newAsset[$batteryChange]','$newAsset[$ticketNumber]','$newAsset[$agentId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	echo "Ativo adicionado";
	header("Connection: close");
}
