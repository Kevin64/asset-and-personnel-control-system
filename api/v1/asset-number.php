<?php

header("Content-Type:application/json; charset=UTF-8");
header("WWW-Authenticate: Basic");

if (isset($_SERVER["HTTP_AUTHORIZATION"]) && $_SERVER["HTTP_AUTHORIZATION"] != "") {
	require("../../connection.php");

	$auth = $_SERVER["HTTP_AUTHORIZATION"];
	$auth_array1 = explode(" ", $auth);
	$auth_array2 = explode(":", base64_decode($auth_array1[1]));
	$agent = $auth_array2[0];
	$password = $auth_array2[1];

	$queryAuthenticate = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where " . $dbAgentArray["USERNAME"] . " = '$agent'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$total = mysqli_num_rows($queryAuthenticate);
	$row = mysqli_fetch_array($queryAuthenticate);
	if ($total > 0 && password_verify($password, $row[$dbAgentArray["PASSWORD"]])) {
		if (strtoupper($_SERVER["REQUEST_METHOD"]) == "GET" && isset($_GET[$dbAssetArray["ASSET_NUMBER"]]) && $_GET[$dbAssetArray["ASSET_NUMBER"]] != "") {
			$assetNumber = $_GET[$dbAssetArray["ASSET_NUMBER"]];

			$queryAsset = mysqli_query($connection, "select " . $dbAssetArray["ASSET_NUMBER"] . "," . $dbAssetArray["DISCARDED"] . "," . $dbAssetArray["IN_USE"] . "," . $dbAssetArray["NOTE"] . "," . $dbAssetArray["SEAL_NUMBER"] . "," . $dbAssetArray["STANDARD"] . "," . $dbAssetArray["TAG"] . "," . $dbAssetArray["AD_REGISTERED"] . ", " . $dbAssetArray["ASSET_HASH"] . ", " . $dbAssetArray["HW_HASH"] . " from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetFirmware = mysqli_query($connection, "select " . $dbFirmwareArray["FW_MEDIA_OPERATION_MODE"] . "," . $dbFirmwareArray["FW_SECURE_BOOT"] . "," . $dbFirmwareArray["FW_TPM_VERSION"] . "," . $dbFirmwareArray["FW_TYPE"] . "," . $dbFirmwareArray["FW_VERSION"] . "," . $dbFirmwareArray["FW_VIRTUALIZATION_TECHNOLOGY"] . " from " . $dbFirmwareArray["FIRMWARE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetHardware = mysqli_query($connection, "select " . $dbHardwareArray["HW_BRAND"] . "," . $dbHardwareArray["HW_MODEL"] . "," . $dbHardwareArray["HW_SERIAL_NUMBER"] . "," . $dbHardwareArray["HW_TYPE"] . " from " . $dbHardwareArray["HARDWARE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetProcessor = mysqli_query($connection, "select " . $dbProcessorArray["PROCESSOR_ID"] . "," . $dbProcessorArray["PROC_NAME"] . "," . $dbProcessorArray["PROC_FREQUENCY"] . "," . $dbProcessorArray["PROC_NUMBER_OF_CORES"] . "," . $dbProcessorArray["PROC_NUMBER_OF_THREADS"] . "," . $dbProcessorArray["PROC_CACHE"] . " from " . $dbProcessorArray["PROCESSOR_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbProcessorArray["PROCESSOR_ID"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetRam = mysqli_query($connection, "select " . $dbRamArray["RAM_AMOUNT"] . "," . $dbRamArray["RAM_FREQUENCY"] . "," . $dbRamArray["RAM_MANUFACTURER"] . "," . $dbRamArray["RAM_TYPE"] . "," . $dbRamArray["RAM_SERIAL_NUMBER"] . "," . $dbRamArray["RAM_PART_NUMBER"] . "," . $dbRamArray["RAM_SLOT"] . " from " . $dbRamArray["RAM_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbRamArray["RAM_SLOT"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetStorage = mysqli_query($connection, "select " . $dbStorageArray["STOR_CONNECTION"] . "," . $dbStorageArray["STOR_MODEL"] . "," . $dbStorageArray["STOR_SERIAL_NUMBER"] . "," . $dbStorageArray["STOR_SIZE"] . "," . $dbStorageArray["STOR_SMART_STATUS"] . "," . $dbStorageArray["STOR_ID"] . "," . $dbStorageArray["STOR_TYPE"] . " from " . $dbStorageArray["STORAGE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbStorageArray["STOR_ID"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetVideoCard = mysqli_query($connection, "select " . $dbVideoCardArray["VC_ID"] . "," . $dbVideoCardArray["VC_NAME"] . "," . $dbVideoCardArray["VC_RAM"] . " from " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbVideoCardArray["VC_ID"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetLocation = mysqli_query($connection, "select " . $dbLocationArray["LOC_BUILDING"] . "," . $dbLocationArray["LOC_DELIVERED_TO_REGISTRATION_NUMBER"] . "," . $dbLocationArray["LOC_LAST_DELIVERY_DATE"] . "," . $dbLocationArray["LOC_LAST_DELIVERY_MADE_BY"] . "," . $dbLocationArray["LOC_ROOM_NUMBER"] . " from " . $dbLocationArray["LOCATION_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetMaintenance = mysqli_query($connection, "select " . $dbMaintenanceArray["MAIN_AGENT_ID"] . "," . $dbMaintenanceArray["MAIN_BATTERY_CHANGE"] . "," . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . "," . $dbMaintenanceArray["MAIN_SERVICE_TYPE"] . "," . $dbMaintenanceArray["MAIN_TICKET_NUMBER"] . " from " . $dbMaintenanceArray["MAINTENANCE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . " desc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetNetwork = mysqli_query($connection, "select " . $dbNetworkArray["NET_HOSTNAME"] . "," . $dbNetworkArray["NET_IP_ADDRESS"] . "," . $dbNetworkArray["NET_MAC_ADDRESS"] . " from " . $dbNetworkArray["NETWORK_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$queryAssetOperatingSystem = mysqli_query($connection, "select " . $dbOperatingSystemArray["OS_ARCH"] . "," . $dbOperatingSystemArray["OS_BUILD"] . "," . $dbOperatingSystemArray["OS_NAME"] . "," . $dbOperatingSystemArray["OS_VERSION"] . " from " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			if (mysqli_num_rows($queryAsset) > 0) {
				$row1 = mysqli_fetch_array($queryAsset, MYSQLI_ASSOC);
				$row1["firmware"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetFirmware, MYSQLI_ASSOC)) {
					$row1["firmware"] = $row2;
				}
				$row1["hardware"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetHardware, MYSQLI_ASSOC)) {
					$row1["hardware"] = $row2;
				}
				$i = 0;
				$row1["hardware"]["processor"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetProcessor, MYSQLI_ASSOC)) {
					$row1["hardware"]["processor"][$i] = array();
					$row1["hardware"]["processor"][$i] = $row2;
					$i++;
				}
				$i = 0;
				$row1["hardware"]["ram"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetRam, MYSQLI_ASSOC)) {
					$row1["hardware"]["ram"][$i] = array();
					$row1["hardware"]["ram"][$i] = $row2;
					$i++;
				}
				$i = 0;
				$row1["hardware"]["storage"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetStorage, MYSQLI_ASSOC)) {
					$row1["hardware"]["storage"][$i] = array();
					$row1["hardware"]["storage"][$i] = $row2;
					$i++;
				}
				$i = 0;
				$row1["hardware"]["videoCard"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetVideoCard, MYSQLI_ASSOC)) {
					$row1["hardware"]["videoCard"][$i] = array();
					$row1["hardware"]["videoCard"][$i] = $row2;
					$i++;
				}
				$row1["location"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetLocation, MYSQLI_ASSOC)) {
					$row1["location"] = $row2;
				}
				$i = 0;
				$row1["maintenances"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetMaintenance, MYSQLI_ASSOC)) {
					$row1["maintenances"][$i] = array();
					$row1["maintenances"][$i] = $row2;
					$i++;
				}
				$row1["network"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetNetwork, MYSQLI_ASSOC)) {
					$row1["network"] = $row2;
				}
				$row1["operatingSystem"] = array();
				while ($row2 = mysqli_fetch_array($queryAssetOperatingSystem, MYSQLI_ASSOC)) {
					$row1["operatingSystem"] = $row2;
				}
				$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
				http_response_code(200);
				echo $jsonFinal;
			} else {
				$row1 = array("message" => "Not Found");
				$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
				http_response_code(204);
				echo $jsonFinal;
			}
		} else if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {
			$json = file_get_contents('php://input');
			$newAsset = json_decode($json, true);

			$assetTable = $dbAssetArray["ASSET_TABLE"];
			$assetNumber = $dbAssetArray["ASSET_NUMBER"];
			$assetNumberFK = $dbAssetArray["ASSET_NUMBER_FK"];
			$discarded = $dbAssetArray["DISCARDED"];
			$sealNumber = $dbAssetArray["SEAL_NUMBER"];
			$adRegistered = $dbAssetArray["AD_REGISTERED"];
			$standard = $dbAssetArray["STANDARD"];
			$serviceDate = $dbMaintenanceArray["MAIN_SERVICE_DATE"];
			$inUse = $dbAssetArray["IN_USE"];
			$tag = $dbAssetArray["TAG"];
			$hwHash = $dbAssetArray["HW_HASH"];
			$assetHash = $dbAssetArray["ASSET_HASH"];

			$firmwareTable = $dbFirmwareArray["FIRMWARE_TABLE"];
			$fwVersion = $dbFirmwareArray["FW_VERSION"];
			$fwType = $dbFirmwareArray["FW_TYPE"];
			$mediaOperationMode = $dbFirmwareArray["FW_MEDIA_OPERATION_MODE"];
			$secureBoot = $dbFirmwareArray["FW_SECURE_BOOT"];
			$virtualizationTechnology = $dbFirmwareArray["FW_VIRTUALIZATION_TECHNOLOGY"];
			$tpmVersion = $dbFirmwareArray["FW_TPM_VERSION"];

			$hardwareTable = $dbHardwareArray["HARDWARE_TABLE"];
			$brand = $dbHardwareArray["HW_BRAND"];
			$model = $dbHardwareArray["HW_MODEL"];
			$serialNumber = $dbHardwareArray["HW_SERIAL_NUMBER"];
			$hwType = $dbHardwareArray["HW_TYPE"];

			$processorTable = $dbProcessorArray["PROCESSOR_TABLE"];
			$processorId = $dbProcessorArray["PROCESSOR_ID"];
			$processorName = $dbProcessorArray["PROC_NAME"];
			$processorFrequency = $dbProcessorArray["PROC_FREQUENCY"];
			$processorCores = $dbProcessorArray["PROC_NUMBER_OF_CORES"];
			$processorThreads = $dbProcessorArray["PROC_NUMBER_OF_THREADS"];
			$processorCache = $dbProcessorArray["PROC_CACHE"];

			$ramTable = $dbRamArray["RAM_TABLE"];
			$ramAmount = $dbRamArray["RAM_AMOUNT"];
			$ramType = $dbRamArray["RAM_TYPE"];
			$ramFrequency = $dbRamArray["RAM_FREQUENCY"];
			$ramManufacturer = $dbRamArray["RAM_MANUFACTURER"];
			$ramSerialNumber = $dbRamArray["RAM_SERIAL_NUMBER"];
			$ramPartNumber = $dbRamArray["RAM_PART_NUMBER"];
			$ramSlot = $dbRamArray["RAM_SLOT"];

			$storageTable = $dbStorageArray["STORAGE_TABLE"];
			$storageId = $dbStorageArray["STOR_ID"];
			$storageType = $dbStorageArray["STOR_TYPE"];
			$storageSize = $dbStorageArray["STOR_SIZE"];
			$storageConnection = $dbStorageArray["STOR_CONNECTION"];
			$storageModel = $dbStorageArray["STOR_MODEL"];
			$storageSerialNumber = $dbStorageArray["STOR_SERIAL_NUMBER"];
			$storageSmart = $dbStorageArray["STOR_SMART_STATUS"];

			$videoCardTable = $dbVideoCardArray["VIDEO_CARD_TABLE"];
			$videoCardName = $dbVideoCardArray["VC_NAME"];
			$videoCardRam = $dbVideoCardArray["VC_RAM"];
			$videoCardGpuId = $dbVideoCardArray["VC_ID"];

			$locationTable = $dbLocationArray["LOCATION_TABLE"];
			$roomNumber = $dbLocationArray["LOC_ROOM_NUMBER"];
			$building = $dbLocationArray["LOC_BUILDING"];
			$deliveredToRegistrationNumber = $dbLocationArray["LOC_DELIVERED_TO_REGISTRATION_NUMBER"];
			$lastDeliveryMadeBy = $dbLocationArray["LOC_LAST_DELIVERY_MADE_BY"];
			$lastDeliveryDate = $dbLocationArray["LOC_LAST_DELIVERY_DATE"];

			$maintenancesTable = $dbMaintenanceArray["MAINTENANCE_TABLE"];
			$serviceDate = $dbMaintenanceArray["MAIN_SERVICE_DATE"];
			$serviceType = $dbMaintenanceArray["MAIN_SERVICE_TYPE"];
			$batteryChange = $dbMaintenanceArray["MAIN_BATTERY_CHANGE"];
			$ticketNumber = $dbMaintenanceArray["MAIN_TICKET_NUMBER"];
			$agentId = $dbMaintenanceArray["MAIN_AGENT_ID"];

			$networkTable = $dbNetworkArray["NETWORK_TABLE"];
			$hostname = $dbNetworkArray["NET_HOSTNAME"];
			$macAddress = $dbNetworkArray["NET_MAC_ADDRESS"];
			$ipAddress = $dbNetworkArray["NET_IP_ADDRESS"];

			$operatingSystemTable = $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"];
			$operatingSystemName = $dbOperatingSystemArray["OS_NAME"];
			$operatingSystemVersion = $dbOperatingSystemArray["OS_VERSION"];
			$operatingSystemBuild = $dbOperatingSystemArray["OS_BUILD"];
			$operatingSystemArch = $dbOperatingSystemArray["OS_ARCH"];

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
					$tag . " = '$newAsset[$tag]', " .
					$hwHash . " = '$newAsset[$hwHash]', " .
					$assetHash . " = '$newAsset[$assetHash]'
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
					$queryAssetProcessor = mysqli_query($connection, "insert into " . $processorTable . " ($assetNumberFK,$processorId,$processorName,$processorFrequency,$processorCores,$processorThreads,$processorCache) values ('$newAsset[$assetNumber]','$item[$processorId]','$item[$processorName]','$item[$processorFrequency]','$item[$processorCores]','$item[$processorThreads]','$item[$processorCache]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
				}

				$queryRamDel = mysqli_query($connection, "delete " . $ramTable . " from " . $ramTable . " inner join " . $assetTable . " on " . $ramTable . "." . $assetNumberFK . " = " . $assetTable . "." . $assetNumber . " where " . $assetTable . "." . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));

				foreach ($ramJsonSection as $item) {
					$queryAssetRam = mysqli_query($connection, "insert into " . $ramTable . " ($assetNumberFK,$ramAmount,$ramType,$ramFrequency,$ramManufacturer,$ramSerialNumber,$ramPartNumber,$ramSlot) values ('$newAsset[$assetNumber]','$item[$ramAmount]','$item[$ramType]','$item[$ramFrequency]','$item[$ramManufacturer]','$item[$ramSerialNumber]','$item[$ramPartNumber]','$item[$ramSlot]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
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
					if ($item[$serviceType] != "2")
						$queryAssetMaintenance = mysqli_query($connection, "insert into " . $maintenancesTable . " ($assetNumberFK,$serviceDate,$serviceType,$batteryChange,$ticketNumber,$agentId) values ('$newAsset[$assetNumber]','$item[$serviceDate]','$item[$serviceType]','$item[$batteryChange]','$item[$ticketNumber]','$item[$agentId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
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
				http_response_code(200);
				echo "Ativo atualizado\n";
			} else {
				$queryAsset = mysqli_query($connection, "insert into " . $assetTable . " ($assetNumber,$discarded,$sealNumber,$adRegistered,$standard,$inUse,$tag,$hwHash,$assetHash) values ('$newAsset[$assetNumber]','$newAsset[$discarded]','$newAsset[$sealNumber]','$newAsset[$adRegistered]','$newAsset[$standard]','$newAsset[$inUse]','$newAsset[$tag]','$newAsset[$hwHash]','$newAsset[$assetHash]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

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
					$queryAssetMaintenance = mysqli_query($connection, "insert into " . $maintenancesTable . " ($assetNumberFK,$serviceDate,$serviceType,$batteryChange,$ticketNumber,$agentId) values ('$newAsset[$assetNumber]','$item[$serviceDate]','$item[$serviceType]','$item[$batteryChange]','$item[$ticketNumber]','$item[$agentId]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
				}

				$queryAssetNetwork = mysqli_query($connection, "insert into " . $networkTable . " ($assetNumberFK,$hostname,$ipAddress,$macAddress) values ('$newAsset[$assetNumber]','$networkJsonSection[$hostname]','$networkJsonSection[$ipAddress]','$networkJsonSection[$macAddress]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

				$queryAssetOperatingSystem = mysqli_query($connection, "insert into " . $operatingSystemTable . " ($assetNumberFK,$operatingSystemName,$operatingSystemVersion,$operatingSystemBuild,$operatingSystemArch) values ('$newAsset[$assetNumber]','$operatingSystemJsonSection[$operatingSystemName]','$operatingSystemJsonSection[$operatingSystemVersion]','$operatingSystemJsonSection[$operatingSystemBuild]','$operatingSystemJsonSection[$operatingSystemArch]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));
				http_response_code(201);
				echo "Ativo adicionado\n";
			}
			header("Connection: close");
		} else {
			$row1 = array("message" => "Invalid asset number");
			$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			http_response_code(400);
			echo $jsonFinal;
		}
	} else {
		$row1 = array("message" => "Unauthorized request");
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		http_response_code(401);
		echo $jsonFinal;
	}
} else {
	$row1 = array("message" => "Unauthorized request");
	$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	http_response_code(401);
	echo $jsonFinal;
}
