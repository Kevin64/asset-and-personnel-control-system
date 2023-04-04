<?php
require_once("connection.php");

$assetNumber = $_GET["asset"];
$lastDeliveryDate = $_GET["lastDeliveryDate"];
$deliveredToRegistrationNumber = $_GET["deliveredToRegistrationNumber"];
$lastDeliveryMadeBy = $_GET["lastDeliveryMadeBy"];

$delivDate = substr($lastDeliveryDate, 0, 10);
$explodedDate = explode("/", $delivDate);
$lastDeliveryDate = $explodedDate[2] . "-" . $explodedDate[1] . "-" . $explodedDate[0];

$queryGetAsset = mysqli_query($connection, "select * from asset where asset = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryGetAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update asset set lastDeliveryDate = '$lastDeliveryDate', deliveredToRegistrationNumber = '$deliveredToRegistrationNumber', lastDeliveryMadeBy = '$lastDeliveryMadeBy' where asset = '$assetNumber'") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	$message = $translations["SUCCESS_DELIVERY"];
}
?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body bgcolor=green>
	<center>
		<font size=3 color=white><b><?php echo $message; ?></b></font>
	</center>
</body>

</html>