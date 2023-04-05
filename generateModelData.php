<?php
require_once("connection.php");

$message = $translations["SUCCESS_MODEL_DATA_EXPORT"];

if (isset($_GET["brand"]))
	$brand = $_GET["brand"];
if (isset($_GET["model"]))
	$model = $_GET["model"];
if (isset($_GET["fwVersion"]))
	$fwVersion = $_GET["fwVersion"];
if (isset($_GET["fwType"]))
	$hwType = $_GET["fwType"];
if (isset($_GET["tpmVersion"]))
	$tpmVersion = $_GET["tpmVersion"];
if (isset($_GET["mediaOperationMode"]))
	$mediaOperationMode = $_GET["mediaOperationMode"];

$modelFile = __DIR__ . "/output/model.json";
$modelChecksum = __DIR__ . "/output/model-checksum.txt";

$query = mysqli_query($connection, "select * from model") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$return_arr = array();

if (file_exists($modelFile) || file_exists($modelChecksum)) {
	unlink($modelFile);
	unlink($modelChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array["id"] = $row["id"];
	$row_array["brand"] = $row["brand"];
	$row_array["model"] = $row["model"];
	$row_array["fwVersion"] = $row["fwVersion"];
	$row_array["fwType"] = $row["fwType"];
	$row_array["tpmVersion"] = $row["tpmVersion"];
	$row_array["mediaOperationMode"] = $row["mediaOperationMode"];
	array_push($return_arr, $row_array);

	$fp = fopen($modelFile, "w");
	$jsonCmd = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
	fwrite($fp, $jsonCmd);
	$checksum = hash("sha256", $jsonCmd);
	$fp2 = fopen($modelChecksum, "w");
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
}

if (!isset($row_array)) {
	$fp = fopen($modelFile, "w");
	fwrite($fp, json_encode($return_arr));
	$checksum = hash("sha256", json_encode($return_arr));
	$fp2 = fopen($modelChecksum, "w");
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