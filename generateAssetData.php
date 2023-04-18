<?php
require_once("connection.php");

$message = $translations["SUCCESS_ASSET_DATA_EXPORT"];

if (isset($_GET["assetNumber"]))
	$assetNumber = $_GET["assetNumber"];
if (isset($_GET["building"]))
	$building = $_GET["building"];
if (isset($_GET["roomNumber"]))
	$roomNumber = $_GET["roomNumber"];
if (isset($_GET["standard"]))
	$standard = $_GET["standard"];
if (isset($_GET["adRegistered"]))
	$adRegistered = $_GET["adRegistered"];
if (isset($_GET["inUse"]))
	$inUse = $_GET["inUse"];
if (isset($_GET["sealNumber"]))
	$sealNumber = $_GET["sealNumber"];
if (isset($_GET["tag"]))
	$tag = $_GET["tag"];
if (isset($_GET["hwType"]))
	$hwType = $_GET["hwType"];
if (isset($_GET["discarded"]))
	$discarded = $_GET["discarded"];
if (isset($_GET["serviceDate"]))
	$serviceDate = $_GET["serviceDate"];

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

<body bgcolor=blue>
	<center>
		<font size=3 color=white><b><?php echo $message; ?></b></font>
	</center>
</body>

</html>