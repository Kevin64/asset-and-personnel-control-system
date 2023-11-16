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
		if (strtoupper($_SERVER["REQUEST_METHOD"]) == "GET" && isset($_GET["hwUid"]) && $_GET["hwUid"] != "") {
			$hwUid = $_GET["hwUid"];

			$queryAsset = mysqli_query($connection, "select " . $dbAssetArray["ASSET_NUMBER"] . " from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_HASH"] . " = '$hwUid'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			$row = mysqli_fetch_array($queryAsset, MYSQLI_ASSOC);
			$assetNumber = $row["assetNumber"];

			if ($assetNumber != null) {
				$queryAsset = mysqli_query($connection, "select " . $dbAssetArray["ASSET_NUMBER"] . "," . $dbAssetArray["DISCARDED"] . "," . $dbAssetArray["IN_USE"] . "," . $dbAssetArray["NOTE"] . "," . $dbAssetArray["SEAL_NUMBER"] . "," . $dbAssetArray["STANDARD"] . "," . $dbAssetArray["TAG"] . "," . $dbAssetArray["AD_REGISTERED"] . ", " . $dbAssetArray["ASSET_HASH"] . ", " . $dbAssetArray["HW_HASH"] . " from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetFirmware = mysqli_query($connection, "select " . $dbFirmwareArray["MEDIA_OPERATION_MODE"] . "," . $dbFirmwareArray["SECURE_BOOT"] . "," . $dbFirmwareArray["TPM_VERSION"] . "," . $dbFirmwareArray["TYPE"] . "," . $dbFirmwareArray["VERSION"] . "," . $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] . " from " . $dbFirmwareArray["FIRMWARE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetHardware = mysqli_query($connection, "select " . $dbHardwareArray["BRAND"] . "," . $dbHardwareArray["MODEL"] . "," . $dbHardwareArray["SERIAL_NUMBER"] . "," . $dbHardwareArray["TYPE"] . " from " . $dbHardwareArray["HARDWARE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetProcessor = mysqli_query($connection, "select " . $dbProcessorArray["CPU_ID"] . "," . $dbProcessorArray["NAME"] . "," . $dbProcessorArray["FREQUENCY"] . "," . $dbProcessorArray["NUMBER_OF_CORES"] . "," . $dbProcessorArray["NUMBER_OF_THREADS"] . "," . $dbProcessorArray["CACHE"] . " from " . $dbProcessorArray["PROCESSOR_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbProcessorArray["CPU_ID"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetRam = mysqli_query($connection, "select " . $dbRamArray["AMOUNT"] . "," . $dbRamArray["FREQUENCY"] . "," . $dbRamArray["MANUFACTURER"] . "," . $dbRamArray["TYPE"] . "," . $dbRamArray["SERIAL_NUMBER"] . "," . $dbRamArray["PART_NUMBER"] . "," . $dbRamArray["SLOT"] . " from " . $dbRamArray["RAM_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbRamArray["SLOT"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetStorage = mysqli_query($connection, "select " . $dbStorageArray["CONNECTION"] . "," . $dbStorageArray["MODEL"] . "," . $dbStorageArray["SERIAL_NUMBER"] . "," . $dbStorageArray["SIZE"] . "," . $dbStorageArray["SMART_STATUS"] . "," . $dbStorageArray["STORAGE_ID"] . "," . $dbStorageArray["TYPE"] . " from " . $dbStorageArray["STORAGE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbStorageArray["STORAGE_ID"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetVideoCard = mysqli_query($connection, "select " . $dbVideoCardArray["GPU_ID"] . "," . $dbVideoCardArray["NAME"] . "," . $dbVideoCardArray["RAM"] . " from " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbVideoCardArray["GPU_ID"] . " asc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetLocation = mysqli_query($connection, "select " . $dbLocationArray["BUILDING"] . "," . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . "," . $dbLocationArray["LAST_DELIVERY_DATE"] . "," . $dbLocationArray["LAST_DELIVERY_MADE_BY"] . "," . $dbLocationArray["ROOM_NUMBER"] . " from " . $dbLocationArray["LOCATION_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetMaintenance = mysqli_query($connection, "select " . $dbMaintenanceArray["AGENT_ID"] . "," . $dbMaintenanceArray["BATTERY_CHANGE"] . "," . $dbMaintenanceArray["SERVICE_DATE"] . "," . $dbMaintenanceArray["SERVICE_TYPE"] . "," . $dbMaintenanceArray["TICKET_NUMBER"] . " from " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber' order by " . $dbMaintenanceArray["SERVICE_DATE"] . " desc") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetNetwork = mysqli_query($connection, "select " . $dbNetworkArray["HOSTNAME"] . "," . $dbNetworkArray["IP_ADDRESS"] . "," . $dbNetworkArray["MAC_ADDRESS"] . " from " . $dbNetworkArray["NETWORK_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

				$queryAssetOperatingSystem = mysqli_query($connection, "select " . $dbOperatingSystemArray["ARCH"] . "," . $dbOperatingSystemArray["BUILD"] . "," . $dbOperatingSystemArray["NAME"] . "," . $dbOperatingSystemArray["VERSION"] . " from " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

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
			$serviceDate = $dbMaintenanceArray["SERVICE_DATE"];
			$inUse = $dbAssetArray["IN_USE"];
			$tag = $dbAssetArray["TAG"];
			$hwUid = $dbAssetArray["ASSET_HASH"];
			$hwHash = $dbAssetArray["HW_HASH"];

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
					$tag . " = '$newAsset[$tag]', " .
					$hwUid . " = '$newAsset[$hwUid]', " .
					$hwHash . " = '$newAsset[$hwHash]'
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
				$queryAsset = mysqli_query($connection, "insert into " . $assetTable . " ($assetNumber,$discarded,$sealNumber,$adRegistered,$standard,$inUse,$tag,$hwUid,$hwHash) values ('$newAsset[$assetNumber]','$newAsset[$discarded]','$newAsset[$sealNumber]','$newAsset[$adRegistered]','$newAsset[$standard]','$newAsset[$inUse]','$newAsset[$tag]','$newAsset[$hwUid]','$newAsset[$hwHash]');") or die($translations["ERROR_ADD_DATA"] . mysqli_error($connection));

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
		} else {
			$row1 = array("message" => "Invalid hardware id number");
			$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			echo $jsonFinal;
			http_response_code(400);
		}
	} else {
		$row1 = array("message" => "Unauthorized request");
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		echo $jsonFinal;
		http_response_code(401);
	}
} else {
	$row1 = array("message" => "Unauthorized request");
	$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	echo $jsonFinal;
	http_response_code(401);
}
