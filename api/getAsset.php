<?php

header("Content-Type:application/json; charset=UTF-8");

$jsonCmd1 = null;
$jsonCmd2 = null;

if (isset($_GET["assetNumber"]) && $_GET["assetNumber"] != "") {
	$assetNumber = $_GET["assetNumber"];
	require("../connection.php");
	$queryAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$queryStorageList = mysqli_query($connection, "select * from " . $dbStorageArray["STORAGE_TABLE"] . " where " . $dbStorageArray["ASSET_NUMBER_FK"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($queryAsset) > 0) {
		$row1 = mysqli_fetch_array($queryAsset, MYSQLI_ASSOC);
		$i = 0;
		$row1["storageSummary"] = array();
		//$jsonCmd1 = json_encode($row);
		while ($row2 = mysqli_fetch_array($queryStorageList, MYSQLI_ASSOC)) {
			$row1["storageSummary"][$i] = array();
			$row1["storageSummary"][$i] = $row2;
			$i++;
		}
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		echo $jsonFinal;
	}
}

?>