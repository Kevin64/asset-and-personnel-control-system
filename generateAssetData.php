<?php
require_once("connection.php");

$messageSuccess = $translations["SUCCESS_ASSET_DATA_EXPORT"];
$messageError = $translations["ERROR_ASSET_DATA_EXPORT"];

if (isset($_GET["assetNumber"])) {
	$assetNumber = $_GET["assetNumber"];

	$assetFile = __DIR__ . "/output/asset.json";
	$assetChecksum = __DIR__ . "/output/asset-checksum.txt";

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$return_arr = array();

	if (file_exists($assetFile) || file_exists($assetChecksum)) {
		unlink($assetFile);
		unlink($assetChecksum);
	}

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
		array_push($return_arr, $row_array);

		$fp = fopen($assetFile, "w");
		$jsonCmd = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
		fwrite($fp, $jsonCmd);
		$checksum = hash("sha256", $jsonCmd);
		$fp2 = fopen($assetChecksum, "w");
		fwrite($fp2, $checksum);
		fclose($fp);
		fclose($fp2);
	}

	if (!isset($row_array)) {
		$fp = fopen($assetFile, "w");
		fwrite($fp, json_encode($return_arr));
		$checksum = hash("sha256", json_encode($return_arr));
		$fp2 = fopen($assetChecksum, "w");
		fwrite($fp2, $checksum);
		fclose($fp);
		fclose($fp2);
	}
?>

	<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<title></title>
	</head>

	<body bgcolor=<?php echo $colorArray["SUCCESS_EXPORT_BACKGROUND"] ?>>
		<center>
			<font size=3 color=white><b><?php echo $messageSuccess; ?></b></font>
		</center>
	</body>

	</html>
<?php
} else {
?>

	<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<title></title>
	</head>

	<body bgcolor=<?php echo $colorArray["ERROR"] ?>>
		<center>
			<font size=3 color=white><b><?php echo $messageError; ?></b></font>
		</center>
	</body>

	</html>
<?php
}
?>