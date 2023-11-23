<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");
require_once("functions.php");

$send = null;
$idAsset = null;
$assetFK = null;
$oldAssetNumber = null;
$printedDelivery = false;
$printedMaintenances = false;
$totalRamSize = 0;
$totalStorageSize = 0;

$processor = $videoCard = null;

$queryUsers = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . "") or die($translations["ERROR_QUERY_AGENT"] . mysqli_error($connection));

if ($send != 1) {
	if (isset($_GET["id"]))
		$idAsset = $_GET["id"];

	if (isset($_GET["assetNumberFK"]))
		$assetFK = $_GET["assetNumberFK"];

	$queryAsset = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetFirmware = mysqli_query($connection, "select " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["TYPE"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["VERSION"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["MEDIA_OPERATION_MODE"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["SECURE_BOOT"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["TPM_VERSION"] . ", " . $dbFirmwareArray["FIRMWARE_TABLE"] . "." . $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbFirmwareArray["FIRMWARE_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbFirmwareArray["FIRMWARE_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetHardware = mysqli_query($connection, "select " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["BRAND"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["MODEL"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["TYPE"] . ", " . $dbHardwareArray["HARDWARE_TABLE"] . "." . $dbHardwareArray["SERIAL_NUMBER"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbHardwareArray["HARDWARE_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetProcessor = mysqli_query($connection, "select " . $dbProcessorArray["PROCESSOR_TABLE"] . "." . $dbProcessorArray["CPU_ID"] . ", " . $dbProcessorArray["PROCESSOR_TABLE"] . "." . $dbProcessorArray["NAME"] . ", " . $dbProcessorArray["PROCESSOR_TABLE"] . "." . $dbProcessorArray["FREQUENCY"] . ", " . $dbProcessorArray["PROCESSOR_TABLE"] . "." . $dbProcessorArray["NUMBER_OF_CORES"] . ", " . $dbProcessorArray["PROCESSOR_TABLE"] . "." . $dbProcessorArray["NUMBER_OF_THREADS"] . ", " . $dbProcessorArray["PROCESSOR_TABLE"] . "." . $dbProcessorArray["CACHE"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbProcessorArray["PROCESSOR_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbProcessorArray["PROCESSOR_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetRam = mysqli_query($connection, "select " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["AMOUNT"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["FREQUENCY"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["MANUFACTURER"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["SERIAL_NUMBER"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["PART_NUMBER"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["SLOT"] . ", " . $dbRamArray["RAM_TABLE"] . "." . $dbRamArray["TYPE"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbRamArray["RAM_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbRamArray["RAM_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetStorage = mysqli_query($connection, "select " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["STORAGE_ID"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["TYPE"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["SIZE"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["CONNECTION"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["MODEL"] . "," . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["SERIAL_NUMBER"] . ", " . $dbStorageArray["STORAGE_TABLE"] . "." . $dbStorageArray["SMART_STATUS"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbStorageArray["STORAGE_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbStorageArray["STORAGE_TABLE"] . ".assetNumberFK order by " . $dbStorageArray["STORAGE_ID"]) or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetVideoCard = mysqli_query($connection, "select " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . "." . $dbVideoCardArray["GPU_ID"] . ", " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . "." . $dbVideoCardArray["NAME"] . ", " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . "." . $dbVideoCardArray["RAM"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . ".assetNumberFK order by " . $dbVideoCardArray["GPU_ID"]) or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetLocation = mysqli_query($connection, "select " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["BUILDING"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["LAST_DELIVERY_DATE"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["LAST_DELIVERY_MADE_BY"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["ROOM_NUMBER"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbLocationArray["LOCATION_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbLocationArray["LOCATION_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetMaintenances = mysqli_query($connection, "select " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["SERVICE_DATE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["SERVICE_TYPE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["BATTERY_CHANGE"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["TICKET_NUMBER"] . ", " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . "." . $dbMaintenanceArray["AGENT_ID"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetNetwork = mysqli_query($connection, "select " . $dbNetworkArray["NETWORK_TABLE"] . "." . $dbNetworkArray["MAC_ADDRESS"] . ", " . $dbNetworkArray["NETWORK_TABLE"] . "." . $dbNetworkArray["IP_ADDRESS"] . ", " . $dbNetworkArray["NETWORK_TABLE"] . "." . $dbNetworkArray["HOSTNAME"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbNetworkArray["NETWORK_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbNetworkArray["NETWORK_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryAssetOperatingSystem = mysqli_query($connection, "select " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["ARCH"] . ", " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["BUILD"] . ", " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["NAME"] . ", " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . "." . $dbOperatingSystemArray["VERSION"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
}
?>
<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }
																													} ?>>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<script>
		function overlayProcessorOn() {
			document.getElementById("processorOverlay").style.display = "block";
			document.getElementsByTagName("html")[0].style.overflowY = 'hidden';
		}

		function overlayProcessorOff() {
			document.getElementById("processorOverlay").style.display = "none";
			document.getElementsByTagName("html")[0].style.overflowY = 'auto';
		}

		function overlayRamOn() {
			document.getElementById("ramOverlay").style.display = "block";
			document.getElementsByTagName("html")[0].style.overflowY = 'hidden';
		}

		function overlayRamOff() {
			document.getElementById("ramOverlay").style.display = "none";
			document.getElementsByTagName("html")[0].style.overflowY = 'auto';
		}

		function overlayVideoCardOn() {
			document.getElementById("videoCardOverlay").style.display = "block";
			document.getElementsByTagName("html")[0].style.overflowY = 'hidden';
		}

		function overlayVideoCardOff() {
			document.getElementById("videoCardOverlay").style.display = "none";
			document.getElementsByTagName("html")[0].style.overflowY = 'auto';
		}

		function overlayStorageOn() {
			document.getElementById("storageOverlay").style.display = "block";
			document.getElementsByTagName("html")[0].style.overflowY = 'hidden';
		}

		function overlayStorageOff() {
			document.getElementById("storageOverlay").style.display = "none";
			document.getElementsByTagName("html")[0].style.overflowY = 'auto';
		}
	</script>

	<div id="processorOverlay">
		<div id=title><?php echo $translations["FIXED_PROCESSOR_LIST"]; ?></div>
		<button id="closeButton" onclick="overlayProcessorOff()"><?php echo $translations["CLOSE"]; ?></button>
		<div id="window">
			<table id=processorData>
				<thead id=headerTable>
					<tr>
						<th>
							<?php echo $translations["CPU_ID"] ?>
						</th>
						<th>
							<?php echo $translations["CPU_NAME"] ?>
						</th>
						<th>
							<?php echo $translations["CPU_FREQUENCY"] ?>
						</th>
						<th>
							<?php echo $translations["CPU_NUMBER_OF_CORES"] ?>
						</th>
						<th>
							<?php echo $translations["CPU_NUMBER_OF_THREADS"] ?>
						</th>
						<th>
							<?php echo $translations["CPU_CACHE"] ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($resultProcessor = mysqli_fetch_array($queryAssetProcessor)) {
						$processorId = $resultProcessor[$dbProcessorArray["CPU_ID"]];
						$processorName = $resultProcessor[$dbProcessorArray["NAME"]];
						$processorFrequency = $resultProcessor[$dbProcessorArray["FREQUENCY"]];
						$processorCores = $resultProcessor[$dbProcessorArray["NUMBER_OF_CORES"]];
						$processorThreads = $resultProcessor[$dbProcessorArray["NUMBER_OF_THREADS"]];
						$processorCache = $resultProcessor[$dbProcessorArray["CACHE"]];
					?>
						<tr id=bodyTable>
							<td>
								<?php
								echo $processorId;
								if ($processorId == "0") {
									$processor = $processorName;
								}
								?>
							</td>
							<td>
								<?php
								echo $processorName;
								?>
							</td>
							<td>
								<?php
								echo $processorFrequency . " MHz";
								?>
							</td>
							<td>
								<?php
								echo $processorCores;
								?>
							</td>
							<td>
								<?php
								echo $processorThreads;
								?>
							</td>
							<td>
								<?php
								if ($processorCache / 1024 / 1024 / 1024 >= 1024) {
									echo floor($processorCache / 1024 / 1024 / 1024 / 1024) . " TB";
								} else if ($processorCache / 1024 / 1024 / 1024 < 1024 && $processorCache / 1024 / 1024 / 1024 >= 1) {
									echo floor($processorCache / 1024 / 1024 / 1024) . " GB";
								} else {
									echo floor($processorCache / 1024 / 1024) . " MB";
								}
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div id="ramOverlay">
		<div id=title><?php echo $translations["FIXED_RAM_LIST"]; ?></div>
		<button id="closeButton" onclick="overlayRamOff()"><?php echo $translations["CLOSE"]; ?></button>
		<div id="window">
			<table id=ramData>
				<thead id=headerTable>
					<tr>
						<th>
							<?php echo $translations["RAM_SLOT"] ?>
						</th>
						<th>
							<?php echo $translations["RAM_TYPE"] ?>
						</th>
						<th>
							<?php echo $translations["RAM_AMOUNT"] ?>
						</th>
						<th>
							<?php echo $translations["RAM_FREQUENCY"] ?>
						</th>
						<th>
							<?php echo $translations["RAM_MANUFACTURER"] ?>
						</th>
						<th>
							<?php echo $translations["RAM_SERIAL_NUMBER"] ?>
						</th>
						<th>
							<?php echo $translations["RAM_PART_NUMBER"] ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($resultRam = mysqli_fetch_array($queryAssetRam)) {
						$ramSlot = $resultRam[$dbRamArray["SLOT"]];
						$ramType = $resultRam[$dbRamArray["TYPE"]];
						$ramAmount = $resultRam[$dbRamArray["AMOUNT"]];
						$ramFrequency = $resultRam[$dbRamArray["FREQUENCY"]];
						$ramManufacturer = $resultRam[$dbRamArray["MANUFACTURER"]];
						$ramSerialNumber = $resultRam[$dbRamArray["SERIAL_NUMBER"]];
						$ramPartNumber = $resultRam[$dbRamArray["PART_NUMBER"]];
					?>
						<tr id=bodyTable>
							<td>
								<?php
								if ($ramSlot != "-2") {
									echo $ramSlot;
								} else {
									echo $ramTypesArray[0];
								}
								?>
							</td>
							<td>
								<?php
								$b = false;
								if ($ramType == "26") {
									echo $ramTypesArray[5];
								} else if ($ramType == "24") {
									echo $ramTypesArray[4];
								} else if ($ramType == "22") {
									echo $ramTypesArray[3];
								} else if ($ramType == "0") {
									echo $ramTypesArray[2];
								} else if ($ramType == "2") {
									echo $ramTypesArray[1];
								} else if ($ramType == "-2") {
									echo $ramTypesArray[0];
								}
								?>
							</td>
							<td>
								<?php
								$totalRamSize += $ramAmount;
								if ($ramAmount != "-2") {
									if ($ramAmount / 1024 / 1024 / 1024 >= 1024) {
										echo floor($ramAmount / 1024 / 1024 / 1024 / 1024) . " TB";
									} else if ($ramAmount / 1024 / 1024 / 1024 < 1024 && $ramAmount / 1024 / 1024 / 1024 >= 1) {
										echo floor($ramAmount / 1024 / 1024 / 1024) . " GB";
									} else {
										echo floor($ramAmount / 1024 / 1024) . " MB";
									}
								} else {
									echo $ramTypesArray[0];
								}
								?>
							</td>
							<td>
								<?php
								if ($ramFrequency == "-1") {
									echo $ramTypesArray[1];
								} else if ($ramFrequency != "-2") {
									echo $ramFrequency . " MHz";
								} else {
									echo $ramTypesArray[0];
								}
								?>
							</td>
							<td>
								<?php
								if ($ramManufacturer == "-1") {
									echo $ramTypesArray[1];
								} else if ($ramManufacturer != "-2") {
									echo $ramManufacturer;
								} else {
									echo $ramTypesArray[0];
								}
								?>
							</td>
							<td>
								<?php
								if ($ramSerialNumber == "-1") {
									echo $ramTypesArray[1];
								} else if ($ramSerialNumber != "-2") {
									echo $ramSerialNumber;
								} else {
									echo $ramTypesArray[0];
								}
								?>
							</td>
							<td>
								<?php
								if ($ramPartNumber == "-1") {
									echo $ramTypesArray[1];
								} else if ($ramPartNumber != "-2") {
									echo $ramPartNumber;
								} else {
									echo $ramTypesArray[0];
								}
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div id="videoCardOverlay">
		<div id=title><?php echo $translations["FIXED_VIDEO_CARD_LIST"]; ?></div>
		<button id="closeButton" onclick="overlayVideoCardOff()"><?php echo $translations["CLOSE"]; ?></button>
		<div id="window">
			<table id=videoCardData>
				<thead id=headerTable>
					<tr>
						<th>
							<?php echo $translations["VIDEO_CARD_ID"] ?>
						</th>
						<th>
							<?php echo $translations["VIDEO_CARD_NAME"] ?>
						</th>
						<th>
							<?php echo $translations["VIDEO_CARD_RAM"] ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($resultVideoCard = mysqli_fetch_array($queryAssetVideoCard)) {
						$videoCardId = $resultVideoCard[$dbVideoCardArray["GPU_ID"]];
						$videoCardName = $resultVideoCard[$dbVideoCardArray["NAME"]];
						$videoCardRam = $resultVideoCard[$dbVideoCardArray["RAM"]];
					?>
						<tr id=bodyTable>
							<td>
								<?php
								echo $videoCardId;
								if ($videoCardId == "0") {
									$videoCard = $videoCardName;
								}
								?>
							</td>
							<td>
								<?php
								echo $videoCardName;
								?>
							</td>
							<td>
								<?php
								if ($videoCardRam / 1024 / 1024 / 1024 >= 1024) {
									echo floor($videoCardRam / 1024 / 1024 / 1024 / 1024) . " TB";
								} else if ($videoCardRam / 1024 / 1024 / 1024 < 1024 && $videoCardRam / 1024 / 1024 / 1024 >= 1) {
									echo floor($videoCardRam / 1024 / 1024 / 1024) . " GB";
								} else {
									echo floor($videoCardRam / 1024 / 1024) . " MB";
								}
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div id="storageOverlay">
		<div id=title><?php echo $translations["FIXED_STORAGE_MEDIA_LIST"]; ?></div>
		<button id="closeButton" onclick="overlayStorageOff()"><?php echo $translations["CLOSE"]; ?></button>
		<div id="window">
			<table id=storageData>
				<thead id=headerTable>
					<tr>
						<th>
							<?php echo $translations["STORAGE_ID"] ?>
						</th>
						<th>
							<?php echo $translations["STORAGE_LIST_TYPE"] ?>
						</th>
						<th>
							<?php echo $translations["STORAGE_LIST_SIZE"] ?>
						</th>
						<th>
							<?php echo $translations["STORAGE_LIST_CONNECTION"] ?>
						</th>
						<th>
							<?php echo $translations["STORAGE_LIST_MODEL"] ?>
						</th>
						<th>
							<?php echo $translations["STORAGE_LIST_SERIAL_NUMBER"] ?>
						</th>
						<th>
							<?php echo $translations["STORAGE_LIST_SMART"] ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($resultStorage = mysqli_fetch_array($queryAssetStorage)) {
						$storageConnection = $resultStorage[$dbStorageArray["CONNECTION"]];
						$storageModel = $resultStorage[$dbStorageArray["MODEL"]];
						$storageSerialNumber = $resultStorage[$dbStorageArray["SERIAL_NUMBER"]];
						$storageSize = $resultStorage[$dbStorageArray["SIZE"]];
						$storageSmartStatus = $resultStorage[$dbStorageArray["SMART_STATUS"]];
						$storageStorageId = $resultStorage[$dbStorageArray["STORAGE_ID"]];
						$storageType = $resultStorage[$dbStorageArray["TYPE"]];
					?>
						<tr id=bodyTable>
							<td>
								<?php
								echo $storageStorageId;
								?>
							</td>
							<td>
								<?php
								foreach ($storageTypesArray as $str1 => $str2) {
									if ($storageType == $str1)
										echo $str2;
								}
								?>
							</td>
							<td>
								<?php
								$totalStorageSize += $storageSize;
								if ($storageSize / 1000 / 1000 / 1000 >= 1000) {
									echo floor($storageSize / 1000 / 1000 / 1000 / 1000) . " TB";
								} else if ($storageSize / 1000 / 1000 / 1000 < 1000 && $storageSize / 1000 / 1000 / 1000 >= 1) {
									echo floor($storageSize / 1000 / 1000 / 1000) . " GB";
								} else {
									echo floor($storageSize / 1000 / 1000) . " MB";
								}
								?>
							</td>
							<td>
								<?php
								foreach ($connectionTypesArray as $str1 => $str2) {
									if ($storageConnection == $str1)
										echo $str2;
								}
								?>
							</td>
							<td>
								<?php
								echo $storageModel;
								?>
							</td>
							<td>
								<?php
								echo $storageSerialNumber;
								?>
							</td>
							<td>
								<?php
								if ($storageSmartStatus == "0")
									echo "OK";
								else if ($storageSmartStatus == "1")
									echo "Pred Fail";
								else if ($storageSmartStatus == "-1")
									echo "N/A";
								?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>


	<form id="formGeneral">
		<h2><?php echo $translations["ASSET_DETAIL"] ?></h2><br>
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
				$inUse = $result[$dbAssetArray["IN_USE"]];
				$sealNumber = $result[$dbAssetArray["SEAL_NUMBER"]];
				$tag = $result[$dbAssetArray["TAG"]];
				$hwHash = $result[$dbAssetArray["HW_HASH"]];
				$assetHash = $result[$dbAssetArray["ASSET_HASH"]];
			?>
				<tr>
					<td colspan=7 id=section-header><?php echo $translations["ASSET_DATA"] ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["STATUS"] ?></td>
					<td id=lblData><?php if ($discarded == "0") { ?><label style="color:var(--operational-forecolor);"><?php echo $translations["OPERATIONAL"]; ?></label> <?php } else { ?> <label style="color:var(--non-operational-forecolor);"><?php echo $translations["NON_OPERATIONAL"]; ?></label> <?php } ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["ASSET_NUMBER"] ?></td>
					<input type=hidden name=txtIdAsset value="<?php echo $idAsset; ?>">
					<input type=hidden name=txtOldAssetNumber value="<?php echo $oldAssetNumber; ?>">
					<td id=lblData><?php echo $assetNumber; ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SEAL_NUMBER"] ?></td>
					<td id=lblData><?php if ($sealNumber == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $sealNumber;
									} ?></td>
				</tr>

				<tr>
					<td id=lblFixed><?php echo $translations["IN_USE"] ?></td>
					<td id=lblData><?php if ($inUse == "") {
										echo $json_constants_array["DASH"];
									} else {
										if ($inUse == "1") {
											echo $translations["YES"];
										} else {
											echo $translations["NO"];
										}
									} ?></td>
				</tr>

				<tr>
					<td id=lblFixed><?php echo $translations["TAG"] ?></td>
					<td id=lblData><?php if ($tag == "") {
										echo $json_constants_array["DASH"];
									} else {
										if ($tag == "1") {
											echo $translations["YES"];
										} else {
											echo $translations["NO"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["AD_REGISTERED"] ?></td>
					<td id=lblData><?php if ($adRegistered == "") {
										echo $json_constants_array["DASH"];
									} else {
										if ($adRegistered == "1") {
											echo $translations["YES"];
										} else {
											echo $translations["NO"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["STANDARD"] ?></td>
					<td id=lblData><?php if ($standard == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($entityTypesArray as $str1 => $str2) {
											if ($str1 == $standard) {
												echo $translations["ENTITY_TYPES"][$str1];
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>

				<tr>
					<td id=lblFixed><?php echo $translations["NOTE"] ?></td>
					<td id=lblData><?php if ($note == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $note;
									} ?></td>
				</tr>
			<?php
			}
			while ($resultLocation = mysqli_fetch_array($queryAssetLocation)) {
				$building = $resultLocation[$dbLocationArray["BUILDING"]];
				$roomNumber = $resultLocation[$dbLocationArray["ROOM_NUMBER"]];
				$deliveredToRegistrationNumber = $resultLocation[$dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"]];
				$lastDeliveryDate = $resultLocation[$dbLocationArray["LAST_DELIVERY_DATE"]];
				$lastDeliveryMadeBy = $resultLocation[$dbLocationArray["LAST_DELIVERY_MADE_BY"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["BUILDING"] ?></td>
					<td id=lblData>
						<?php if ($building == "") {
							echo $json_constants_array["DASH"];
						} else {
							$b = false;
							foreach ($buildingArray as $str1 => $str2) {
								if ($str1 == $building) {
									echo $str2;
									$b = true;
									break;
								}
							}
							if ($b == false) {
								echo $translations["UNKNOWN"];
							}
						} ?>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["ASSET_ROOM"] ?></td>
					<td id=lblData><?php if ($roomNumber == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $roomNumber;
									} ?></td>
					</td>
				</tr>
				<?php
			}

			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
					<tr>
						<td id=h-separator colspan=7 align=center><input id="updateButton" type=button onclick="location.href='editAsset.php?id=<?php echo $idAsset ?>'" value=<?php echo $translations["LABEL_EDIT_BUTTON"] ?>></td>
					</tr>
			<?php
				}
			}
			?>
		</table>
		<br>
		<label id=asteriskWarning><?php echo $translations["USE_AIR_TO_EDIT"] ?></label>
		<table>
			<thead>
				<td colspan=5 id=section-header><?php echo $translations["PERFORMED_MAINTENANCES_TITLE"] ?></td>
				<tr id=headerTable>
					<th>
						<?php echo $translations["PERFORMED_MAINTENANCES_DATE"] ?>
					</th>
					<th>
						<?php echo $translations["PERFORMED_MAINTENANCES_SERVICE"] ?>
					</th>
					<th>
						<?php echo $translations["PERFORMED_MAINTENANCES_BATTERY"] ?>
					</th>
					<th>
						<?php echo $translations["PERFORMED_MAINTENANCES_TICKET"] ?>
					</th>
					<th>
						<?php echo $translations["PERFORMED_MAINTENANCES_AGENT"] ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($resultMaintenances = mysqli_fetch_array($queryAssetMaintenances)) {
					$agentId = $resultMaintenances[$dbMaintenanceArray["AGENT_ID"]];
					$batteryChange = $resultMaintenances[$dbMaintenanceArray["BATTERY_CHANGE"]];
					$serviceDate = $resultMaintenances[$dbMaintenanceArray["SERVICE_DATE"]];
					$serviceType = $resultMaintenances[$dbMaintenanceArray["SERVICE_TYPE"]];
					$ticketNumber = $resultMaintenances[$dbMaintenanceArray["TICKET_NUMBER"]];
				?>
					<tr id=bodyTable>
						<td>
							<?php
							$previousMaintenancesDate = $serviceDate;
							$datePM = substr($previousMaintenancesDate, 0, 10);
							$explodedDateA = explode($json_constants_array["DASH"], $datePM);
							$previousMaintenancesDate = $explodedDateA[2] . "/" . $explodedDateA[1] . "/" . $explodedDateA[0];
							echo $previousMaintenancesDate;
							?>
						</td>
						<td>
							<?php
							foreach ($serviceTypesArray as $str) {
								if ($serviceType == $str)
									echo $translations["SERVICE_TYPE"][$str];
							}
							?>
						</td>
						<td>
							<?php
							$previousMaintenancesBattery = $batteryChange;
							if ($previousMaintenancesBattery != "" && $previousMaintenancesBattery == "1") {
								echo $translations["BATTERY_REPLACED"];
							} else if ($previousMaintenancesBattery == "0") {
								echo $translations["BATTERY_NOT_REPLACED"];
							} else {
								echo $json_constants_array["DASH"];
							}
							?>
						</td>
						<td>
							<?php
							$previousMaintenancesTicket = $ticketNumber;
							if ($previousMaintenancesTicket != "")
								echo $previousMaintenancesTicket;
							else
								echo $json_constants_array["DASH"];
							?>
						</td>
						<td>
							<?php
							if (isset($queryUsers))
								mysqli_data_seek($queryUsers, 0);
							while ($resultUsers = mysqli_fetch_array($queryUsers)) {
								if ($agentId == $resultUsers["id"]) {
									if ($resultUsers[$dbAgentArray["NAME"]] != "") {
										echo $resultUsers[$dbAgentArray["NAME"]] . " " . $resultUsers[$dbAgentArray["SURNAME"]];
										$printedMaintenances = true;
										break;
									} else {
										echo $resultUsers[$dbAgentArray["USERNAME"]];
										$printedMaintenances = true;
										break;
									}
								}
							?>
							<?php
							}
							?>
							<?php
							if ($printedMaintenances == false)
								echo $json_constants_array["DASH"];
							?>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<table id="formFields">
			<tbody>
				<tr>
					<td id=lblFixed><?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?></td>
					<td id=lblData><?php if ($deliveredToRegistrationNumber == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $deliveredToRegistrationNumber;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["LAST_DELIVERY_DATE"] ?></td>
					<td id=lblData><?php if ($lastDeliveryDate == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $lastDeliveryDate;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["LAST_DELIVERY_MADE_BY"] ?></td>
					<td id=lblData><label name=txtLastDeliveryMadeBy style=line-height:40px;font-size:12pt></label>
						<?php
						if (isset($queryUsers))
							mysqli_data_seek($queryUsers, 0);
						while ($resultUsers = mysqli_fetch_array($queryUsers)) {
							if ($lastDeliveryMadeBy == $resultUsers["id"]) {
						?>
								<label>
									<?php
									if ($resultUsers[$dbAgentArray["NAME"]] != "") {
										echo $resultUsers[$dbAgentArray["NAME"]] . " " . $resultUsers[$dbAgentArray["SURNAME"]];
										$printedMaintenances = true;
									} else {
										echo $resultUsers[$dbAgentArray["USERNAME"]];
										$printedMaintenances = true;
									}
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
			</tbody>
		</table>
		<table id="formFields">
			<thead>
				<td colspan="3" id=section-header><?php echo $translations["COMPUTER_DATA"] ?></td>
			</thead>
			<tr id=subHeaderTable>
				<td colspan="2">
					<label>
						<?php
						echo $translations["GENERAL"];
						?>
					</label>
				</td>
			</tr>
			<?php
			while ($resultHardware = mysqli_fetch_array($queryAssetHardware)) {
				$brand = $resultHardware[$dbHardwareArray["BRAND"]];
				$model = $resultHardware[$dbHardwareArray["MODEL"]];
				$serialNumber = $resultHardware[$dbHardwareArray["SERIAL_NUMBER"]];
				$hwType = $resultHardware[$dbHardwareArray["TYPE"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["HW_TYPE"] ?></td>
					<td id=lblData><?php if ($hwType == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($hwTypesArray as $str1 => $str2) {
											if ($str1 == $hwType) {
												echo $str2;
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["BRAND"] ?></td>
					<td id=lblData><?php if ($brand == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $brand;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["MODEL"] ?></td>
					<td id=lblData><?php if ($model == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $model;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SERIAL_NUMBER"] ?></td>
					<td id=lblData><?php if ($serialNumber == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $serialNumber;
									} ?></td>
				</tr>
			<?php
			}
			?>
			<tr id=subHeaderTable>
				<td colspan="2">
					<label>
						<?php
						echo $translations["PROCESSOR"];
						?>
					</label>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["PROCESSOR"] ?></td>
				<td id=lblData><?php if ($processor == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $processor;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["INSTALLED_PROCESSORS"] ?></td>
				<td id=lblData>
					<a id=linksameline onclick="overlayProcessorOn()"><?php echo $translations["DETAILS"]; ?></a>
				</td>
			</tr>
			<tr id=subHeaderTable>
				<td colspan="2">
					<label>
						<?php
						echo $translations["RAM"];
						?>
					</label>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_TOTAL"] ?></td>
				<td id=lblData><?php
								if ($totalRamSize / 1024 / 1024 / 1024 >= 1024) {
									echo floordec($totalRamSize / 1024 / 1024 / 1024 / 1024, 1) . " TB";
								} else if ($totalRamSize / 1024 / 1024 / 1024 < 1024 && $totalRamSize / 1024 / 1024 / 1024 >= 1) {
									echo floordec($totalRamSize / 1024 / 1024 / 1024, 1) . " GB";
								} else {
									echo floordec($totalRamSize / 1024 / 1024, 1) . " MB";
								}
								?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["INSTALLED_RAM_BOARDS"] ?></td>
				<td id=lblData>
					<a id=linksameline onclick="overlayRamOn()"><?php echo $translations["DETAILS"]; ?></a>
				</td>
			</tr>
			<tr id=subHeaderTable>
				<td colspan="2">
					<label>
						<?php
						echo $translations["VIDEO_CARD"];
						?>
					</label>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIDEO_CARD"] ?></td>
				<td id=lblData><?php if ($videoCard == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $videoCard;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["INSTALLED_VIDEO_CARD_DEVICES"] ?></td>
				<td id=lblData>
					<a id=linksameline onclick="overlayVideoCardOn()"><?php echo $translations["DETAILS"]; ?></a>
				</td>
			</tr>
			<tr id=subHeaderTable>
				<td colspan="2">
					<label>
						<?php
						echo $translations["STORAGE"];
						?>
					</label>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["STORAGE_TOTAL_SIZE"] ?></td>
				<td id=lblData>
					<?php
					if ($totalStorageSize / 1000 / 1000 / 1000 >= 1000) {
						echo floordec($totalStorageSize / 1000 / 1000 / 1000 / 1000, 1) . " TB";
					} else if ($totalStorageSize / 1000 / 1000 / 1000 < 1000 && $totalStorageSize / 1000 / 1000 / 1000 >= 1) {
						echo floordec($totalStorageSize / 1000 / 1000 / 1000, 1) . " GB";
					} else {
						echo floordec($totalStorageSize / 1000 / 1000, 1) . " MB";
					}
					?>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["INSTALLED_STORAGE_DRIVES"] ?></td>
				<td id=lblData>
					<a id=linksameline onclick="overlayStorageOn()"><?php echo $translations["DETAILS"]; ?></a>
				</td>
			</tr>
			<tr id=subHeaderTable>
				<td colspan="2">
					<label>
						<?php
						echo $translations["FIRMWARE"];
						?>
					</label>
				</td>
			</tr>
			<?php
			while ($resultFirmware = mysqli_fetch_array($queryAssetFirmware)) {
				$fwVersion = $resultFirmware[$dbFirmwareArray["VERSION"]];
				$fwType = $resultFirmware[$dbFirmwareArray["TYPE"]];
				$mediaOperationMode = $resultFirmware[$dbFirmwareArray["MEDIA_OPERATION_MODE"]];
				$secureBoot = $resultFirmware[$dbFirmwareArray["SECURE_BOOT"]];
				$virtualizationTechnology = $resultFirmware[$dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"]];
				$tpmVersion = $resultFirmware[$dbFirmwareArray["TPM_VERSION"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["MEDIA_OPERATION_MODE"] ?></td>
					<td id=lblData><?php if ($mediaOperationMode == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($mediaOpTypesArray as $str1 => $str2) {
											if ($str1 == $mediaOperationMode) {
												echo $str2;
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["FW_TYPE"] ?></td>
					<td id=lblData><?php if ($fwType == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($fwTypesArray as $str1 => $str2) {
											if ($str1 == $fwType) {
												echo $str2;
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["FW_VERSION"] ?></td>
					<td id=lblData><?php if ($fwVersion == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $fwVersion;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SECURE_BOOT"]["NAME"] ?></td>
					<td id=lblData><?php if ($secureBoot == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($secureBootArray as $str) {
											if ($str == $secureBoot) {
												echo $translations["SECURE_BOOT"][$str];
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></td>
					<td id=lblData><?php if ($virtualizationTechnology == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($virtualizationTechnologyArray as $str) {
											if ($str == $virtualizationTechnology) {
												echo $translations["VIRTUALIZATION_TECHNOLOGY"][$str];
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["TPM_VERSION"] ?></td>
					<td id=lblData><?php if ($tpmVersion == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($tpmTypesArray as $str1 => $str2) {
											if ($str1 == $tpmVersion) {
												echo $str2;
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
				<tr id=subHeaderTable>
					<td colspan="2">
						<label>
							<?php
							echo $translations["NETWORK"];
							?>
						</label>
					</td>
				</tr>
			<?php
			}

			while ($resultNetwork = mysqli_fetch_array($queryAssetNetwork)) {
				$hostname = $resultNetwork[$dbNetworkArray["HOSTNAME"]];
				$macAddress = $resultNetwork[$dbNetworkArray["MAC_ADDRESS"]];
				$ipAddress = $resultNetwork[$dbNetworkArray["IP_ADDRESS"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["HOSTNAME"] ?></td>
					<td id=lblData><?php if ($hostname == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $hostname;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["MAC_ADDRESS"] ?></td>
					<td id=lblData><?php if ($macAddress == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $macAddress;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["IP_ADDRESS"] ?></td>
					<td id=lblData><?php if ($ipAddress == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $ipAddress;
									} ?></td>
				</tr>
				<tr id=subHeaderTable>
					<td colspan="2">
						<label>
							<?php
							echo $translations["OPERATING_SYSTEM"];
							?>
						</label>
					</td>
				</tr>
			<?php
			}
			while ($resultOperatingSystem = mysqli_fetch_array($queryAssetOperatingSystem)) {
				$operatingSystemName = $resultOperatingSystem[$dbOperatingSystemArray["NAME"]];
				$operatingSystemVersion = $resultOperatingSystem[$dbOperatingSystemArray["VERSION"]];
				$operatingSystemBuild = $resultOperatingSystem[$dbOperatingSystemArray["BUILD"]];
				$operatingSystemArch = $resultOperatingSystem[$dbOperatingSystemArray["ARCH"]];
			?>
				<tr>
					<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_NAME"] ?></td>
					<td id=lblData><?php if ($operatingSystemName == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $operatingSystemName;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_VERSION"] ?></td>
					<td id=lblData><?php if ($operatingSystemVersion == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $operatingSystemVersion;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_BUILD"] ?></td>
					<td id=lblData><?php if ($operatingSystemBuild == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $operatingSystemBuild;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM_ARCH"] ?></td>
					<td id=lblData><?php if ($operatingSystemArch == "") {
										echo $json_constants_array["DASH"];
									} else {
										$b = false;
										foreach ($operatingSystemArchArray as $str1 => $str2) {
											if ($str1 == $operatingSystemArch) {
												echo $str2;
												$b = true;
												break;
											}
										}
										if ($b == false) {
											echo $translations["UNKNOWN"];
										}
									} ?></td>
				</tr>
			<?php
			}
			?>
		</table>
		<br>
		<table id="formFields">
			<tr>
				<td id=lblFixed><?php echo $translations["ASSET_HASH"] ?></td>
				<td id=lblData><?php if ($assetHash == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $assetHash;
								} ?></td>
				</td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["HW_HASH"] ?></td>
				<td id=lblData><?php if ($hwHash == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $hwHash;
								} ?></td>
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>