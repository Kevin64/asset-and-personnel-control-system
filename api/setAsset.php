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
	$ramAmount = $dbAssetArray["RAM_AMOUNT"];
	$ramType = $dbAssetArray["RAM_TYPE"];
	$ramFrequency = $dbAssetArray["RAM_FREQUENCY"];
	$ramOccupiedSlots = $dbAssetArray["RAM_OCCUPIED_SLOTS"];
	$ramTotalSlots = $dbAssetArray["RAM_TOTAL_SLOTS"];
	$storageSize = $dbAssetArray["STORAGE_SIZE"];
	$operatingSystemName = $dbAssetArray["OPERATING_SYSTEM_NAME"];
	$operatingSystemVersion = $dbAssetArray["OPERATING_SYSTEM_VERSION"];
	$operatingSystemBuild = $dbAssetArray["OPERATING_SYSTEM_BUILD"];
	$operatingSystemArch = $dbAssetArray["OPERATING_SYSTEM_ARCH"];
	$hostname = $dbAssetArray["HOSTNAME"];
	$fwVersion = $dbAssetArray["FW_VERSION"];
	$macAddress = $dbAssetArray["MAC_ADDRESS"];
	$ipAddress = $dbAssetArray["IP_ADDRESS"];
	$inUse = $dbAssetArray["IN_USE"];
	$tag = $dbAssetArray["TAG"];
	$hwType = $dbAssetArray["HW_TYPE"];
	$fwType = $dbAssetArray["FW_TYPE"];
	$storageType = $dbAssetArray["STORAGE_TYPE"];
	$videoCardName = $dbAssetArray["VIDEO_CARD_NAME"];
	$videoCardRam = $dbAssetArray["VIDEO_CARD_RAM"];
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
			$ramAmount . " = '$newAsset[$ramAmount]', " .
			$ramType . " = '$newAsset[$ramType]', " .
			$ramFrequency . " = '$newAsset[$ramFrequency]', " .
			$ramOccupiedSlots . " = '$newAsset[$ramOccupiedSlots]', " .
			$ramTotalSlots . " = '$newAsset[$ramTotalSlots]', " .
			$storageSize . " = '$newAsset[$storageSize]', " .
			$operatingSystemName . " = '$newAsset[$operatingSystemName]', " .
			$operatingSystemVersion . " = '$newAsset[$operatingSystemVersion]', " .
			$operatingSystemBuild . " = '$newAsset[$operatingSystemBuild]', " .
			$operatingSystemArch . " = '$newAsset[$operatingSystemArch]', " .
			$hostname . " = '$newAsset[$hostname]', " .
			$fwVersion . " = '$newAsset[$fwVersion]', " .
			$macAddress . " = '$newAsset[$macAddress]', " .
			$ipAddress . " = '$newAsset[$ipAddress]', " .
			$inUse . " = '$newAsset[$inUse]', " .
			$tag . " = '$newAsset[$tag]', " .
			$hwType . " = '$newAsset[$hwType]', " .
			$fwType . " = '$newAsset[$fwType]', " .
			$storageType . " = '$newAsset[$storageType]', " .
			$videoCardName . " = '$newAsset[$videoCardName]', " .
			$videoCardRam . " = '$newAsset[$videoCardRam]', " .
			$mediaOperationMode . " = '$newAsset[$mediaOperationMode]', " .
			$secureBoot . " = '$newAsset[$secureBoot]', " .
			$virtualizationTechnology . " = '$newAsset[$virtualizationTechnology]', " .
			$tpmVersion . " = '$newAsset[$tpmVersion]' 
			where " . $assetNumber . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	} else {
		$query = mysqli_query($connection, "insert into " . $assetTable . " ($assetNumber,$discarded,$sealNumber,$roomNumber,$building,$adRegistered,$standard,$serviceDate,$brand,$model,$serialNumber,$processor,$ramAmount,$ramType,$ramFrequency,$ramOccupiedSlots,$ramTotalSlots,$storageSize,$operatingSystemName,$operatingSystemVersion,$operatingSystemBuild,$operatingSystemArch,$hostname,$fwVersion,$macAddress,$ipAddress,$inUse,$tag,$hwType,$fwType,$storageType,$videoCardName,$videoCardRam,$mediaOperationMode,$secureBoot,$virtualizationTechnology,$tpmVersion) values ('$newAsset[$assetNumber]','$newAsset[$discarded]','$newAsset[$sealNumber]','$newAsset[$roomNumber]','$newAsset[$building]','$newAsset[$adRegistered]','$newAsset[$standard]','$newAsset[$serviceDate]','$newAsset[$brand]','$newAsset[$model]','$newAsset[$serialNumber]','$newAsset[$processor]','$newAsset[$ramAmount]','$newAsset[$ramType]','$newAsset[$ramFrequency]','$newAsset[$ramOccupiedSlots]','$newAsset[$ramTotalSlots]','$newAsset[$storageSize]','$newAsset[$operatingSystemName]','$newAsset[$operatingSystemVersion]','$newAsset[$operatingSystemBuild]','$newAsset[$operatingSystemArch]','$newAsset[$hostname]','$newAsset[$fwVersion]','$newAsset[$macAddress]','$newAsset[$ipAddress]','$newAsset[$inUse]','$newAsset[$tag]','$newAsset[$hwType]','$newAsset[$fwType]','$newAsset[$storageType]','$newAsset[$videoCardName]','$newAsset[$videoCardRam]','$newAsset[$mediaOperationMode]','$newAsset[$secureBoot]','$newAsset[$virtualizationTechnology]','$newAsset[$tpmVersion]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	}
	$queryFormatPrevious = mysqli_query($connection, "insert into " . $maintenancesTable . " ($assetNumberFK,$previousServiceDates,$serviceType,$batteryChange,$ticketNumber,$agentId) values ('$newAsset[$assetNumber]','$newAsset[$serviceDate]','$newAsset[$serviceType]','$newAsset[$batteryChange]','$newAsset[$ticketNumber]','$newAsset[$agentId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
	echo "Ativo adicionado";
	header("Connection: close");
}
