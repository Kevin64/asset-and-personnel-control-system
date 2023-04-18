<?php
require_once("connection.php");

$assetNumber = $_GET[$dbAssetArray["ASSET_NUMBER"]];
$lastDeliveryDate = $_GET[$dbAssetArray["LAST_DELIVERY_DATE"]];
$deliveredToRegistrationNumber = $_GET[$dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"]];
$lastDeliveryMadeBy = $_GET[$dbAssetArray["LAST_DELIVERY_MADE_BY"]];

$delivDate = substr($lastDeliveryDate, 0, 10);
$explodedDate = explode("/", $delivDate);
$lastDeliveryDate = $explodedDate[2] . "-" . $explodedDate[1] . "-" . $explodedDate[0];

$queryGetAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryGetAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["LAST_DELIVERY_DATE"] . " = '$lastDeliveryDate', " . $dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = '$deliveredToRegistrationNumber', lastDeliveryMadeBy = '$lastDeliveryMadeBy' where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
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