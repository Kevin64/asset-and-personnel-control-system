<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$idAsset = null;
$assetFK = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	if (isset($_GET["id"]))
		$idAsset = $_GET["id"];

	if (isset($_GET["assetNumberFK"]))
		$assetFK = $_GET["assetNumberFK"];

	$query = mysqli_query($connection, "select * from asset where id = '$idAsset'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
	$queryFormatAnt = mysqli_query($connection, "select maintenances.previousServiceDates, maintenances.serviceType, maintenances.batteryChange, maintenances.ticketNumber, maintenances.agent from (select * from asset where id = '$idAsset') as a inner join maintenances on a.assetNumber = maintenances.assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
} else {
	$idAsset = $_POST["txtIdAsset"];
	$assetNumber = $_POST["txtAssetNumber"];
	if (isset($_POST["chkBoxDiscard"])) {
		$discarded = $_POST["chkBoxDiscard"];
	} else {
		$discarded = "0";
	}
	$building = $_POST["txtBuilding"];
	$room = $_POST["txtRoom"];
	$deliveredToRegistrationNumber = $_POST["txtDeliveredToRegistrationNumber"];
	if (isset($_POST["txtLastDeliveryMadeBy"]))
		$lastDeliveryMadeBy = $_POST["txtLastDeliveryMadeBy"];
	$lastDeliveryDate = $_POST["txtLastDeliveryDate"];
	$standard = $_POST["txtStandard"];
	$note = $_POST["txtNote"];
	$serviceDate = $_POST["txtServiceDate"];
	if (isset($_POST["txtPreviousMaintenancesDate"]))
		$maintenancesAnterioresData = $_POST["txtPreviousMaintenancesDate"];
	if (isset($_POST["txtPreviousMaintenancesServiceType"]))
		$maintenancesAnterioresModo = $_POST["txtPreviousMaintenancesServiceType"];
	if (isset($_POST["txtPreviousMaintenancesBattery"]))
		$maintenancesAnterioresPilha = $_POST["txtPreviousMaintenancesBattery"];
	if (isset($_POST["txtPreviousMaintenancesTicket"]))
		$maintenancesAnterioresTicket = $_POST["txtPreviousMaintenancesTicket"];
	if (isset($_POST["txtPreviousMaintenancesAgent"]))
		$maintenancesAnterioresAgente = $_POST["txtPreviousMaintenancesAgent"];
	$adRegistered = $_POST["txtAdRegistered"];
	$brand = $_POST["txtBrand"];
	$model = $_POST["txtModel"];
	$serialNumber = $_POST["txtSerialNumber"];
	$processor = $_POST["txtProcessor"];
	$ram = $_POST["txtRam"];
	$storageSize = $_POST["txtStorageSize"];
	$operatingSystem = $_POST["txtOperatingSystem"];
	$hostname = $_POST["txtHostname"];
	$inUse = $_POST["txtInUse"];
	$sealNumber = $_POST["txtSealNumber"];
	$tag = $_POST["txtTag"];
	$hwType = $_POST["txtHwType"];
	$fwType = $_POST["txtFwType"];
	$macAddress = $_POST["txtMacAddress"];
	$ipAddress = $_POST["txtIpAddress"];
	$fwVersion = $_POST["txtFwVersion"];
	$storageType = $_POST["txtStorageType"];
	$videoCard = $_POST["txtVideoCard"];
	$mediaOperationMode = $_POST["txtMediaOperationMode"];
	$secureBoot = $_POST["txtSecureBoot"];
	$virtualizationTechnology = $_POST["txtVirtualizationTechnology"];
	$tpmVersion = $_POST["txtTpmVersion"];

	//currentizando os dados do patrimônio
	mysqli_query($connection, "update asset set assetNumber = '$assetNumber', discarded = '$discarded', building = '$building', room = '$room', deliveredToRegistrationNumber = '$deliveredToRegistrationNumber', lastDeliveryDate = '$lastDeliveryDate', standard = '$standard', note = '$note', serviceDate = '$serviceDate', adRegistered = '$adRegistered', brand = '$brand', model = '$model', serialNumber = '$serialNumber', processor = '$processor', ram = '$ram', storageSize = '$storageSize', operatingSystem = '$operatingSystem', hostname = '$hostname', fwVersion = '$fwVersion', inUse = '$inUse', sealNumber = '$sealNumber', tag = '$tag', hwType = '$hwType', fwType = '$fwType', storageType = '$storageType', macAddress = '$macAddress', ipAddress = '$ipAddress', videoCard = '$videoCard', mediaOperationMode = '$mediaOperationMode', secureBoot = '$secureBoot', virtualizationTechnology = '$virtualizationTechnology', tpmVersion = '$tpmVersion' where id = '$idAsset'") or die($translations["ERROR_UPDATE_ASSET_DATA"] . mysqli_error($connection));

	$query = mysqli_query($connection, "select * from asset where id = '$idAsset'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryFormatAnt = mysqli_query($connection, "select maintenances.previousServiceDates, maintenances.serviceType, maintenances.batteryChange, maintenances.ticketNumber, maintenances.agent from (select * from asset where id = '$idAsset') as a inner join maintenances on a.assetNumber = maintenances.assetNumberFK") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
}
?>
<div id="middle">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<form action="formDetailAsset.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2>Detalhes do patrimônio</h2><br>
		<?php
		if ($send == 1)
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_ASSET_DATA"] . "</font><br><br>";
		?>
		<label id=asteriskWarning>Os campos branddos com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idAsset = $result["id"];
				$assetNumber = $result["assetNumber"];
				$discarded = $result["discarded"];
				$building = $result["building"];
				$room = $result["room"];
				$deliveredToRegistrationNumber = $result["deliveredToRegistrationNumber"];
				$lastDeliveryDate = $result["lastDeliveryDate"];
				$lastDeliveryMadeBy = $result["lastDeliveryMadeBy"];
				$note = $result["note"];
				$serviceDate = $result["serviceDate"];
				$standard = $result["standard"];
				$adRegistered = $result["adRegistered"];
				$brand = $result["brand"];
				$model = $result["model"];
				$serialNumber = $result["serialNumber"];
				$processor = $result["processor"];
				$ram = $result["ram"];
				$storageSize = $result["storageSize"];
				$operatingSystem = $result["operatingSystem"];
				$hostname = $result["hostname"];
				$inUse = $result["inUse"];
				$sealNumber = $result["sealNumber"];
				$tag = $result["tag"];
				$hwType = $result["hwType"];
				$macAddress = $result["macAddress"];
				$ipAddress = $result["ipAddress"];
				$fwVersion = $result["fwVersion"];
				$fwType = $result["fwType"];
				$storageType = $result["storageType"];
				$videoCard = $result["videoCard"];
				$mediaOperationMode = $result["mediaOperationMode"];
				$secureBoot = $result["secureBoot"];
				$virtualizationTechnology = $result["virtualizationTechnology"];
				$tpmVersion = $result["tpmVersion"];

				// if ($adRegistered == 0) {
				// 	$adRegistered = $translations["NO"];
				// } 
				// else {
				// 	$adRegistered = $translations["YES"];
				// }
				// if ($standard == 0) {
				// 	$standard = $translations["NO"];
				// } 
				// else {
				// 	$standard = $translations["YES"];
				// }
				// if ($inUse == 0) {
				// 	$inUse = $translations["NO"];
				// } 
				// else {
				// 	$inUse = $translations["YES"];
				// }
				// if ($tag == 0) {
				// 	$tag = $translations["NO"];
				// } 
				// else {
				// 	$tag = $translations["YES"];
				// }
			?>
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<tr>
							<td id="label"><?php echo $translations["DISCARDED_ASSET_QUESTION"] ?></td>
							<td colspan=5><input type=checkbox class=chkBox name=chkBoxDiscard value="1" <?php echo ($result["discarded"] == 1 ? "checked" : ""); ?>></td>
						</tr>
				<?php
					}
				}
				?>
				<tr>
					<td colspan=7 id=spacer><?php echo $translations["ASSET_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["ASSET_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdAsset value="<?php echo $idAsset; ?>">
					<td colspan=5><input type=text name=txtAssetNumber placeholder="Ex.: 123456" maxlength="6" required value="<?php echo $assetNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["BUILDING"] ?><mark id=asterisk>*</mark></td>
					<td colspan=5>
						<select id="formFields" name="txtBuilding" required>
							<?php
							foreach ($buildingArray as $str) {
							?>
								<option value=<?php echo $str ?> <?php if ($building == $str) echo "selected"; ?>><?php echo $str ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["ASSET_ROOM"] ?><mark id=asterisk>*</mark></td>
					<td colspan=5><input id="formFields" type=text name=txtRoom placeholder="Ex.: 4413" maxlength="4" required value="<?php echo $room; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?></td>
					<td colspan=5><input type=text name=txtDeliveredToRegistrationNumber maxlength="8" value="<?php echo $deliveredToRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_DELIVERY_DATE"] ?></td>
					<td colspan=5><input type=date name=txtLastDeliveryDate value="<?php echo $lastDeliveryDate; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_DELIVERY_MADE_BY"] ?></td>
					<td colspan=5><label name=txtLastDeliveryMadeBy style=line-height:40px;color:green;font-size:12pt><?php echo $lastDeliveryMadeBy; ?></label></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["NOTE"] ?></td>
					<td colspan=5><textarea name=txtNote cols=20 rows=2 placeholder="Opcional: Campo dedicado para observações e notas referente ao bem patrimonial"><?php echo $note; ?></textarea></td>
				</tr>
		</table>
		<table>
			<tr>
				<td colspan=5 id=spacer><?php echo $translations["PERFORMED_MAINTENANCES_TITLE"] ?></td>
			<tr id=headerPreviousMaintenance>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_DATE"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_SERVICE"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_BATTERY"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_TICKET"] ?></td>
				<td><?php echo $translations["PERFORMED_MAINTENANCES_USER"] ?></td>
			</tr>
			<?php
				while ($resultFormatAnt = mysqli_fetch_array($queryFormatAnt)) {
			?>
				<tr id=bodyPreviousMaintenance>
					<td>
						<label name=txtPreviousMaintenancesDate>
							<?php $previousMaintenancesDate = $resultFormatAnt["previousServiceDates"];
							$dataFA = substr($previousMaintenancesDate, 0, 10);
							$explodedDateA = explode("-", $dataFA);
							$previousMaintenancesDate = $explodedDateA[2] . "/" . $explodedDateA[1] . "/" . $explodedDateA[0];
							echo $previousMaintenancesDate;
							?></label>
					</td>
					<td>
						<label name=txtPreviousMaintenancesServiceType>
							<?php $previousMaintenancesServiceType = $resultFormatAnt["serviceType"];
							if ($previousMaintenancesServiceType != "")
								echo $previousMaintenancesServiceType;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<label name=txtPreviousMaintenancesBattery>
							<?php $previousMaintenancesBattery = $resultFormatAnt["batteryChange"];
							if ($previousMaintenancesBattery != "")
								echo $previousMaintenancesBattery;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<label type=text name=txtPreviousMaintenancesTicket>
							<?php $previousMaintenancesTicket = $resultFormatAnt["ticketNumber"];
							if ($previousMaintenancesTicket != "")
								echo $previousMaintenancesTicket;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<label type=text name=txtPreviousMaintenancesAgent>
							<?php $previousMaintenancesAgent = $resultFormatAnt["agent"];
							if ($previousMaintenancesAgent != "")
								echo $previousMaintenancesAgent;
							else
								echo "-";
							?>
						</label>
					</td>
				</tr>
			<?php
				}
			?>
			</tr>
		</table>
		<table id="formFields">
			<tr>
				<td colspan="2" id=spacer><?php echo $translations["COMPUTER_DATA"] ?></td>
			</tr>
			<tr>
				<td><input type=hidden name=txtServiceDate value="<?php echo $serviceDate; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["STANDARD"] ?></td>
				<td colspan=5>
					<select name="txtStandard">
						<option value="Aluno" <?php if ($standard == "Aluno") echo "selected"; ?>>Aluno</option>
						<option value="Funcionário" <?php if ($standard == "Funcionário") echo "selected"; ?>>Funcionário</option>
					</select>
				</td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["AD_REGISTERED"] ?></td>
				<td>
					<select name="txtAdRegistered">
						<option value=1 <?php if ($adRegistered == "1") echo "selected"; ?>><?php echo $translations["YES"]?></option>
						<option value=0 <?php if ($adRegistered == "0") echo "selected"; ?>><?php echo $translations["NO"]?></option>
					</select>
			</tr>
			<tr>
				<td id=label><?php echo $translations["BRAND"] ?></td>
				<td><input type=text name=txtBrand value="<?php echo $brand; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["MODEL"] ?></td>
				<td><input type=text name=txtModel value="<?php echo $model; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["SERIAL_NUMBER"] ?></td>
				<td><input type=text name=txtSerialNumber value="<?php echo $serialNumber; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["PROCESSOR"] ?></td>
				<td><input type=text name=txtProcessor value="<?php echo $processor; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["RAM"] ?></td>
				<td><input type=text name=txtRam value="<?php echo $ram; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["STORAGE_SIZE"] ?></td>
				<td><input type=text name=txtStorageSize value="<?php echo $storageSize; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["STORAGE_TYPE"] ?></td>
				<td><input type=text name=txtStorageType value="<?php echo $storageType; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["MEDIA_OPERATION_MODE"] ?></td>
				<td><input type=text name=txtMediaOperationMode value="<?php echo $mediaOperationMode; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["VIDEO_CARD"] ?></td>
				<td><input type=text name=txtVideoCard value="<?php echo $videoCard; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["OPERATING_SYSTEM"] ?></td>
				<td><input type=text name=txtOperatingSystem value="<?php echo $operatingSystem; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["HOSTNAME"] ?></td>
				<td><input type=text name=txtHostname value="<?php echo $hostname; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_TYPE"] ?></td>
				<td><input type=text name=txtFwType value="<?php echo $fwType; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_VERSION"] ?></td>
				<td><input type=text name=txtFwVersion value="<?php echo $fwVersion; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["SECURE_BOOT"] ?></td>
				<td><input type=text name=txtSecureBoot value="<?php echo $secureBoot; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"] ?></td>
				<td><input type=text name=txtVirtualizationTechnology value="<?php echo $virtualizationTechnology; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["TPM_VERSION"] ?></td>
				<td><input type=text name=txtTpmVersion value="<?php echo $tpmVersion; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["MAC_ADDRESS"] ?></td>
				<td><input type="text" name="txtMacAddress" value="<?php echo $macAddress; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["IP_ADDRESS"] ?></td>
				<td><input type="text" name="txtIpAddress" value="<?php echo $ipAddress; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["IN_USE"] ?></td>
				<td>
					<select name="txtInUse">
						<option value=1 <?php if ($inUse =="1") echo "selected"; ?>><?php echo $translations["YES"]?></option>
						<option value=0 <?php if ($inUse =="0") echo "selected"; ?>><?php echo $translations["NO"]?></option>
					</select>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["SEAL_NUMBER"] ?></td>
				<td><input type="text" name="txtSealNumber" value="<?php echo $sealNumber; ?>"></td>
			</tr>
			<td id="label"><?php echo $translations["TAG"] ?></td>
			<td><select name="txtTag">
					<option value=1 <?php if ($tag =="1") echo "selected"; ?>><?php echo $translations["YES"]?></option>
					<option value=0 <?php if ($tag =="0") echo "selected"; ?>><?php echo $translations["NO"]?></option>
				</select>
			</td>
			<tr>
				<td id="label"><?php echo $translations["HW_TYPE"] ?></td>
				<td>
					<select name="txtHwType">
						<?php
						foreach ($hwTypesArray as $str) {
						?>
							<option value=<?php echo $str ?> <?php if ($hwType == $str) echo "selected"; ?>><?php echo $str ?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			</tr>
			<?php
			}
			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"] or $_SESSION["privilegeLevel"] == $privilegeLevelsArray["STANDARD_LEVEL"]) {
			?>
				<tr>
					<td colspan=7 align=center><br><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
				</tr>
		<?php
				}
			}
		?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>