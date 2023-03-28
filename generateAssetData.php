<?php
require_once("connection.php");

$message = $translations["SUCCESS_ASSET_DATA_EXPORT"];

if(isset($_GET["asset"]))
	$assetNumber = $_GET["asset"];
if(isset($_GET["building"]))
	$building = $_GET["building"];
if(isset($_GET["room"]))
	$room = $_GET["room"];
if(isset($_GET["standard"]))
	$standard = $_GET["standard"];
if(isset($_GET["adRegistered"]))
	$adRegistered = $_GET["adRegistered"];
if(isset($_GET["inUse"]))
	$inUse = $_GET["inUse"];
if(isset($_GET["sealNumber"]))
	$sealNumber = $_GET["sealNumber"];
if(isset($_GET["tag"]))
	$tag = $_GET["tag"];
if(isset($_GET["hwType"]))
	$hwType = $_GET["hwType"];
if(isset($_GET["discarded"]))
	$discarded = $_GET["discarded"];
if(isset($_GET["serviceDate"]))
	$serviceDate = $_GET["serviceDate"];

$pcFile = __DIR__."/output/pc.json";
$pcChecksum = __DIR__."/output/pc-checksum.txt";

$query = mysqli_query($connection, "select * from asset where asset = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$return_arr = array();

if (file_exists($pcFile) || file_exists($pcChecksum)) {
	unlink($pcFile);
	unlink($pcChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array["asset"] = $row["asset"];
	$row_array["building"] = $row["building"];
	$row_array["room"] = $row["room"];
	$row_array["standard"] = $row["standard"];
	$row_array["adRegistered"] = $row["adRegistered"];
	$row_array["inUse"] = $row["inUse"];
	$row_array["sealNumber"] = $row["sealNumber"];
	$row_array["tag"] = $row["tag"];
	$row_array["type"] = $row["type"];
	$row_array["discarded"] = $row["discarded"];
	$row_array["serviceDate"] = $row["serviceDate"];
	array_push($return_arr, $row_array);

	$fp = fopen($pcFile, "w");
	$jsonCmd = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
	fwrite($fp, $jsonCmd);
	$checksum = hash("sha256", $jsonCmd);
	$fp2 = fopen($pcChecksum, "w");
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
}

if(!isset($row_array)) {
	$fp = fopen($pcFile, "w");
	fwrite($fp, json_encode($return_arr));
	$checksum = hash("sha256", json_encode($return_arr));
	$fp2 = fopen($pcChecksum, "w");
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