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

$query = mysqli_query($connection, "select * from asset where assetNumber = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$return_arr = array();

if (file_exists($assetFile) || file_exists($assetChecksum)) {
	unlink($assetFile);
	unlink($assetChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array["assetNumber"] = $row["assetNumber"];
	$row_array["building"] = $row["building"];
	$row_array["roomNumber"] = $row["roomNumber"];
	$row_array["standard"] = $row["standard"];
	$row_array["adRegistered"] = $row["adRegistered"];
	$row_array["inUse"] = $row["inUse"];
	$row_array["sealNumber"] = $row["sealNumber"];
	$row_array["tag"] = $row["tag"];
	$row_array["hwType"] = $row["hwType"];
	$row_array["discarded"] = $row["discarded"];
	$row_array["serviceDate"] = $row["serviceDate"];
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