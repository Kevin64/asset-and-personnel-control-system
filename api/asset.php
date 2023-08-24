<?php

header("Content-Type:application/json");

if (isset($_GET["assetNumber"]) && $_GET["assetNumber"] != "") {
	$assetNumber = $_GET["assetNumber"];
	include("../connection.php");
	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$row_array["assetNumber"] = $row[$dbAssetArray["ASSET_NUMBER"]];
			$row_array["building"] = $row[$dbAssetArray["BUILDING"]];
			$row_array["roomNumber"] = $row[$dbAssetArray["ROOM_NUMBER"]];
			$row_array["standard"] = $row[$dbAssetArray["STANDARD"]];
			$row_array["adRegistered"] = $row[$dbAssetArray["AD_REGISTERED"]];
			$row_array["inUse"] = $row[$dbAssetArray["IN_USE"]];
			$row_array["sealNumber"] = $row[$dbAssetArray["SEAL_NUMBER"]];
			$row_array["tag"] = $row[$dbAssetArray["TAG"]];
			$row_array["hwType"] = $row[$dbAssetArray["HW_TYPE"]];
			$row_array["discarded"] = $row[$dbAssetArray["DISCARDED"]];
			$row_array["serviceDate"] = $row[$dbAssetArray["SERVICE_DATE"]];
			$jsonCmd = json_encode($row_array, JSON_UNESCAPED_UNICODE);
		}
		echo $jsonCmd;
	}
}
