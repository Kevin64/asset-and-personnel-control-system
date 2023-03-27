<?php
require_once("connection.php");

$assetNumber = $_GET["asset"];
$numerosealNumber = $_GET["sealNumber"];
$room = $_GET["room"];
$building = $_GET["building"];
$adRegistered = $_GET["ad"];
$standard = $_GET["standard"];
$serviceDate = $_GET["formatacao"];
$formatacoesAnteriores = $_GET["formatacoesAnteriores"];
$brand = $_GET["brand"];
$model = $_GET["model"];
$numeroSerial = $_GET["numeroSerial"];
$processor = $_GET["processor"];
$ram = $_GET["ram"];
$storageSize = $_GET["hd"];
$operatingSystem = $_GET["operatingSystem"];
$nameDoComputador = $_GET["nameDoComputador"];
$macAddress = $_GET["mac"];
$ipAddress = $_GET["ipAddress"];
$model = $_GET["model"];
$inUse = $_GET["inUse"];
$tag = $_GET["tag"];
$hwType = $_GET["type"];
$fwType = $_GET["typeFW"];
$storageType = $_GET["typeStorage"];
$videoCard = $_GET["gpu"];
$mediaOperationMode = $_GET["mediaOperationMode"];
$secureBoot = $_GET["secBoot"];
$virtualizationTechnology = $_GET["vt"];
$tpmVersion = $_GET["tpm"];
$changePilha = $_GET["changePilha"];
$ticketNum = $_GET["ticketNum"];
$agent = $_GET["agent"];

$dataF = substr($serviceDate, 0, 10);
$explodedDate = explode("/", $dataF);
$serviceDate = $explodedDate[2] . "-" . $explodedDate[1] . "-" . $explodedDate[0];
$serviceDateExpandida = $serviceDate;
$modoServico = "Manutenção";

$queryPegaAsset = mysqli_query($connection, "select * from asset where asset = '$assetNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$total = mysqli_num_rows($queryPegaAsset);

if ($total >= 1) {
	$query = mysqli_query($connection, "update asset set sealNumber = '$numerosealNumber', room = '$room', building = '$building', ad = '$adRegistered', standard = '$standard', serviceDate = '$serviceDate', brand = '$brand', model = '$model', serialNumber = '$numeroSerial', processor = '$processor', ram = '$ram', hd = '$storageSize', operatingSystem = '$operatingSystem', hostname = '$nameDoComputador', model = '$model', mac = '$macAddress', ipAddress = '$ipAddress', inUse = '$inUse', tag = '$tag', type = '$hwType', typeFW = '$fwType', typeStorage = '$storageType', gpu = '$videoCard', mediaOperationMode = '$mediaOperationMode', secBoot = '$secureBoot', vt = '$virtualizationTechnology', tpm = '$tpmVersion', changePilha = '$changePilha', ticketNum = '$ticketNum' where asset = '$assetNumber';") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	
	$queryFormatAnt = mysqli_query($connection, "insert into maintenances (assetFK, dataFormatacoesAnteriores, modoServico, changePilha, ticketNum, agent) values('$assetNumber', '$serviceDateExpandida', '$modoServico', '$changePilha', '$ticketNum', '$agent');") or die($translations["ERORR_ADD_DATA"] . mysqli_error($connection));
	$message = $translations["EXISTING_ASSET_UPDATING_DATA"];
}
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

</html>