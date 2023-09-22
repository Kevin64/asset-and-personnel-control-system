<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) && $_SESSION["privilegeLevel"] != $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
	header('HTTP/1.1 403 Forbidden', TRUE, 403);
	die(header('location: /denied.php'));
}

$send = null;
$idAsset = null;
$assetFK = null;
$oldAssetNumber = null;
$printedDelivery = false;
$printedMaintenances = false;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

$queryUsers = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . "") or die($translations["ERROR_QUERY_AGENT"] . mysqli_error($connection));

if ($send != 1) {
	if (isset($_GET["id"]))
		$idAsset = $_GET["id"];

	if (isset($_GET["assetNumberFK"]))
		$assetFK = $_GET["assetNumberFK"];

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
	$queryFormatPrevious = mysqli_query($connection, "select " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["AGENT_ID"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
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
	$ramAmount = $_POST["txtRamAmount"];
	$ramType = $_POST["txtRamType"];
	$ramFrequency = $_POST["txtRamFrequency"];
	$ramOccupiedSlots = $_POST["txtRamOccupiedSlots"];
	$ramTotalSlots = $_POST["txtRamTotalSlots"];
	$storageTotalSize = $_POST["txtStorageTotalSize"];
	$operatingSystemName = $_POST["txtOperatingSystemName"];
	$operatingSystemVersion = $_POST["txtOperatingSystemVersion"];
	$operatingSystemBuild = $_POST["txtOperatingSystemBuild"];
	$operatingSystemArch = $_POST["txtOperatingSystemArch"];
	$hostname = $_POST["txtHostname"];
	$inUse = $_POST["txtInUse"];
	$sealNumber = $_POST["txtSealNumber"];
	$tag = $_POST["txtTag"];
	$hwType = $_POST["txtHwType"];
	$fwType = $_POST["txtFwType"];
	$macAddress = $_POST["txtMacAddress"];
	$ipAddress = $_POST["txtIpAddress"];
	$fwVersion = $_POST["txtFwVersion"];
	$videoCardName = $_POST["txtVideoCardName"];
	$videoCardRam = $_POST["txtVideoCardRam"];
	$mediaOperationMode = $_POST["txtMediaOperationMode"];
	$secureBoot = $_POST["txtSecureBoot"];
	$virtualizationTechnology = $_POST["txtVirtualizationTechnology"];
	$tpmVersion = $_POST["txtTpmVersion"];

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {

		$q = mysqli_prepare($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["ASSET_NUMBER"] . " = ?, " . $dbAssetArray["DISCARDED"] . " = ?, " . $dbAssetArray["BUILDING"] . " = ?, " . $dbAssetArray["ROOM_NUMBER"] . " = ?, " . $dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = ?, " . $dbAssetArray["LAST_DELIVERY_DATE"] . " = ?, " . $dbAssetArray["STANDARD"] . " = ?, " . $dbAssetArray["NOTE"] . " = ?, " . $dbAssetArray["SERVICE_DATE"] . " = ?, " . $dbAssetArray["AD_REGISTERED"] . " = ?, " . $dbAssetArray["BRAND"] . " = ?, " . $dbAssetArray["MODEL"] . " = ?, " . $dbAssetArray["SERIAL_NUMBER"] . " = ?, " . $dbAssetArray["PROCESSOR"] . " = ?, " . $dbAssetArray["RAM_AMOUNT"] . " = ?, " . $dbAssetArray["RAM_TYPE"] . " = ?, " . $dbAssetArray["RAM_FREQUENCY"] . " = ?, " . $dbAssetArray["RAM_OCCUPIED_SLOTS"] . " = ?, " . $dbAssetArray["RAM_TOTAL_SLOTS"] . " = ?, " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_NAME"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_VERSION"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_BUILD"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_ARCH"] . " = ?, " . $dbAssetArray["HOSTNAME"] . " = ?, " . $dbAssetArray["FW_VERSION"] . " = ?, " . $dbAssetArray["IN_USE"] . " = ?, " . $dbAssetArray["SEAL_NUMBER"] . " = ?, " . $dbAssetArray["TAG"] . " = ?, " . $dbAssetArray["HW_TYPE"] . " = ?, " . $dbAssetArray["FW_TYPE"] . " = ?, " . $dbAssetArray["MAC_ADDRESS"] . " = ?, " . $dbAssetArray["IP_ADDRESS"] . " = ?, " . $dbAssetArray["VIDEO_CARD_NAME"] . " = ?, " . $dbAssetArray["MEDIA_OPERATION_MODE"] . " = ?, " . $dbAssetArray["SECURE_BOOT"] . " = ?, " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . " = ?, " . $dbAssetArray["TPM_VERSION"] . " = ? where id = ?");

		mysqli_stmt_bind_param($q, "sssssssssssssssssssssssssssssssssssssssss", $assetNumber, $discarded, $building, $roomNumber, $deliveredToRegistrationNumber, $lastDeliveryDate, $standard, $note, $serviceDate, $adRegistered, $brand, $model, $serialNumber, $processor, $ramAmount, $ramType, $ramFrequency, $ramOccupiedSlots, $ramTotalSlots, $storageTotalSize, $operatingSystemName, $operatingSystemVersion, $operatingSystemBuild, $operatingSystemArch, $hostname, $fwVersion, $inUse, $sealNumber, $tag, $hwType, $fwType, $macAddress, $ipAddress, $videoCardName, $videoCardRam, $mediaOperationMode, $secureBoot, $virtualizationTechnology, $tpmVersion, $idAsset);

		mysqli_stmt_execute($q);

		mysqli_query($connection, "update " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " set " . $dbMaintenancesArray["ASSET_NUMBER_FK"] . " = '$assetNumber' where " . $dbMaintenancesArray["ASSET_NUMBER_FK"] . " = '$oldAssetNumber'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $assetNumber == $oldAssetNumber) {

		$q = mysqli_prepare($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["DISCARDED"] . " = ?, " . $dbAssetArray["BUILDING"] . " = ?, " . $dbAssetArray["ROOM_NUMBER"] . " = ?, " . $dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = ?, " . $dbAssetArray["LAST_DELIVERY_DATE"] . " = ?, " . $dbAssetArray["STANDARD"] . " = ?, " . $dbAssetArray["NOTE"] . " = ?, " . $dbAssetArray["SERVICE_DATE"] . " = ?, " . $dbAssetArray["AD_REGISTERED"] . " = ?, " . $dbAssetArray["BRAND"] . " = ?, " . $dbAssetArray["MODEL"] . " = ?, " . $dbAssetArray["SERIAL_NUMBER"] . " = ?, " . $dbAssetArray["PROCESSOR"] . " = ?, " . $dbAssetArray["RAM_AMOUNT"] . " = ?, " . $dbAssetArray["RAM_TYPE"] . " = ?, " . $dbAssetArray["RAM_FREQUENCY"] . " = ?, " . $dbAssetArray["RAM_OCCUPIED_SLOTS"] . " = ?, " . $dbAssetArray["RAM_TOTAL_SLOTS"] . " = ?, " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_NAME"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_VERSION"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_BUILD"] . " = ?, " . $dbAssetArray["OPERATING_SYSTEM_ARCH"] . " = ?, " . $dbAssetArray["HOSTNAME"] . " = ?, " . $dbAssetArray["FW_VERSION"] . " = ?, " . $dbAssetArray["IN_USE"] . " = ?, " . $dbAssetArray["SEAL_NUMBER"] . " = ?, " . $dbAssetArray["TAG"] . " = ?, " . $dbAssetArray["HW_TYPE"] . " = ?, " . $dbAssetArray["FW_TYPE"] . " = ?, " . $dbAssetArray["MAC_ADDRESS"] . " = ?, " . $dbAssetArray["IP_ADDRESS"] . " = ?, " . $dbAssetArray["VIDEO_CARD_NAME"] . " = ?, " . $dbAssetArray["VIDEO_CARD_RAM"] . " = ?, " . $dbAssetArray["MEDIA_OPERATION_MODE"] . " = ?, " . $dbAssetArray["SECURE_BOOT"] . " = ?, " . $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] . " = ?, " . $dbAssetArray["TPM_VERSION"] . " = ? where id = ?") or die($translations["ERROR_UPDATE_ASSET_DATA"] . mysqli_error($connection));

		mysqli_stmt_bind_param($q, "ssssssssssssssssssssssssssssssssssssssss", $discarded, $building, $roomNumber, $deliveredToRegistrationNumber, $lastDeliveryDate, $standard, $note, $serviceDate, $adRegistered, $brand, $model, $serialNumber, $processor, $ramAmount, $ramType, $ramFrequency, $ramOccupiedSlots, $ramTotalSlots, $storageTotalSize, $operatingSystemName, $operatingSystemVersion, $operatingSystemBuild, $operatingSystemArch, $hostname, $fwVersion, $inUse, $sealNumber, $tag, $hwType, $fwType, $macAddress, $ipAddress, $videoCardName, $videoCardRam, $mediaOperationMode, $secureBoot, $virtualizationTechnology, $tpmVersion, $idAsset);

		mysqli_stmt_execute($q);
	}
	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryFormatPrevious = mysqli_query($connection, "select " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["AGENT_ID"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["ASSET_NUMBER_FK"] . "") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));

	header("Location: formDetailAsset.php?id=$idAsset");
}
?>
<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }
																													} ?>>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<form action="editAsset.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["ASSET_EDIT"] ?></h2><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $assetNumber != $oldAssetNumber) {
				echo "<font color=" . $colorArray["ERROR"] . ">" . $translations["ASSET_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=" . $colorArray["SUCCESS_REGISTER_BACKGROUND"] . ">" . $translations["SUCCESS_UPDATE_ASSET_DATA"] . "</font><br><br>";
			}
		}
		?>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idAsset = $result["id"];
				$assetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
				$oldAssetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
				$discarded = $result[$dbAssetArray["DISCARDED"]];
				$building = $result[$dbAssetArray["BUILDING"]];
				$roomNumber = $result[$dbAssetArray["ROOM_NUMBER"]];
				$deliveredToRegistrationNumber = $result[$dbAssetArray["DELIVERED_TO_REGISTRATION_NUMBER"]];
				$lastDeliveryDate = $result[$dbAssetArray["LAST_DELIVERY_DATE"]];
				$lastDeliveryMadeBy = $result[$dbAssetArray["LAST_DELIVERY_MADE_BY"]];
				$note = $result[$dbAssetArray["NOTE"]];
				$serviceDate = $result[$dbAssetArray["SERVICE_DATE"]];
				$standard = $result[$dbAssetArray["STANDARD"]];
				$adRegistered = $result[$dbAssetArray["AD_REGISTERED"]];
				$brand = $result[$dbAssetArray["BRAND"]];
				$model = $result[$dbAssetArray["MODEL"]];
				$serialNumber = $result[$dbAssetArray["SERIAL_NUMBER"]];
				$processor = $result[$dbAssetArray["PROCESSOR"]];
				$ramAmount = $result[$dbAssetArray["RAM_AMOUNT"]];
				$ramType = $result[$dbAssetArray["RAM_TYPE"]];
				$ramFrequency = $result[$dbAssetArray["RAM_FREQUENCY"]];
				$ramOccupiedSlots = $result[$dbAssetArray["RAM_OCCUPIED_SLOTS"]];
				$ramTotalSlots = $result[$dbAssetArray["RAM_TOTAL_SLOTS"]];
				$storageTotalSize = $result[$dbAssetArray["STORAGE_TOTAL_SIZE"]];
				$operatingSystemName = $result[$dbAssetArray["OPERATING_SYSTEM_NAME"]];
				$operatingSystemVersion = $result[$dbAssetArray["OPERATING_SYSTEM_VERSION"]];
				$operatingSystemBuild = $result[$dbAssetArray["OPERATING_SYSTEM_BUILD"]];
				$operatingSystemArch = $result[$dbAssetArray["OPERATING_SYSTEM_ARCH"]];
				$hostname = $result[$dbAssetArray["HOSTNAME"]];
				$inUse = $result[$dbAssetArray["IN_USE"]];
				$sealNumber = $result[$dbAssetArray["SEAL_NUMBER"]];
				$tag = $result[$dbAssetArray["TAG"]];
				$hwType = $result[$dbAssetArray["HW_TYPE"]];
				$macAddress = $result[$dbAssetArray["MAC_ADDRESS"]];
				$ipAddress = $result[$dbAssetArray["IP_ADDRESS"]];
				$fwVersion = $result[$dbAssetArray["FW_VERSION"]];
				$fwType = $result[$dbAssetArray["FW_TYPE"]];
				$videoCardName = $result[$dbAssetArray["VIDEO_CARD_NAME"]];
				$videoCardRam = $result[$dbAssetArray["VIDEO_CARD_RAM"]];
				$mediaOperationMode = $result[$dbAssetArray["MEDIA_OPERATION_MODE"]];
				$secureBoot = $result[$dbAssetArray["SECURE_BOOT"]];
				$virtualizationTechnology = $result[$dbAssetArray["VIRTUALIZATION_TECHNOLOGY"]];
				$tpmVersion = $result[$dbAssetArray["TPM_VERSION"]];
			?>

				<tr>
					<td colspan=7 id=section-header><?php echo $translations["ASSET_DATA"] ?></td>
				</tr>
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<tr>
							<td id=lblFixed><?php echo $translations["DISCARDED_ASSET_QUESTION"] ?></td>

							<td colspan=5><input type=checkbox class=chkBox name=chkBoxDiscard value="1" <?php echo ($result[$dbAssetArray["DISCARDED"]] == 1 ? "checked" : ""); ?>></td>
						</tr>
				<?php
					}
				}
				?>
				<tr>
					<td id=lblFixed><?php echo $translations["ASSET_NUMBER"] ?></td>
					<input type=hidden name=txtIdAsset value="<?php echo $idAsset; ?>">
					<input type=hidden name=txtOldAssetNumber value="<?php echo $oldAssetNumber; ?>">
					<td colspan=5><input type=text name=txtAssetNumber placeholder="<?php echo $translations["PLACEHOLDER_ASSET_NUMBER"] ?>" maxlength="6" required value="<?php echo $assetNumber; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SEAL_NUMBER"] ?></td>
					<td><input type="text" name="txtSealNumber" value="<?php echo $sealNumber; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["BUILDING"] ?></td>
					<td colspan=5>
						<select id="formFields" name="txtBuilding" required <?php if ($building == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
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
					<td id=lblFixed><?php echo $translations["ASSET_ROOM"] ?></td>
					<td colspan=5><input id="formFields" type=text name=txtRoomNumber placeholder="<?php echo $translations["PLACEHOLDER_ASSET_ROOM_NUMBER"] ?>" maxlength="5" required value="<?php echo $roomNumber; ?>" <?php if ($roomNumber == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["IN_USE"] ?></td>
					<td>
						<select name="txtInUse" <?php if ($inUse == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value=1 <?php if ($inUse == "1") echo "selected"; ?>><?php echo $translations["YES"] ?>
							</option>
							<option value=0 <?php if ($inUse == "0") echo "selected"; ?>><?php echo $translations["NO"] ?>
							</option>
						</select>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["HW_TYPE"] ?></td>
					<td>
						<select name="txtHwType" <?php if ($hwType == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<?php
							foreach ($hwTypesArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($hwType == $str1 && $hwType != null) echo "selected"; ?>><?php echo $str2 ?>
								</option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["TAG"] ?></td>
					<td>
						<select name="txtTag" <?php if ($tag == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value=1 <?php if ($tag == "1") echo "selected"; ?>><?php echo $translations["YES"] ?></option>
							<option value=0 <?php if ($tag == "0") echo "selected"; ?>><?php echo $translations["NO"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["AD_REGISTERED"] ?></td>
					<td>
						<select name="txtAdRegistered" <?php if ($adRegistered == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
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
					<td id=lblFixed><?php echo $translations["STANDARD"] ?></td>
					<td colspan=5>
						<select name="txtStandard" <?php if ($standard == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<?php
							foreach ($entityTypesArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($standard == $str1 && $standard != null)
																		echo "selected"; ?>><?php echo $translations["ENTITY_TYPES"][$str1] ?>
								</option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?></td>
					<td colspan=5><input type=text name=txtDeliveredToRegistrationNumber maxlength="8" value="<?php echo $deliveredToRegistrationNumber; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["LAST_DELIVERY_DATE"] ?></td>
					<td colspan=5><input type=date name=txtLastDeliveryDate value="<?php echo $lastDeliveryDate; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["LAST_DELIVERY_MADE_BY"] ?></td>
					<td colspan=5><label name=txtLastDeliveryMadeBy style=line-height:40px;font-size:12pt></label>
						<?php
						if (isset($queryUsers))
							mysqli_data_seek($queryUsers, 0);
						while ($resultUsers = mysqli_fetch_array($queryUsers)) {
							if ($lastDeliveryMadeBy == $resultUsers["id"]) {
						?>
								<label>
									<?php
									echo $resultUsers[$dbAgentArray["USERNAME"]];
									$printedDelivery = true;
									?>
								</label>
						<?php
							}
						}
						?>
						<label>
							<?php
							if ($printedDelivery != true)
								echo $json_constants_array["DASH"];
							?>
						</label>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["NOTE"] ?></td>
					<td colspan=5><textarea name=txtNote cols=20 rows=2 placeholder="<?php echo $translations["PLACEHOLDER_ASSET_NOTE"] ?>"><?php echo $note; ?></textarea>
					</td>
				</tr>
		</table>
		<table id="formFields">
			<tr>
				<td colspan="3" id=section-header><?php echo $translations["COMPUTER_DATA"] ?></td>
			</tr>
			<tr>
				<td><input type=hidden name=txtServiceDate value="<?php echo $serviceDate; ?>"></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["BRAND"] ?></td>
				<td><input type=text name=txtBrand value="<?php echo $brand; ?>" <?php if ($brand == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["MODEL"] ?></td>
				<td><input type=text name=txtModel value="<?php echo $model; ?>" <?php if ($model == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["SERIAL_NUMBER"] ?></td>
				<td><input type=text name=txtSerialNumber value="<?php echo $serialNumber; ?>" <?php if ($serialNumber == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["PROCESSOR"] ?></td>
				<td><input type=text name=txtProcessor value="<?php echo $processor; ?>" <?php if ($processor == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_AMOUNT"] . " (MB)" ?></td>
				<td><input type=number name=txtRamAmount value="<?php echo $ramAmount; ?>" <?php if ($ramAmount == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_TYPE"] ?></td>
				<td>
					<select name="txtRamType" <?php if ($ramType == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($ramTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $ramType && $ramType != null) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_FREQUENCY"] . " (MHz)" ?></td>
				<td><input type=number name=txtRamFrequency value="<?php echo $ramFrequency; ?>" <?php if ($ramFrequency == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_OCCUPIED_SLOTS"] ?></td>
				<td><input type=number name=txtRamOccupiedSlots value="<?php echo $ramOccupiedSlots; ?>" <?php if ($ramOccupiedSlots == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_TOTAL_SLOTS"] ?></td>
				<td><input type=number name=txtRamTotalSlots value="<?php echo $ramTotalSlots; ?>" <?php if ($ramTotalSlots == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["STORAGE_TOTAL_SIZE"] . " (MB)" ?></td>
				<td><input type=number name=txtStorageTotalSize value="<?php echo $storageTotalSize; ?>" <?php if ($storageTotalSize == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			
			<tr>
				<td id=lblFixed><?php echo $translations["MEDIA_OPERATION_MODE"] ?></td>
				<td>
					<select name="txtMediaOperationMode" <?php if ($mediaOperationMode == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($mediaOpTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $mediaOperationMode && $mediaOperationMode != null) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIDEO_CARD_NAME"] ?></td>
				<td><input type=text name=txtVideoCardName value="<?php echo $videoCardName; ?>" <?php if ($videoCardName == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIDEO_CARD_RAM"] . " (MB)" ?></td>
				<td><input type=number name=txtVideoCardRam value="<?php echo $videoCardRam; ?>" <?php if ($videoCardRam == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_NAME"] ?></td>
				<td><input type=text name=txtOperatingSystemName value="<?php echo $operatingSystemName; ?>" <?php if ($operatingSystemName == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_VERSION"] ?></td>
				<td><input type=text name=txtOperatingSystemVersion value="<?php echo $operatingSystemVersion; ?>" <?php if ($operatingSystemVersion == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_BUILD"] ?></td>
				<td><input type=text name=txtOperatingSystemBuild value="<?php echo $operatingSystemBuild; ?>" <?php if ($operatingSystemBuild == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_ARCH"] ?></td>
				<td><select name="txtOperatingSystemArch" <?php if ($operatingSystemArch == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($operatingSystemArchArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $operatingSystemArch && $operatingSystemArch != null) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["HOSTNAME"] ?></td>
				<td><input type=text name=txtHostname value="<?php echo $hostname; ?>" <?php if ($hostname == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["MAC_ADDRESS"] ?></td>
				<td><input type="text" name="txtMacAddress" value="<?php echo $macAddress; ?>" <?php if ($macAddress == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["IP_ADDRESS"] ?></td>
				<td><input type="text" name="txtIpAddress" value="<?php echo $ipAddress ?>" required <?php if ($ipAddress == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["FW_TYPE"] ?></td>
				<td><select name="txtFwType" <?php if ($fwType == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($fwTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $fwType && $fwType != null) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["FW_VERSION"] ?></td>
				<td><input type=text name=txtFwVersion value="<?php echo $fwVersion; ?>" <?php if ($fwVersion == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["SECURE_BOOT"]["NAME"] ?></td>
				<td>
					<select name="txtSecureBoot" <?php if ($secureBoot == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($secureBootArray as $str) {
						?>
							<option value=<?php echo $str ?> <?php if ($str == $secureBoot && $secureBoot != null) echo "selected"; ?>><?php echo $translations["SECURE_BOOT"][$str] ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></td>
				<td>
					<select name="txtVirtualizationTechnology" <?php if ($virtualizationTechnology == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($virtualizationTechnologyArray as $str) {
						?>
							<option value=<?php echo $str ?> <?php if ($str == $virtualizationTechnology && $virtualizationTechnology != null) echo "selected"; ?>>
								<?php echo $translations["VIRTUALIZATION_TECHNOLOGY"][$str] ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["TPM_VERSION"] ?></td>
				<td>
					<select name="txtTpmVersion" <?php if ($tpmVersion == "") { ?> style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>" <?php } ?>>
						<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
						<?php
						foreach ($tpmTypesArray as $str1 => $str2) {
						?>
							<option value=<?php echo $str1 ?> <?php if ($str1 == $tpmVersion && $tpmVersion != null) echo "selected"; ?>><?php echo $str2 ?>
							</option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
		<?php
			}
		?>
		<tr>
			<td id=h-separator colspan=7 align=center><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
		</tr>
		<?php
		?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>