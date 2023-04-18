<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query2 = mysqli_query($connection, "delete from " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " where id in (select main from (select " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . ".id as main from " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " inner join (select " . $dbAssetArray["ASSET_NUMBER"] . " from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$delete[$i]') as a on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . ".assetNumberFK) as m)") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));
		$query = mysqli_query($connection, "delete from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$delete[$i]'") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($connection));
	}
}

header("Location: queryAsset.php?del=ok");
