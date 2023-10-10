<?php

header("Content-Type:application/json");

if (isset($_POST)) {
	require("../connection.php");
	$json = file_get_contents('php://input');
	$newAsset = json_decode($json, true);

	$assetTable = $dbAssetArray["ASSET_TABLE"];
	$assetNumber = $dbAssetArray["ASSET_NUMBER"];
	$assetNumberFK = $dbAssetArray["ASSET_NUMBER_FK"];
	$discarded = $dbAssetArray["DISCARDED"];
	$sealNumber = $dbAssetArray["SEAL_NUMBER"];
	$adRegistered = $dbAssetArray["AD_REGISTERED"];
	$standard = $dbAssetArray["STANDARD"];
	$serviceDate = $dbMaintenanceArray["SERVICE_DATE"];
	$inUse = $dbAssetArray["IN_USE"];
	$tag = $dbAssetArray["TAG"];

	$firmwareTable = $dbFirmwareArray["FIRMWARE_TABLE"];
	$fwVersion = $dbFirmwareArray["VERSION"];
	$fwType = $dbFirmwareArray["TYPE"];
	$mediaOperationMode = $dbFirmwareArray["MEDIA_OPERATION_MODE"];
	$secureBoot = $dbFirmwareArray["SECURE_BOOT"];
	$virtualizationTechnology = $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"];
	$tpmVersion = $dbFirmwareArray["TPM_VERSION"];

	$hardwareTable = $dbHardwareArray["HARDWARE_TABLE"];
	$brand = $dbHardwareArray["BRAND"];
	$model = $dbHardwareArray["MODEL"];
	$serialNumber = $dbHardwareArray["SERIAL_NUMBER"];
	$hwType = $dbHardwareArray["TYPE"];

	$processorTable = $dbProcessorArray["PROCESSOR_TABLE"];
	$processorId = $dbProcessorArray["CPU_ID"];
	$processorName = $dbProcessorArray["NAME"];
	$processorFrequency = $dbProcessorArray["FREQUENCY"];
	$processorCores = $dbProcessorArray["NUMBER_OF_CORES"];
	$processorThreads = $dbProcessorArray["NUMBER_OF_THREADS"];
	$processorCache = $dbProcessorArray["CACHE"];

	$ramTable = $dbRamArray["RAM_TABLE"];
	$ramAmount = $dbRamArray["AMOUNT"];
	$ramType = $dbRamArray["TYPE"];
	$ramFrequency = $dbRamArray["FREQUENCY"];
	$ramManufacturer = $dbRamArray["MANUFACTURER"];
	$ramSerialNumber = $dbRamArray["SERIAL_NUMBER"];
	$ramPartNumber = $dbRamArray["PART_NUMBER"];
	$ramSlot = $dbRamArray["SLOT"];

	$storageTable = $dbStorageArray["STORAGE_TABLE"];
	$storageId = $dbStorageArray["STORAGE_ID"];
	$storageType = $dbStorageArray["TYPE"];
	$storageSize = $dbStorageArray["SIZE"];
	$storageConnection = $dbStorageArray["CONNECTION"];
	$storageModel = $dbStorageArray["MODEL"];
	$storageSerialNumber = $dbStorageArray["SERIAL_NUMBER"];
	$storageSmart = $dbStorageArray["SMART_STATUS"];

	$videoCardTable = $dbVideoCardArray["VIDEO_CARD_TABLE"];
	$videoCardName = $dbVideoCardArray["NAME"];
	$videoCardRam = $dbVideoCardArray["RAM"];
	$videoCardGpuId = $dbVideoCardArray["GPU_ID"];

	$locationTable = $dbLocationArray["LOCATION_TABLE"];
	$roomNumber = $dbLocationArray["ROOM_NUMBER"];
	$building = $dbLocationArray["BUILDING"];
	$deliveredToRegistrationNumber = $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"];
	$lastDeliveryMadeBy = $dbLocationArray["LAST_DELIVERY_MADE_BY"];
	$lastDeliveryDate = $dbLocationArray["LAST_DELIVERY_DATE"];

	$maintenancesTable = $dbMaintenanceArray["MAINTENANCES_TABLE"];
	$serviceDate = $dbMaintenanceArray["SERVICE_DATE"];
	$serviceType = $dbMaintenanceArray["SERVICE_TYPE"];
	$batteryChange = $dbMaintenanceArray["BATTERY_CHANGE"];
	$ticketNumber = $dbMaintenanceArray["TICKET_NUMBER"];
	$agentId = $dbMaintenanceArray["AGENT_ID"];

	$networkTable = $dbNetworkArray["NETWORK_TABLE"];
	$hostname = $dbNetworkArray["HOSTNAME"];
	$macAddress = $dbNetworkArray["MAC_ADDRESS"];
	$ipAddress = $dbNetworkArray["IP_ADDRESS"];

	$operatingSystemTable = $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"];
	$operatingSystemName = $dbOperatingSystemArray["NAME"];
	$operatingSystemVersion = $dbOperatingSystemArray["VERSION"];
	$operatingSystemBuild = $dbOperatingSystemArray["BUILD"];
	$operatingSystemArch = $dbOperatingSystemArray["ARCH"];

	$assetJsonSection = $newAsset;
	$firmwareJsonSection = $newAsset["firmware"];
	$hardwareJsonSection = $newAsset["hardware"];
	$processorJsonSection = $newAsset["hardware"]["processor"];
	$ramJsonSection = $newAsset["hardware"]["ram"];
	$storageJsonSection = $newAsset["hardware"]["storage"];
	$videoCardJsonSection = $newAsset["hardware"]["videoCard"];
	$locationJsonSection = $newAsset["location"];
	$maintenancesJsonSection = $newAsset["maintenances"];
	$networkJsonSection = $newAsset["network"];
	$operatingSystemJsonSection = $newAsset["operatingSystem"];

	$queryGetAsset = mysqli_query($connection, "select * from " . $assetTable . " where " . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$total = mysqli_num_rows($queryGetAsset);

	if ($total >= 1) {
		$queryAsset = mysqli_query($connection, "update " . $assetTable . " set " .
			$sealNumber . " = '$newAsset[$sealNumber]', " .
			$adRegistered . " = '$newAsset[$adRegistered]', " .
			$standard . " = '$newAsset[$standard]', " .
			$inUse . " = '$newAsset[$inUse]', " .
			$tag . " = '$newAsset[$tag]'
			where " . $assetNumber . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetFirmware = mysqli_query($connection, "update " . $firmwareTable . " set " .
			$fwVersion . " = '$firmwareJsonSection[$fwVersion]', " .
			$fwType . " = '$firmwareJsonSection[$fwType]', " .
			$mediaOperationMode . " = '$firmwareJsonSection[$mediaOperationMode]', " .
			$secureBoot . " = '$firmwareJsonSection[$secureBoot]', " .
			$virtualizationTechnology . " = '$firmwareJsonSection[$virtualizationTechnology]', " .
			$tpmVersion . " = '$firmwareJsonSection[$tpmVersion]' 
			where " . $assetNumberFK . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetHardware = mysqli_query($connection, "update " . $hardwareTable . " set " .
			$brand . " = '$hardwareJsonSection[$brand]', " .
			$model . " = '$hardwareJsonSection[$model]', " .
			$serialNumber . " = '$hardwareJsonSection[$serialNumber]', " .
			$hwType . " = '$hardwareJsonSection[$hwType]'
			where " . $assetNumberFK . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryProcessorDel = mysqli_query($connection, "delete " . $processorTable . " from " . $processorTable . " inner join " . $assetTable . " on " . $processorTable . "." . $assetNumberFK . " = " . $assetTable . "." . $assetNumber . " where " . $assetTable . "." . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));

		foreach ($processorJsonSection as $item) {
			$queryAssetProcessor = mysqli_query($connection, "insert into " . $processorTable . " ($processorId,$processorName,$processorFrequency,$processorCores,$processorThreads,$processorCache) values ('$newAsset[$processorId]','$item[$processorName]','$item[$processorFrequency]','$item[$processorCores]','$item[$processorThreads]','$item[$processorCache]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryRamDel = mysqli_query($connection, "delete " . $ramTable . " from " . $ramTable . " inner join " . $assetTable . " on " . $ramTable . "." . $assetNumberFK . " = " . $assetTable . "." . $assetNumber . " where " . $assetTable . "." . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));

		foreach ($ramJsonSection as $item) {
			$queryAssetRam = mysqli_query($connection, "insert into " . $ramTable . " ($ramAmount,$ramType,$ramFrequency,$ramManufacturer,$ramSerialNumber,$ramPartNumber,$ramSlot) values ('$newAsset[$assetNumber]','$item[$ramAmount]','$item[$ramType]','$item[$ramFrequency]','$item[$ramManufacturer]','$item[$ramSerialNumber]','$item[$ramPartNumber]','$item[$ramSlot]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryStorageDel = mysqli_query($connection, "delete " . $storageTable . " from " . $storageTable . " inner join " . $assetTable . " on " . $storageTable . "." . $assetNumberFK . " = " . $assetTable . "." . $assetNumber . " where " . $assetTable . "." . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));

		foreach ($storageJsonSection as $item) {
			$queryAssetStorage = mysqli_query($connection, "insert into " . $storageTable . " ($assetNumberFK,$storageId,$storageType,$storageSize,$storageConnection,$storageModel,$storageSerialNumber,$storageSmart) values ('$newAsset[$assetNumber]','$item[$storageId]','$item[$storageType]','$item[$storageSize]','$item[$storageConnection]','$item[$storageModel]','$item[$storageSerialNumber]','$item[$storageSmart]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryVideoCardDel = mysqli_query($connection, "delete " . $videoCardTable . " from " . $videoCardTable . " inner join " . $assetTable . " on " . $videoCardTable . "." . $assetNumberFK . " = " . $assetTable . "." . $assetNumber . " where " . $assetTable . "." . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));

		foreach ($videoCardJsonSection as $item) {
			$queryAssetVideoCard = mysqli_query($connection, "insert into " . $videoCardTable . " ($assetNumberFK,$videoCardName,$videoCardRam,$videoCardGpuId) values ('$newAsset[$assetNumber]','$item[$videoCardName]','$item[$videoCardRam]','$item[$videoCardGpuId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryAssetLocation = mysqli_query($connection, "update " . $locationTable . " set " .
			$roomNumber . " = '$locationJsonSection[$roomNumber]', " .
			$building . " = '$locationJsonSection[$building]', " .
			$deliveredToRegistrationNumber . " = '$locationJsonSection[$deliveredToRegistrationNumber]', " .
			$lastDeliveryMadeBy . " = '$locationJsonSection[$lastDeliveryMadeBy]', " .
			$lastDeliveryDate . " = '$locationJsonSection[$lastDeliveryDate]'
			where " . $assetNumberFK . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		foreach ($maintenancesJsonSection as $item) {
			$queryAssetMaintenances = mysqli_query($connection, "insert into " . $maintenancesTable . " ($assetNumberFK,$serviceDate,$serviceType,$batteryChange,$ticketNumber,$agentId) values ('$newAsset[$assetNumber]','$item[$serviceDate]','$item[$serviceType]','$item[$batteryChange]','$item[$ticketNumber]','$item[$agentId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryAssetNetwork = mysqli_query($connection, "update " . $networkTable . " set " .
			$hostname . " = '$networkJsonSection[$hostname]', " .
			$macAddress . " = '$networkJsonSection[$macAddress]', " .
			$ipAddress . " = '$networkJsonSection[$ipAddress]'
			where " . $assetNumberFK . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetOperatingSystem = mysqli_query($connection, "update " . $operatingSystemTable . " set " .
			$operatingSystemArch . " = '$operatingSystemJsonSection[$operatingSystemArch]', " .
			$operatingSystemBuild . " = '$operatingSystemJsonSection[$operatingSystemBuild]', " .
			$operatingSystemName . " = '$operatingSystemJsonSection[$operatingSystemName]', " .
			$operatingSystemVersion . " = '$operatingSystemJsonSection[$operatingSystemVersion]'
			where " . $assetNumberFK . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
		echo "Ativo atualizado\n";
		http_response_code(200);
	} else {
		$queryAsset = mysqli_query($connection, "insert into " . $assetTable . " ($assetNumber,$discarded,$sealNumber,$adRegistered,$standard,$inUse,$tag) values ('$newAsset[$assetNumber]','$newAsset[$discarded]','$newAsset[$sealNumber]','$newAsset[$adRegistered]','$newAsset[$standard]','$newAsset[$inUse]','$newAsset[$tag]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

		$queryAssetFirmware = mysqli_query($connection, "insert into " . $firmwareTable . " ($assetNumberFK,$fwVersion,$fwType,$mediaOperationMode,$secureBoot,$virtualizationTechnology,$tpmVersion) values ('$newAsset[$assetNumber]','$firmwareJsonSection[$fwVersion]','$firmwareJsonSection[$fwType]','$firmwareJsonSection[$mediaOperationMode]','$firmwareJsonSection[$secureBoot]','$firmwareJsonSection[$virtualizationTechnology]','$firmwareJsonSection[$tpmVersion]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

		$queryAssetHardware = mysqli_query($connection, "insert into " . $hardwareTable . " ($assetNumberFK,$brand,$model,$serialNumber,$hwType) values ('$newAsset[$assetNumber]','$hardwareJsonSection[$brand]','$hardwareJsonSection[$model]','$hardwareJsonSection[$serialNumber]','$hardwareJsonSection[$hwType]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

		foreach ($processorJsonSection as $item) {
			$queryAssetProcessor = mysqli_query($connection, "insert into " . $processorTable . " ($assetNumberFK,$processorId,$processorName,$processorFrequency,$processorCores,$processorThreads,$processorCache) values ('$newAsset[$assetNumber]','$item[$processorId]','$item[$processorName]','$item[$processorFrequency]','$item[$processorCores]','$item[$processorThreads]','$item[$processorCache]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		foreach ($ramJsonSection as $item) {
			$queryAssetRam = mysqli_query($connection, "insert into " . $ramTable . " ($assetNumberFK,$ramAmount,$ramType,$ramFrequency,$ramManufacturer,$ramSerialNumber,$ramPartNumber,$ramSlot) values ('$newAsset[$assetNumber]','$item[$ramAmount]','$item[$ramType]','$item[$ramFrequency]','$item[$ramManufacturer]','$item[$ramSerialNumber]','$item[$ramPartNumber]','$item[$ramSlot]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		foreach ($storageJsonSection as $item) {
			$queryAssetStorage = mysqli_query($connection, "insert into " . $storageTable . " ($assetNumberFK,$storageId,$storageType,$storageSize,$storageConnection,$storageModel,$storageSerialNumber,$storageSmart) values ('$newAsset[$assetNumber]','$item[$storageId]','$item[$storageType]','$item[$storageSize]','$item[$storageConnection]','$item[$storageModel]','$item[$storageSerialNumber]','$item[$storageSmart]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		foreach ($videoCardJsonSection as $item) {
			$queryAssetVideoCard = mysqli_query($connection, "insert into " . $videoCardTable . " ($assetNumberFK,$videoCardName,$videoCardRam,$videoCardGpuId) values ('$newAsset[$assetNumber]','$item[$videoCardName]','$item[$videoCardRam]','$item[$videoCardGpuId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryAssetLocation = mysqli_query($connection, "insert into " . $locationTable . " ($assetNumberFK,$roomNumber,$building,$deliveredToRegistrationNumber,$lastDeliveryMadeBy,$lastDeliveryDate) values ('$newAsset[$assetNumber]','$locationJsonSection[$roomNumber]','$locationJsonSection[$building]','$locationJsonSection[$deliveredToRegistrationNumber]','$locationJsonSection[$lastDeliveryMadeBy]','$locationJsonSection[$lastDeliveryDate]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

		foreach ($maintenancesJsonSection as $item) {
			$queryAssetMaintenances = mysqli_query($connection, "insert into " . $maintenancesTable . " ($assetNumberFK,$serviceDate,$serviceType,$batteryChange,$ticketNumber,$agentId) values ('$newAsset[$assetNumber]','$item[$serviceDate]','$item[$serviceType]','$item[$batteryChange]','$item[$ticketNumber]','$item[$agentId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		}

		$queryAssetNetwork = mysqli_query($connection, "insert into " . $networkTable . " ($assetNumberFK,$hostname,$ipAddress,$macAddress) values ('$newAsset[$assetNumber]','$networkJsonSection[$hostname]','$networkJsonSection[$ipAddress]','$networkJsonSection[$macAddress]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

		$queryAssetOperatingSystem = mysqli_query($connection, "insert into " . $operatingSystemTable . " ($assetNumberFK,$operatingSystemName,$operatingSystemVersion,$operatingSystemBuild,$operatingSystemArch) values ('$newAsset[$assetNumber]','$operatingSystemJsonSection[$operatingSystemName]','$operatingSystemJsonSection[$operatingSystemVersion]','$operatingSystemJsonSection[$operatingSystemBuild]','$operatingSystemJsonSection[$operatingSystemArch]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
		echo "Ativo adicionado\n";
		http_response_code(201);
	}
	header("Connection: close");
}
