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
	$assetNumber = $_POST["txtAsset"];
	if (isset($_POST["chkBoxDiscard"])) {
		$discarded = $_POST["chkBoxDiscard"];
	} else {
		$discarded = "0";
	}
	$building = $_POST["txtBuilding"];
	$room = $_POST["txtRoom"];
	$deliveredToRegistrationNumber = $_POST["txtRegNumReceiver"];
	if (isset($_POST["txtDeliveryman"]))
		$lastDeliveryMadeBy = $_POST["txtDeliveryman"];
	$lastDeliveryDate = $_POST["txtDeliveryDate"];
	$standard = $_POST["txtStandard"];
	$note = $_POST["txtNote"];
	$serviceDate = $_POST["txtLastFormatting"];
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
	$adRegistered = $_POST["txtAd"];
	$brand = $_POST["txtbrand"];
	$model = $_POST["txtmodel"];
	$serialNumber = $_POST["txtserialNumber"];
	$processor = $_POST["txtprocessor"];
	$ram = $_POST["txtram"];
	$storageSize = $_POST["txtHd"];
	$operatingSystem = $_POST["txtoperatingSystem"];
	$hostname = $_POST["txtHostName"];
	$inUse = $_POST["txtinUse"];
	$sealNumber = $_POST["txtsealNumber"];
	$tag = $_POST["txttag"];
	$hwType = $_POST["txttype"];
	$fwType = $_POST["txttypeFW"];
	$macAddress = $_POST["txtMac"];
	$ipAddress = $_POST["txtIp"];
	$model = $_POST["txtmodel"];
	$storageType = $_POST["txttypeStorage"];
	$videoCard = $_POST["txtGPU"];
	$mediaOperationMode = $_POST["txtmediaOperationMode"];
	$secureBoot = $_POST["txtSecBoot"];
	$virtualizationTechnology = $_POST["txtVT"];
	$tpmVersion = $_POST["txtTPM"];

	//currentizando os dados do patrimônio
	mysqli_query($connection, "update asset set asset = '$assetNumber', discard = '$discarded', building = '$building', room = '$room', regNumreceiver = '$deliveredToRegistrationNumber', deliveryDate = '$lastDeliveryDate', standard = '$standard', note = '$note', serviceDate = '$serviceDate', ad = '$adRegistered', brand = '$brand', model = '$model', serialNumber = '$serialNumber', processor = '$processor', ram = '$ram', hd = '$storageSize', operatingSystem = '$operatingSystem', hostname = '$hostname', model = '$model', inUse = '$inUse', sealNumber = '$sealNumber', tag = '$tag', type = '$hwType', typeFW = '$fwType', typeStorage = '$storageType', mac = '$macAddress', ipAddress = '$ipAddress', gpu = '$videoCard', mediaOperationMode = '$mediaOperationMode', secBoot = '$secureBoot', vt = '$virtualizationTechnology', tpm = '$tpmVersion' where id = '$idAsset'") or die($translations["ERROR_UPDATE_ASSET_DATA"] . mysqli_error($connection));

	$query = mysqli_query($connection, "select * from asset where id = '$idAsset'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryFormatAnt = mysqli_query($connection, "select maintenances.previousServiceDates, maintenances.serviceType, maintenances.batteryChange, maintenances.ticketNumber, maintenances.agent from (select * from asset where id = '$idAsset') as p inner join maintenances on a.assetNumber = maintenances.assetNumberFK") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
}
?>
<div id="middle">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<form action="frmDetailAsset.php" method="post" id="formGeneral">
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
				$model = $result["model"];
				$fwType = $result["fwType"];
				$storageType = $result["storageType"];
				$videoCard = $result["videoCard"];
				$mediaOperationMode = $result["mediaOperationMode"];
				$secureBoot = $result["secureBoot"];
				$virtualizationTechnology = $result["virtualizationTechnology"];
				$tpmVersion = $result["tpmVersion"];

				$adOk = substr($adRegistered, 0, 1);
				$standardOk = substr($standard, 0, 1);
				$inUseOk = substr($inUse, 0, 1);
				$tagOk = substr($tag, 0, 1);

				if ($adOk == "N") $adRegistered = "Não";
				if ($standardOk == "N") $standard = "Não";
				if ($inUseOk == "N") $inUse = "Não";
				if ($tagOk == "N") $tag = "Não";
			?>
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"]) {
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
					<td colspan=5><input type=text name=txtAsset placeholder="Ex.: 123456" maxlength="6" required value="<?php echo $assetNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["BUILDING"] ?><mark id=asterisk>*</mark></td>
					<td colspan=5>
						<select id="formFields" name="txtBuilding" required>
							<?php
							foreach ($building_array as $str) {
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
					<td colspan=5><input id="formFields" type=text name=txtroom placeholder="Ex.: 4413" maxlength="4" required value="<?php echo $room; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?></td>
					<td colspan=5><input type=text name=txtRegNumReceiver maxlength="8" value="<?php echo $deliveredToRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_DELIVERY_DATE"] ?></td>
					<td colspan=5><input type=date name=txtDeliveryDate value="<?php echo $lastDeliveryDate; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_DELIVERY_MADE_BY"] ?></td>
					<td colspan=5><label name=txtDeliveryman style=line-height:40px;color:green;font-size:12pt><?php echo $lastDeliveryMadeBy; ?></label></td>
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
				<td><input type=hidden name=txtLastFormatting value="<?php echo $serviceDate; ?>"></td>
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
					<select name="txtAd">
						<option value="Sim" <?php if ($adRegistered === "Sim") echo "selected"; ?>>Sim</option>
						<option value="Não" <?php if ($adRegistered === "Não") echo "selected"; ?>>Não</option>
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
				<td><input type=text name=txtHd value="<?php echo $storageSize; ?>"></td>
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
				<td><input type=text name=txtGPU value="<?php echo $videoCard; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["OPERATING_SYSTEM"] ?></td>
				<td><input type=text name=txtOperatingSystem value="<?php echo $operatingSystem; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["HOSTNAME"] ?></td>
				<td><input type=text name=txtHostName value="<?php echo $hostname; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_TYPE"] ?></td>
				<td><input type=text name=txtTypeFW value="<?php echo $fwType; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_VERSION"] ?></td>
				<td><input type=text name=txtModel value="<?php echo $model; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["SECURE_BOOT"] ?></td>
				<td><input type=text name=txtSecBoot value="<?php echo $secureBoot; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"] ?></td>
				<td><input type=text name=txtVT value="<?php echo $virtualizationTechnology; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["TPM_VERSION"] ?></td>
				<td><input type=text name=txtTPM value="<?php echo $tpmVersion; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["MAC_ADDRESS"] ?></td>
				<td><input type="text" name="txtMac" value="<?php echo $macAddress; ?>"></td>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["IP_ADDRESS"] ?></td>
				<td><input type="text" name="txtIp" value="<?php echo $ipAddress; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["IN_USE"] ?></td>
				<td>
					<select name="txtInUse">
						<option value="Sim" <?php if ($inUse === "Sim") echo "selected"; ?>>Sim</option>
						<option value="Não" <?php if ($inUse === "Não") echo "selected"; ?>>Não</option>
					</select>
			</tr>
			<tr>
				<td id="label"><?php echo $translations["SEAL_NUMBER"] ?></td>
				<td><input type="text" name="txtSealNumber" value="<?php echo $sealNumber; ?>"></td>
			</tr>
			<td id="label"><?php echo $translations["TAG"] ?></td>
			<td><select name="txtTag">
					<option value="Sim" <?php if ($tag === "Sim") echo "selected"; ?>>Sim</option>
					<option value="Não" <?php if ($tag === "Não") echo "selected"; ?>>Não</option>
				</select>
			</td>
			<tr>
				<td id="label"><?php echo $translations["HW_TYPE"] ?></td>
				<td>
					<select name="txttype">
						<?php
						foreach ($hwtype_array as $str) {
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
				if ($_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"] or $_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["STANDARD_LEVEL"]) {
			?>
				<tr>
					<td colspan=7 align=center><br><input id="updateButton" type=submit value=Atualizar></td>
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