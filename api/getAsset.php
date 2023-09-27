<?php

header("Content-Type:application/json; charset=UTF-8");

$jsonCmd1 = null;
$jsonCmd2 = null;

if (isset($_GET["assetNumber"]) && $_GET["assetNumber"] != "") {
	$assetNumber = $_GET["assetNumber"];
	require("../connection.php");
	
	$queryAsset = mysqli_query($connection, "select " . $dbAssetArray["ASSET_NUMBER"] . "," . $dbAssetArray["DISCARDED"] . "," . $dbAssetArray["IN_USE"] . "," . $dbAssetArray["NOTE"] . "," . $dbAssetArray["SEAL_NUMBER"] . "," . $dbAssetArray["STANDARD"] . "," . $dbAssetArray["TAG"] . "," . $dbAssetArray["AD_REGISTERED"] . " from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetFirmware = mysqli_query($connection, "select " . $dbFirmwareArray["MEDIA_OPERATION_MODE"] . "," . $dbFirmwareArray["SECURE_BOOT"] . "," . $dbFirmwareArray["TPM_VERSION"] . "," . $dbFirmwareArray["TYPE"] . "," . $dbFirmwareArray["VERSION"] . "," . $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] . " from " . $dbFirmwareArray["FIRMWARE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetHardware = mysqli_query($connection, "select " . $dbHardwareArray["BRAND"] . "," . $dbHardwareArray["MODEL"] . "," . $dbHardwareArray["PROCESSOR"] . "," . $dbHardwareArray["SERIAL_NUMBER"] . "," . $dbHardwareArray["TYPE"] . " from " . $dbHardwareArray["HARDWARE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetRam = mysqli_query($connection, "select " . $dbRamArray["AMOUNT"] . "," . $dbRamArray["FREQUENCY"] . "," . $dbRamArray["OCCUPIED_SLOTS"] . "," . $dbRamArray["TOTAL_SLOTS"] . "," . $dbRamArray["TYPE"] . " from " . $dbRamArray["RAM_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetStorage = mysqli_query($connection, "select " . $dbStorageArray["CONNECTION"] . "," . $dbStorageArray["MODEL"] . "," . $dbStorageArray["SERIAL_NUMBER"] . "," . $dbStorageArray["SIZE"] . "," . $dbStorageArray["SMART_STATUS"] . "," . $dbStorageArray["STORAGE_ID"] . "," . $dbStorageArray["TYPE"] . " from " . $dbStorageArray["STORAGE_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetVideoCard = mysqli_query($connection, "select " . $dbVideoCardArray["GPU_ID"] . "," . $dbVideoCardArray["NAME"] . "," . $dbVideoCardArray["RAM"] . " from " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetLocation = mysqli_query($connection, "select " . $dbLocationArray["BUILDING"] . "," . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . "," . $dbLocationArray["LAST_DELIVERY_DATE"] . "," . $dbLocationArray["LAST_DELIVERY_MADE_BY"] . "," . $dbLocationArray["ROOM_NUMBER"] . " from " . $dbLocationArray["LOCATION_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetMaintenance = mysqli_query($connection, "select " . $dbMaintenanceArray["AGENT_ID"] . "," . $dbMaintenanceArray["BATTERY_CHANGE"] . "," . $dbMaintenanceArray["SERVICE_DATE"] . "," . $dbMaintenanceArray["SERVICE_TYPE"] . "," . $dbMaintenanceArray["TICKET_NUMBER"] . " from " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetNetwork = mysqli_query($connection, "select " . $dbNetworkArray["HOSTNAME"] . "," . $dbNetworkArray["IP_ADDRESS"] . "," . $dbNetworkArray["MAC_ADDRESS"] . " from " . $dbNetworkArray["NETWORK_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$queryAssetOperatingSystem = mysqli_query($connection, "select " . $dbOperatingSystemArray["ARCH"] . "," . $dbOperatingSystemArray["BUILD"] . "," . $dbOperatingSystemArray["NAME"] . "," . $dbOperatingSystemArray["VERSION"] . " from " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($queryAsset) > 0) {
		$row1 = mysqli_fetch_array($queryAsset, MYSQLI_ASSOC);
		$i = 0;
		$row1["firmware"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetFirmware, MYSQLI_ASSOC)) {
			$row1["firmware"] = $row2;
			$i++;
		}
		$row1["hardware"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetHardware, MYSQLI_ASSOC)) {
			$row1["hardware"] = $row2;
			$i++;
		}
		$row1["hardware"]["ram"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetRam, MYSQLI_ASSOC)) {
			$row1["hardware"]["ram"] = $row2;
			$i++;
		}
		$row1["hardware"]["storage"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetStorage, MYSQLI_ASSOC)) {
			$row1["hardware"]["storage"][$i] = array();
			$row1["hardware"]["storage"][$i] = $row2;
			$i++;
		}
		$row1["hardware"]["videoCard"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetVideoCard, MYSQLI_ASSOC)) {
			$row1["hardware"]["videoCard"] = $row2;
			$i++;
		}
		$row1["location"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetLocation, MYSQLI_ASSOC)) {
			$row1["location"] = $row2;
			$i++;
		}
		$row1["maintenances"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetMaintenance, MYSQLI_ASSOC)) {
			$row1["maintenances"] = $row2;
			$i++;
		}
		$row1["network"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetNetwork, MYSQLI_ASSOC)) {
			$row1["network"] = $row2;
			$i++;
		}
		$row1["operatingSystem"] = array();
		while ($row2 = mysqli_fetch_array($queryAssetOperatingSystem, MYSQLI_ASSOC)) {
			$row1["operatingSystem"] = $row2;
			$i++;
		}
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		echo $jsonFinal;
	}
}

?>