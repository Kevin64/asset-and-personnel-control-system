<?php
require_once("connection.php");

$assetNumber = $_GET["asset"];
$lastDeliveryDate = $_GET["deliveryDate"];
$deliveredToRegistrationNumber = $_GET["regNumreceiver"];
$lastDeliveryMadeBy = $_GET["deliveryman"];

$dataE = substr($lastDeliveryDate, 0, 10);
$explodedDate = explode("/", $dataE);
$lastDeliveryDate = $explodedDate[2] . "-" . $explodedDate[1] . "-" . $explodedDate[0];

$queryPegaAsset = mysqli_query($connection, "select * from asset where asset = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryPegaAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update asset set deliveryDate = '$lastDeliveryDate', regNumreceiver = '$deliveredToRegistrationNumber', deliveryman = '$lastDeliveryMadeBy' where asset = '$assetNumber'") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
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