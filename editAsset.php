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

	$queryAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetFirmware = mysqli_query($connection, "select " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["TYPE"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["VERSION"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["MEDIA_OPERATION_MODE"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["SECURE_BOOT"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["TPM_VERSION"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbFirmwareArray["FIRMWARE_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbFirmwareArray["FIRMWARE_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetHardware = mysqli_query($connection, "select " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["BRAND"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["MODEL"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["TYPE"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["PROCESSOR"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["SERIAL_NUMBER"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbHardwareArray["HARDWARE_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetRam = mysqli_query($connection, "select " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["AMOUNT"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["FREQUENCY"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["OCCUPIED_SLOTS"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["TOTAL_SLOTS"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["TYPE"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbRamArray["RAM_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbRamArray["RAM_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetStorage = mysqli_query($connection, "select " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["STORAGE_ID"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["TYPE"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["SIZE"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["CONNECTION"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["MODEL"] . "," . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["SERIAL_NUMBER"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["SMART_STATUS"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbStorageArray["STORAGE_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbStorageArray["STORAGE_TABLE"] . ".assetNumberFK order by " . $dbStorageArray["STORAGE_ID"]) or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetVideoCard = mysqli_query($connection, "select " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . "." . $dbVideoCardArray["GPU_ID"] . ", " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . "." . $dbVideoCardArray["NAME"] . ", " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . "." . $dbVideoCardArray["RAM"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . ".assetNumberFK order by " . $dbVideoCardArray["GPU_ID"]) or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetLocation = mysqli_query($connection, "select " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["BUILDING"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["LAST_DELIVERY_DATE"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["LAST_DELIVERY_MADE_BY"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["ROOM_NUMBER"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbLocationArray["LOCATION_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbLocationArray["LOCATION_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetMaintenances = mysqli_query($connection, "select " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["SERVICE_DATE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["SERVICE_TYPE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["BATTERY_CHANGE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["TICKET_NUMBER"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["AGENT_ID"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetNetwork = mysqli_query($connection, "select " . $dbNetworkArray["NETWORK_TABLE"] . "." . $dbNetworkArray["MAC_ADDRESS"] . ", " . $dbNetworkArray["NETWORK_TABLE"] . "." . $dbNetworkArray["IP_ADDRESS"] . ", " . $dbNetworkArray["NETWORK_TABLE"] . "." . $dbNetworkArray["HOSTNAME"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbNetworkArray["NETWORK_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbNetworkArray["NETWORK_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetOperatingSystem = mysqli_query($connection, "select " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["ARCH"] . ", " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["BUILD"] . ", " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["NAME"] . ", " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["VERSION"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
} else {
	$idAsset = $_POST["txtIdAsset"];
	$assetNumber = $_POST["txtAssetNumber"];
	$oldAssetNumber = $_POST["txtOldAssetNumber"];
	if (isset($_POST["chkBoxDiscard"])) {
		$discarded = $_POST["chkBoxDiscard"];
	} else {
		$discarded = "0";
	}
	$standard = $_POST["txtStandard"];
	$note = $_POST["txtNote"];
	$serviceDate = $_POST["txtServiceDate"];
	$adRegistered = $_POST["txtAdRegistered"];
	$inUse = $_POST["txtInUse"];
	$sealNumber = $_POST["txtSealNumber"];
	$tag = $_POST["txtTag"];

	$fwVersion = $_POST["txtFwVersion"];
	$fwType = $_POST["txtFwType"];
	$mediaOperationMode = $_POST["txtMediaOperationMode"];
	$secureBoot = $_POST["txtSecureBoot"];
	$virtualizationTechnology = $_POST["txtVirtualizationTechnology"];
	$tpmVersion = $_POST["txtTpmVersion"];

	$hwType = $_POST["txtHwType"];
	$brand = $_POST["txtBrand"];
	$model = $_POST["txtModel"];
	$serialNumber = $_POST["txtSerialNumber"];
	$processor = $_POST["txtProcessor"];

	$ramAmount = $_POST["txtRamAmount"];
	$ramType = $_POST["txtRamType"];
	$ramFrequency = $_POST["txtRamFrequency"];
	$ramOccupiedSlots = $_POST["txtRamOccupiedSlots"];
	$ramTotalSlots = $_POST["txtRamTotalSlots"];

	$gpuId = $_POST["txtGpuId"];
	$videoCardName = $_POST["txtVideoCardName"];
	$videoCardRam = $_POST["txtVideoCardRam"];

	$building = $_POST["txtBuilding"];
	$roomNumber = $_POST["txtRoomNumber"];
	$deliveredToRegistrationNumber = $_POST["txtDeliveredToRegistrationNumber"];
	if (isset($_POST["txtLastDeliveryMadeBy"]))
		$lastDeliveryMadeBy = $_POST["txtLastDeliveryMadeBy"];
	$lastDeliveryDate = $_POST["txtLastDeliveryDate"];

	$operatingSystemName = $_POST["txtOperatingSystemName"];
	$operatingSystemVersion = $_POST["txtOperatingSystemVersion"];
	$operatingSystemBuild = $_POST["txtOperatingSystemBuild"];
	$operatingSystemArch = $_POST["txtOperatingSystemArch"];

	$hostname = $_POST["txtHostname"];
	$macAddress = $_POST["txtMacAddress"];
	$ipAddress = $_POST["txtIpAddress"];

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {

		$q = mysqli_prepare($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["ASSET_NUMBER"] . " = ?, " . $dbAssetArray["DISCARDED"] . " = ?, " . $dbLocationArray["BUILDING"] . " = ?, " . $dbLocationArray["ROOM_NUMBER"] . " = ?, " . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = ?, " . $dbLocationArray["LAST_DELIVERY_DATE"] . " = ?, " . $dbAssetArray["STANDARD"] . " = ?, " . $dbAssetArray["NOTE"] . " = ?, " . $dbAssetArray["SERVICE_DATE"] . " = ?, " . $dbAssetArray["AD_REGISTERED"] . " = ?, " . $dbHardwareArray["BRAND"] . " = ?, " . $dbHardwareArray["MODEL"] . " = ?, " . $dbHardwareArray["SERIAL_NUMBER"] . " = ?, " . $dbHardwareArray["PROCESSOR"] . " = ?, " . $dbRamArray["AMOUNT"] . " = ?, " . $dbRamArray["TYPE"] . " = ?, " . $dbRamArray["FREQUENCY"] . " = ?, " . $dbRamArray["OCCUPIED_SLOTS"] . " = ?, " . $dbRamArray["TOTAL_SLOTS"] . " = ?, " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . " = ?, " . $dbOperatingSystemArray["NAME"] . " = ?, " . $dbOperatingSystemArray["VERSION"] . " = ?, " . $dbOperatingSystemArray["BUILD"] . " = ?, " . $dbOperatingSystemArray["ARCH"] . " = ?, " . $dbAssetArray["HOSTNAME"] . " = ?, " . $dbFirmwareArray["FW_VERSION"] . " = ?, " . $dbAssetArray["IN_USE"] . " = ?, " . $dbAssetArray["SEAL_NUMBER"] . " = ?, " . $dbAssetArray["TAG"] . " = ?, " . $dbAssetArray["HW_TYPE"] . " = ?, " . $dbFirmwareArray["FW_TYPE"] . " = ?, " . $dbAssetArray["MAC_ADDRESS"] . " = ?, " . $dbAssetArray["IP_ADDRESS"] . " = ?, " . $dbVideoCardArray["NAME"] . " = ?, " . $dbFirmwareArray["MEDIA_OPERATION_MODE"] . " = ?, " . $dbFirmwareArray["SECURE_BOOT"] . " = ?, " . $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] . " = ?, " . $dbFirmwareArray["TPM_VERSION"] . " = ? where id = ?");

		mysqli_stmt_bind_param($q, "sssssssssssssssssssssssssssssssssssssssss", $assetNumber, $discarded, $building, $roomNumber, $deliveredToRegistrationNumber, $lastDeliveryDate, $standard, $note, $serviceDate, $adRegistered, $brand, $model, $serialNumber, $processor, $ramAmount, $ramType, $ramFrequency, $ramOccupiedSlots, $ramTotalSlots, $storageTotalSize, $operatingSystemName, $operatingSystemVersion, $operatingSystemBuild, $operatingSystemArch, $hostname, $fwVersion, $inUse, $sealNumber, $tag, $hwType, $fwType, $macAddress, $ipAddress, $videoCardName, $videoCardRam, $mediaOperationMode, $secureBoot, $virtualizationTechnology, $tpmVersion, $idAsset);

		mysqli_stmt_execute($q);

		mysqli_query($connection, "update " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " set " . $dbMaintenanceArray["ASSET_NUMBER_FK"] . " = '$assetNumber' where " . $dbMaintenanceArray["ASSET_NUMBER_FK"] . " = '$oldAssetNumber'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $assetNumber == $oldAssetNumber) {

		$q = mysqli_prepare($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " . $dbAssetArray["DISCARDED"] . " = ?, " . $dbLocationArray["BUILDING"] . " = ?, " . $dbLocationArray["ROOM_NUMBER"] . " = ?, " . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . " = ?, " . $dbLocationArray["LAST_DELIVERY_DATE"] . " = ?, " . $dbAssetArray["STANDARD"] . " = ?, " . $dbAssetArray["NOTE"] . " = ?, " . $dbAssetArray["SERVICE_DATE"] . " = ?, " . $dbAssetArray["AD_REGISTERED"] . " = ?, " . $dbAssetArray["BRAND"] . " = ?, " . $dbAssetArray["MODEL"] . " = ?, " . $dbAssetArray["SERIAL_NUMBER"] . " = ?, " . $dbAssetArray["PROCESSOR"] . " = ?, " . $dbRamArray["AMOUNT"] . " = ?, " . $dbRamArray["TYPE"] . " = ?, " . $dbRamArray["FREQUENCY"] . " = ?, " . $dbRamArray["OCCUPIED_SLOTS"] . " = ?, " . $dbRamArray["TOTAL_SLOTS"] . " = ?, " . $dbAssetArray["STORAGE_TOTAL_SIZE"] . " = ?, " . $dbOperatingSystemArray["NAME"] . " = ?, " . $dbOperatingSystemArray["VERSION"] . " = ?, " . $dbOperatingSystemArray["BUILD"] . " = ?, " . $dbOperatingSystemArray["ARCH"] . " = ?, " . $dbAssetArray["HOSTNAME"] . " = ?, " . $dbFirmwareArray["FW_VERSION"] . " = ?, " . $dbAssetArray["IN_USE"] . " = ?, " . $dbAssetArray["SEAL_NUMBER"] . " = ?, " . $dbAssetArray["TAG"] . " = ?, " . $dbAssetArray["HW_TYPE"] . " = ?, " . $dbFirmwareArray["FW_TYPE"] . " = ?, " . $dbAssetArray["MAC_ADDRESS"] . " = ?, " . $dbAssetArray["IP_ADDRESS"] . " = ?, " . $dbVideoCardArray["NAME"] . " = ?, " . $dbVideoCardArray["RAM"] . " = ?, " . $dbFirmwareArray["MEDIA_OPERATION_MODE"] . " = ?, " . $dbFirmwareArray["SECURE_BOOT"] . " = ?, " . $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] . " = ?, " . $dbFirmwareArray["TPM_VERSION"] . " = ? where id = ?") or die($translations["ERROR_UPDATE_ASSET_DATA"] . mysqli_error($connection));

		mysqli_stmt_bind_param($q, "ssssssssssssssssssssssssssssssssssssssss", $discarded, $building, $roomNumber, $deliveredToRegistrationNumber, $lastDeliveryDate, $standard, $note, $serviceDate, $adRegistered, $brand, $model, $serialNumber, $processor, $ramAmount, $ramType, $ramFrequency, $ramOccupiedSlots, $ramTotalSlots, $storageTotalSize, $operatingSystemName, $operatingSystemVersion, $operatingSystemBuild, $operatingSystemArch, $hostname, $fwVersion, $inUse, $sealNumber, $tag, $hwType, $fwType, $macAddress, $ipAddress, $videoCardName, $videoCardRam, $mediaOperationMode, $secureBoot, $virtualizationTechnology, $tpmVersion, $idAsset);

		mysqli_stmt_execute($q);
	}
	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryFormatPrevious = mysqli_query($connection, "select " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["SERVICE_TYPE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["BATTERY_CHANGE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["TICKET_NUMBER"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["AGENT_ID"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["ASSET_NUMBER_FK"] . "") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));

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
		<h1><?php echo $translations["ASSET_EDIT"] ?></h1><br>
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
			while ($result = mysqli_fetch_array($queryAsset)) {
				$idAsset = $result["id"];
				$assetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
				$oldAssetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
				$discarded = $result[$dbAssetArray["DISCARDED"]];
				$note = $result[$dbAssetArray["NOTE"]];
				$standard = $result[$dbAssetArray["STANDARD"]];
				$adRegistered = $result[$dbAssetArray["AD_REGISTERED"]];
				$storageTotalSize = $result[$dbAssetArray["STORAGE_TOTAL_SIZE"]];
				$inUse = $result[$dbAssetArray["IN_USE"]];
				$sealNumber = $result[$dbAssetArray["SEAL_NUMBER"]];
				$tag = $result[$dbAssetArray["TAG"]];

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
				<?php
				while ($result = mysqli_fetch_array($queryAssetLocation)) {
					$building = $result[$dbLocationArray["BUILDING"]];
					$roomNumber = $result[$dbLocationArray["ROOM_NUMBER"]];
					$deliveredToRegistrationNumber = $result[$dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"]];
					$lastDeliveryDate = $result[$dbLocationArray["LAST_DELIVERY_DATE"]];
					$lastDeliveryMadeBy = $result[$dbLocationArray["LAST_DELIVERY_MADE_BY"]];
				?>
					<tr>
						<td id=lblFixed><?php echo $translations["BUILDING"] ?></td>
						<td colspan=5>
							<select id="formFields" name="txtBuilding" required>
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
						<td colspan=5><input id="formFields" type=text name=txtRoomNumber placeholder="<?php echo $translations["PLACEHOLDER_ASSET_ROOM_NUMBER"] ?>" maxlength="5" required value="<?php echo $roomNumber; ?>"></td>
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
				<?php
				}
				?>
				<tr>
					<td id=lblFixed><?php echo $translations["IN_USE"] ?></td>
					<td>
						<select name="txtInUse">
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value=1 <?php if ($inUse == "1") echo "selected"; ?>><?php echo $translations["YES"] ?>
							</option>
							<option value=0 <?php if ($inUse == "0") echo "selected"; ?>><?php echo $translations["NO"] ?>
							</option>
						</select>
				</tr>

				<tr>
					<td id=lblFixed><?php echo $translations["TAG"] ?></td>
					<td>
						<select name="txtTag">
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value=1 <?php if ($tag == "1") echo "selected"; ?>><?php echo $translations["YES"] ?></option>
							<option value=0 <?php if ($tag == "0") echo "selected"; ?>><?php echo $translations["NO"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["AD_REGISTERED"] ?></td>
					<td>
						<select name="txtAdRegistered">
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
						<select name="txtStandard">
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
					<td id=lblFixed><?php echo $translations["NOTE"] ?></td>
					<td colspan=5><textarea name=txtNote cols=20 rows=2 placeholder="<?php echo $translations["PLACEHOLDER_ASSET_NOTE"] ?>"><?php echo $note; ?></textarea>
					</td>
				</tr>
		</table>
		<table id="formFields">
			<tr>
				<td colspan="3" id=section-header><?php echo $translations["COMPUTER_DATA"] ?></td>
			</tr>
			<?php
				while ($result = mysqli_fetch_array($queryAssetHardware)) {
					$brand = $result[$dbHardwareArray["BRAND"]];
					$model = $result[$dbHardwareArray["MODEL"]];
					$serialNumber = $result[$dbHardwareArray["SERIAL_NUMBER"]];
					$processor = $result[$dbHardwareArray["PROCESSOR"]];
					$hwType = $result[$dbHardwareArray["TYPE"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["HW_TYPE"] ?></td>
					<td>
						<select name="txtHwType">
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
					<td id=lblFixed><?php echo $translations["BRAND"] ?></td>
					<td><input type=text name=txtBrand value="<?php echo $brand; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["MODEL"] ?></td>
					<td><input type=text name=txtModel value="<?php echo $model; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SERIAL_NUMBER"] ?></td>
					<td><input type=text name=txtSerialNumber value="<?php echo $serialNumber; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["PROCESSOR"] ?></td>
					<td><input type=text name=txtProcessor value="<?php echo $processor; ?>"></td>
				</tr>
			<?php
				}
				while ($result = mysqli_fetch_array($queryAssetRam)) {
					$ramAmount = $result[$dbRamArray["AMOUNT"]];
					$ramType = $result[$dbRamArray["TYPE"]];
					$ramFrequency = $result[$dbRamArray["FREQUENCY"]];
					$ramTotalSlots = $result[$dbRamArray["TOTAL_SLOTS"]];
					$ramOccupiedSlots = $result[$dbRamArray["OCCUPIED_SLOTS"]];
			?>
			<tr>
				RAM
			</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["RAM_AMOUNT"] . " (MB)" ?></td>
					<td><input type=number name=txtRamAmount value="<?php echo $ramAmount; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["RAM_TYPE"] ?></td>
					<td>
						<select name="txtRamType">
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
					<td><input type=number name=txtRamFrequency value="<?php echo $ramFrequency; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["RAM_OCCUPIED_SLOTS"] ?></td>
					<td><input type=number name=txtRamOccupiedSlots value="<?php echo $ramOccupiedSlots; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["RAM_TOTAL_SLOTS"] ?></td>
					<td><input type=number name=txtRamTotalSlots value="<?php echo $ramTotalSlots; ?>"></td>
				</tr>
			<?php
				}
				while ($result = mysqli_fetch_array($queryAssetVideoCard)) {
					$videoCardName = $result[$dbVideoCardArray["NAME"]];
					$videoCardRam = $result[$dbVideoCardArray["RAM"]];
					$videoCardGpuId = $result[$dbVideoCardArray["GPU_ID"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["VIDEO_CARD_NAME"] ?></td>
					<td><input type=text name=txtVideoCardName value="<?php echo $videoCardName; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["VIDEO_CARD_RAM"] . " (MB)" ?></td>
					<td><input type=number name=txtVideoCardRam value="<?php echo $videoCardRam; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["VIDEO_CARD_ID"] ?></td>
					<td><input type=number name=txtGpuId value="<?php echo $videoCardGpuId; ?>"></td>
				</tr>
			<?php
				}
				while ($result = mysqli_fetch_array($queryAssetOperatingSystem)) {
					$operatingSystemName = $result[$dbOperatingSystemArray["NAME"]];
					$operatingSystemVersion = $result[$dbOperatingSystemArray["VERSION"]];
					$operatingSystemBuild = $result[$dbOperatingSystemArray["BUILD"]];
					$operatingSystemArch = $result[$dbOperatingSystemArray["ARCH"]];
			?>
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
			<?php
				}
				while ($result = mysqli_fetch_array($queryAssetNetwork)) {
					$hostname = $result[$dbNetworkArray["HOSTNAME"]];
					$macAddress = $result[$dbNetworkArray["MAC_ADDRESS"]];
					$ipAddress = $result[$dbNetworkArray["IP_ADDRESS"]];
			?>
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
			<?php
				}
				while ($result = mysqli_fetch_array($queryAssetFirmware)) {
					$fwVersion = $result[$dbFirmwareArray["VERSION"]];
					$fwType = $result[$dbFirmwareArray["TYPE"]];
					$mediaOperationMode = $result[$dbFirmwareArray["MEDIA_OPERATION_MODE"]];
					$secureBoot = $result[$dbFirmwareArray["SECURE_BOOT"]];
					$virtualizationTechnology = $result[$dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"]];
					$tpmVersion = $result[$dbFirmwareArray["TPM_VERSION"]];
			?>
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