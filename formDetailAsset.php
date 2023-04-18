<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$idAsset = null;
$assetFK = null;
$oldAssetNumber = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

$queryUsers = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . "") or die($translations["ERROR_QUERY_USER"] . mysqli_error($connection));

if ($send != 1) {
	if (isset($_GET["id"]))
		$idAsset = $_GET["id"];

	if (isset($_GET["assetNumberFK"]))
		$assetFK = $_GET["assetNumberFK"];

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
	$queryFormatAnt = mysqli_query($connection, "select " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["AGENT"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

} else {
	$idAsset = $_POST["txtIdAsset"];
	$assetNumber = $_POST["txtAssetNumber"];
	$oldAssetNumber = $_POST["txtOldAssetNumber"];
	if (isset($_POST["chkBoxDiscard"])) {
		$discarded = $_POST["chkBoxDiscard"];
	} else {
		$discarded = "0";
	}
	$building = $_POST["txtBuilding"];
	$roomNumber = $_POST["txtRoomNumber"];
	$deliveredToRegistrationNumber = $_POST["txtDeliveredToRegistrationNumber"];
	if (isset($_POST["txtLastDeliveryMadeBy"]))
		$lastDeliveryMadeBy = $_POST["txtLastDeliveryMadeBy"];
	$lastDeliveryDate = $_POST["txtLastDeliveryDate"];
	$standard = $_POST["txtStandard"];
	$note = $_POST["txtNote"];
	$serviceDate = $_POST["txtServiceDate"];
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

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		
		$q = mysqli_prepare($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["ASSET_NUMBER"] . " = ?, " . $dbAssetArray["DISCARDED"] . " = ?, " . $dbAssetArray["BUILDING"] . " = ?, " . $dbAssetArray["ROOM_NUMBER"] . " = ?, " . $dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = ?, " . $dbAssetArray["LAST_DELIVERY_DATE"] . " = ?, " . $dbAssetArray["STANDARD"] . " = ?, " . $dbAssetArray["NOTE"] . " = ?, " . $dbAssetArray["SERVICE_DATE"] . " = ?, " . $dbAssetArray["AD_REGISTERED"] . " = ?, " . $dbAssetArray["BRAND"] . " = ?, " . $dbAssetArray["MODEL"] . " = ?, " . $dbAssetArray["SERIAL_NUMBER"] . " = ?, " . $dbAssetArray["PROCESSOR"] . " = ?, " . $dbAssetArray["RAM"] . " = ?, " . $dbAssetArray["STORAGE_SIZE"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM"] . " = ?, " . $dbAssetArray["HOSTNAME"] . " = ?, " . $dbAssetArray["FW_VERSION"] . " = ?, " . $dbAssetArray["IN_USE"] . " = ?, " . $dbAssetArray["SEAL_NUMBER"] . " = ?, " . $dbAssetArray["TAG"] . " = ?, " . $dbAssetArray["HW_TYPE"] . " = ?, " . $dbAssetArray["FW_TYPE"] . " = ?, " . $dbAssetArray["STORAGE_TYPE"] . " = ?, " . $dbAssetArray["MAC_ADDRESS"] . " = ?, " . $dbAssetArray["IP_ADDRESS"] . " = ?, " . $dbAssetArray["VIDEO_CARD"] . " = ?, " . $dbAssetArray["MEDIA_OPERATION_MODE"] . " = ?, " . $dbAssetArray["SECURE_BOOT"] . " = ?, " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . " = ?, " . $dbAssetArray["TPM_VERSION"] . " = ? where id = ?");

		mysqli_stmt_bind_param($q, "iisssssssisssssssssisissssssssssi", $assetNumber, $discarded, $building, $roomNumber, $deliveredToRegistrationNumber, $lastDeliveryDate, $standard, $note, $serviceDate, $adRegistered, $brand, $model, $serialNumber, $processor, $ram, $storageSize, $operatingSystem, $hostname, $fwVersion, $inUse, $sealNumber, $tag, $hwType, $fwType, $storageType, $macAddress, $ipAddress, $videoCard, $mediaOperationMode, $secureBoot, $virtualizationTechnology, $tpmVersion, $idAsset);

		mysqli_stmt_execute($q);

		mysqli_query($connection, "update " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " set " . $dbMaintenancesArray["ASSET_NUMBER_FK"] . " = '$assetNumber' where " . $dbMaintenancesArray["ASSET_NUMBER_FK"] . " = '$oldAssetNumber'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));

	} else if ($num_rows == 1 && $assetNumber == $oldAssetNumber) {
		
		$q = mysqli_prepare($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["DISCARDED"] . " = ?, " . $dbAssetArray["BUILDING"] . " = ?, " . $dbAssetArray["ROOM_NUMBER"] . " = ?, " . $dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = ?, " . $dbAssetArray["LAST_DELIVERY_DATE"] . " = ?, " . $dbAssetArray["STANDARD"] . " = ?, " . $dbAssetArray["NOTE"] . " = ?, " . $dbAssetArray["SERVICE_DATE"] . " = ?, " . $dbAssetArray["AD_REGISTERED"] . " = ?, " . $dbAssetArray["BRAND"] . " = ?, " . $dbAssetArray["MODEL"] . " = ?, " . $dbAssetArray["SERIAL_NUMBER"] . " = ?, " . $dbAssetArray["PROCESSOR"] . " = ?, " . $dbAssetArray["RAM"] . " = ?, " . $dbAssetArray["STORAGE_SIZE"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM"] . " = ?, " . $dbAssetArray["HOSTNAME"] . " = ?, " . $dbAssetArray["FW_VERSION"] . " = ?, " . $dbAssetArray["IN_USE"] . " = ?, " . $dbAssetArray["SEAL_NUMBER"] . " = ?, " . $dbAssetArray["TAG"] . " = ?, " . $dbAssetArray["HW_TYPE"] . " = ?, " . $dbAssetArray["FW_TYPE"] . " = ?, " . $dbAssetArray["STORAGE_TYPE"] . " = ?, " . $dbAssetArray["MAC_ADDRESS"] . " = ?, " . $dbAssetArray["IP_ADDRESS"] . " = ?, " . $dbAssetArray["VIDEO_CARD"] . " = ?, " . $dbAssetArray["MEDIA_OPERATION_MODE"] . " = ?, " . $dbAssetArray["SECURE_BOOT"] . " = ?, " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . " = ?, " . $dbAssetArray["TPM_VERSION"] . " = ? where id = ?") or die($translations["ERROR_UPDATE_ASSET_DATA"] . mysqli_error($connection));

		mysqli_stmt_bind_param($q, "isssssssisssssssssisissssssssssi", $discarded, $building, $roomNumber, $deliveredToRegistrationNumber, $lastDeliveryDate, $standard, $note, $serviceDate, $adRegistered, $brand, $model, $serialNumber, $processor, $ram, $storageSize, $operatingSystem, $hostname, $fwVersion, $inUse, $sealNumber, $tag, $hwType, $fwType, $storageType, $macAddress, $ipAddress, $videoCard, $mediaOperationMode, $secureBoot, $virtualizationTechnology, $tpmVersion, $idAsset);

		mysqli_stmt_execute($q);
	}
	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryFormatAnt = mysqli_query($connection, "select " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["BATTEY_CHANGE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["AGENT"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["ASSET_NUMBER_FK"] . "") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
}
?>
<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }} ?>>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<form action="formDetailAsset.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["ASSET_DETAIL"] ?></h2><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $assetNumber != $oldAssetNumber) {
				echo "<font color=red>" . $translations["ASSET_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=blue>" . $translations["SUCCESS_UPDATE_ASSET_DATA"] . "</font><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idAsset = $result["id"];
				$assetNumber = $result["assetNumber"];
				$oldAssetNumber = $result["assetNumber"];
				$discarded = $result["discarded"];
				$building = $result["building"];
				$roomNumber = $result["roomNumber"];
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
			?>
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<tr>
							<td id="label">
								<?php echo $translations["DISCARDED_ASSET_QUESTION"] ?>
							</td>
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
					<td id="label">
						<?php echo $translations["ASSET_NUMBER"] ?><mark id=asterisk>*</mark>
					</td>
					<input type=hidden name=txtIdAsset value="<?php echo $idAsset; ?>">
					<input type=hidden name=txtOldAssetNumber value="<?php echo $oldAssetNumber; ?>">
					<td colspan=5><input type=text name=txtAssetNumber placeholder="Ex.: 123456" maxlength="6" required value="<?php echo $assetNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label">
						<?php echo $translations["BUILDING"] ?><mark id=asterisk>*</mark>
					</td>
					<td colspan=5>
						<select id="formFields" name="txtBuilding" required>
							<?php
							foreach ($buildingArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($building == $str1)
																		echo "selected"; ?>><?php echo $str2 ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label">
						<?php echo $translations["ASSET_ROOM"] ?><mark id=asterisk>*</mark>
					</td>
					<td colspan=5><input id="formFields" type=text name=txtRoomNumber placeholder="Ex.: 4413" maxlength="5" required value="<?php echo $roomNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label">
						<?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?>
					</td>
					<td colspan=5><input type=text name=txtDeliveredToRegistrationNumber maxlength="8" value="<?php echo $deliveredToRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id="label">
						<?php echo $translations["LAST_DELIVERY_DATE"] ?>
					</td>
					<td colspan=5><input type=date name=txtLastDeliveryDate value="<?php echo $lastDeliveryDate; ?>"></td>
				</tr>
				<tr>
					<td id="label">
						<?php echo $translations["LAST_DELIVERY_MADE_BY"] ?>
					</td>
					<td colspan=5><label name=txtLastDeliveryMadeBy style=line-height:40px;color:green;font-size:12pt><?php echo $lastDeliveryMadeBy; ?></label></td>
				</tr>
				<tr>
					<td id="label">
						<?php echo $translations["NOTE"] ?>
					</td>
					<td colspan=5><textarea name=txtNote cols=20 rows=2 placeholder="Opcional: Campo dedicado para observações e notas referente ao bem patrimonial"><?php echo $note; ?></textarea>
					</td>
				</tr>
		</table>
		<table>
			<tr>
				<td colspan=5 id=spacer><?php echo $translations["PERFORMED_MAINTENANCES_TITLE"] ?></td>
			<tr id=headerPreviousMaintenance>
				<td>
					<?php echo $translations["PERFORMED_MAINTENANCES_DATE"] ?>
				</td>
				<td>
					<?php echo $translations["PERFORMED_MAINTENANCES_SERVICE"] ?>
				</td>
				<td>
					<?php echo $translations["PERFORMED_MAINTENANCES_BATTERY"] ?>
				</td>
				<td>
					<?php echo $translations["PERFORMED_MAINTENANCES_TICKET"] ?>
				</td>
				<td>
					<?php echo $translations["PERFORMED_MAINTENANCES_USER"] ?>
				</td>
			</tr>
			<?php
				while ($resultFormatAnt = mysqli_fetch_array($queryFormatAnt)) {


			?>
				<tr id=bodyPreviousMaintenance>
					<td>
						<label>
							<?php $previousMaintenancesDate = $resultFormatAnt["previousServiceDates"];
							$datePM = substr($previousMaintenancesDate, 0, 10);
							$explodedDateA = explode("-", $datePM);
							$previousMaintenancesDate = $explodedDateA[2] . "/" . $explodedDateA[1] . "/" . $explodedDateA[0];
							echo $previousMaintenancesDate;
							?></label>
					</td>
					<td>
						<label>
							<?php
							foreach ($serviceTypesArray as $str) {
								if ($resultFormatAnt["serviceType"] == $str)
									echo $translations["SERVICE_TYPE"][$str];
							}
							?>
						</label>
					</td>
					<td>
						<label>
							<?php $previousMaintenancesBattery = $resultFormatAnt["batteryChange"];
							if ($previousMaintenancesBattery != "" && $previousMaintenancesBattery == "1") {
								echo $translations["BATTERY_REPLACED"];
							} else if ($previousMaintenancesBattery == "0") {
								echo $translations["BATTERY_NOT_REPLACED"];
							} else {
								echo "-";
							}
							?>
						</label>
					</td>
					<td>
						<label>
							<?php $previousMaintenancesTicket = $resultFormatAnt["ticketNumber"];
							if ($previousMaintenancesTicket != "")
								echo $previousMaintenancesTicket;
							else
								echo "-";
							?>
						</label>
					</td>
					<td>
						<?php
						if (isset($queryUsers))
							mysqli_data_seek($queryUsers, 0);
						while ($resultUsers = mysqli_fetch_array($queryUsers)) {
						?>
							<label>
								<?php
								if ($resultFormatAnt["agent"] == $resultUsers["id"])
									echo $resultUsers["username"];
								?>
							</label>
						<?php
						}
						?>
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
				<td id="label">
					<?php echo $translations["STANDARD"] ?>
				</td>
				<td colspan=5>
					<select name="txtStandard">
						<?php
						foreach ($entityTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($standard == $str1)
																	echo "selected"; ?>><?php echo $translations["ENTITY_TYPES"][$str1] ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["AD_REGISTERED"] ?></td>
				<td>
					<select name="txtAdRegistered">
						<option value=1 <?php if ($adRegistered == "1")
											echo "selected"; ?>><?php echo $translations["YES"] ?>
						</option>
						<option value=0 <?php if ($adRegistered == "0")
											echo "selected"; ?>><?php echo $translations["NO"] ?>
						</option>
					</select>
				</td>
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
				<td>
					<select name="txtMediaOperationMode">
						<?php
						foreach ($mediaOpTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $mediaOperationMode) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
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
				<td><select name="txtFwType">
						<?php
						foreach ($fwTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $fwType) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["FW_VERSION"] ?></td>
				<td><input type=text name=txtFwVersion value="<?php echo $fwVersion; ?>"></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["SECURE_BOOT"]["NAME"] ?></td>
				<td>
					<select name="txtSecureBoot">
						<?php
						foreach ($secureBootArray as $str) {
						?>
							<option value=<?php echo $str ?> <?php if ($str == $secureBoot) echo "selected"; ?>><?php echo $translations["SECURE_BOOT"][$str] ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></td>
				<td>
					<select name="txtVirtualizationTechnology">
						<?php
						foreach ($virtualizationTechnologyArray as $str) {
						?>
							<option value=<?php echo $str ?> <?php if ($str == $virtualizationTechnology) echo "selected"; ?>>
								<?php echo $translations["VIRTUALIZATION_TECHNOLOGY"][$str] ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["TPM_VERSION"] ?></td>
				<td>
					<select name="txtTpmVersion">
						<?php
						foreach ($tpmTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $tpmVersion) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id="label">
					<?php echo $translations["MAC_ADDRESS"] ?>
				</td>
				<td><input type="text" name="txtMacAddress" value="<?php echo $macAddress; ?>"></td>
			</tr>
			<tr>
				<td id="label">
					<?php echo $translations["IP_ADDRESS"] ?>
				</td>
				<td><input type="text" name="txtIpAddress" value="<?php echo $ipAddress ?>" required></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["IN_USE"] ?></td>
				<td>
					<select name="txtInUse">
						<option value=1 <?php if ($inUse == "1") echo "selected"; ?>><?php echo $translations["YES"] ?>
						</option>
						<option value=0 <?php if ($inUse == "0") echo "selected"; ?>><?php echo $translations["NO"] ?>
						</option>
					</select>
			</tr>
			<tr>
				<td id="label">
					<?php echo $translations["SEAL_NUMBER"] ?>
				</td>
				<td><input type="text" name="txtSealNumber" value="<?php echo $sealNumber; ?>"></td>
			</tr>
			<td id="label">
				<?php echo $translations["TAG"] ?>
			</td>
			<td><select name="txtTag">
					<option value=1 <?php if ($tag == "1") echo "selected"; ?>><?php echo $translations["YES"] ?></option>
					<option value=0 <?php if ($tag == "0") echo "selected"; ?>><?php echo $translations["NO"] ?></option>
				</select>
			</td>
			<tr>
				<td id="label">
					<?php echo $translations["HW_TYPE"] ?>
				</td>
				<td>
					<select name="txtHwType">
						<?php
						foreach ($hwTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($hwType == $str1) echo "selected"; ?>><?php echo $str2 ?>
							</option>
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