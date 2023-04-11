<?php
require_once("connection.php");

$assetNumber = $_GET["assetNumber"];
$sealNumber = $_GET["sealNumber"];
$room = $_GET["room"];
$building = $_GET["building"];
$adRegistered = $_GET["adRegistered"];
$standard = $_GET["standard"];
$serviceDate = $_GET["serviceDate"];
$brand = $_GET["brand"];
$model = $_GET["model"];
$serialNumber = $_GET["serialNumber"];
$processor = $_GET["processor"];
$ram = $_GET["ram"];
$storageSize = $_GET["storageSize"];
$operatingSystem = $_GET["operatingSystem"];
$hostname = $_GET["hostname"];
$macAddress = $_GET["macAddress"];
$ipAddress = $_GET["ipAddress"];
$fwVersion = $_GET["fwVersion"];
$inUse = $_GET["inUse"];
$tag = $_GET["tag"];
$hwType = $_GET["hwType"];
$fwType = $_GET["fwType"];
$storageType = $_GET["storageType"];
$videoCard = $_GET["videoCard"];
$mediaOperationMode = $_GET["mediaOperationMode"];
$secureBoot = $_GET["secureBoot"];
$virtualizationTechnology = $_GET["virtualizationTechnology"];
$tpmVersion = $_GET["tpmVersion"];
$batteryChange = $_GET["batteryChange"];
$ticketNumber = $_GET["ticketNumber"];
$agent = $_GET["agent"];

$serviceType = $serviceTypesArray[1];

$queryGetAsset = mysqli_query($connection, "select * from asset where assetNumber = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryGetAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update asset set sealNumber = '$sealNumber', room = '$room', building = '$building', adRegistered = '$adRegistered', standard = '$standard', serviceDate = '$serviceDate', brand = '$brand', model = '$model', serialNumber = '$serialNumber', processor = '$processor', ram = '$ram', storageSize = '$storageSize', operatingSystem = '$operatingSystem', hostname = '$hostname', fwVersion = '$fwVersion', macAddress = '$macAddress', ipAddress = '$ipAddress', inUse = '$inUse', tag = '$tag', hwType = '$hwType', fwType = '$fwType', storageType = '$storageType', videoCard = '$videoCard', mediaOperationMode = '$mediaOperationMode', secureBoot = '$secureBoot', virtualizationTechnology = '$virtualizationTechnology', tpmVersion = '$tpmVersion' where assetNumber = '$assetNumber';") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

	$queryFormatAnt = mysqli_query($connection, "insert into maintenances (assetNumberFK, previousServiceDates, serviceType, batteryChange, ticketNumber, agent) values('$assetNumber', '$serviceDate', '$serviceType', '$batteryChange', '$ticketNumber', '$agent');") or die($translations["ERORR_ADD_DATA"] . mysqli_error($connection));
	$message = $translations["EXISTING_ASSET_UPDATING_DATA"];
	?>

	<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<title></title>
	</head>

	<body bgcolor=green>
		<center>
			<hr style="height:0pt; visibility:hidden;" />
			<font size=3 color=white><b><?php echo $message; ?></b></font>
			</td>
		</center>
	</body>
	<?php
} else {
	$message = $translations["NEED_FORMATTING_FIRST"];
	?>

	<!DOCTYPE html>

	<head>
		<meta charset="utf-8">
		<title></title>
	</head>

	<body bgcolor=red>
		<center>
			<hr style="height:0pt; visibility:hidden;" />
			<font size=3 color=white><b><?php echo $message; ?></b></font>
			</td>
		</center>
	</body>

	</html>
	<?php
}
?>