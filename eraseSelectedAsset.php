<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query = mysqli_query($connection, "delete " . $dbAssetArray["ASSET_TABLE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . ", " . $dbStorageArray["STORAGE_TABLE"] . " from " . $dbAssetArray["ASSET_TABLE"] . " inner join " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " inner join " . $dbStorageArray["STORAGE_TABLE"] . " on " . $dbAssetArray["ASSET_TABLE"] . "." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["ASSET_NUMBER_FK"] . " AND " . $dbAssetArray["ASSET_TABLE"] . "." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["ASSET_NUMBER_FK"] . " where " . $dbAssetArray["ASSET_TABLE"] . ".id = '$delete[$i]'") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));
	}
}

header("Location: queryAsset.php?del=ok");
