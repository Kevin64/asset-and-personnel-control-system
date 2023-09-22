<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$idAsset = null;
$assetFK = null;
$oldAssetNumber = null;
$printedDelivery = false;
$printedMaintenances = false;

$queryUsers = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . "") or die($translations["ERROR_QUERY_AGENT"] . mysqli_error($connection));

if ($send != 1) {
	if (isset($_GET["id"]))
		$idAsset = $_GET["id"];

	if (isset($_GET["assetNumberFK"]))
		$assetFK = $_GET["assetNumberFK"];

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryFormatPrevious = mysqli_query($connection, "select " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["PREVIOUS_SERVICE_DATES"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["SERVICE_TYPE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["BATTERY_CHANGE"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["TICKET_NUMBER"] . ", " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . "." . $dbMaintenancesArray["AGENT_ID"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbMaintenancesArray["MAINTENANCES_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryStorageList = mysqli_query($connection, "select " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["STORAGE_ID"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["TYPE"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["SIZE"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["CONNECTION"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["MODEL"] . "," . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["SERIAL_NUMBER"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["SMART_STATUS"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbStorageListArray["STORAGE_LIST_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbStorageListArray["STORAGE_LIST_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
}
?>
<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }
																													} ?>>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script src="js/disable-controls.js"></script>
	<script>
		function on() {
			document.getElementById("overlay").style.display = "block";
			document.getElementsByTagName("html")[0].style.overflowY = 'hidden';
		}

		function off() {
			document.getElementById("overlay").style.display = "none";
			document.getElementsByTagName("html")[0].style.overflowY = 'auto';
		}
	</script>



	<form id="formGeneral">
		<h2><?php echo $translations["ASSET_DETAIL"] ?></h2><br>
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
				$ramTotalSlots = $result[$dbAssetArray["RAM_TOTAL_SLOTS"]];
				$ramOccupiedSlots = $result[$dbAssetArray["RAM_OCCUPIED_SLOTS"]];
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
					<td id=lblData><?php if ($note == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $note;
									} ?></td>
				</tr>
		</table>
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
				while ($resultFormatPrevious = mysqli_fetch_array($queryFormatPrevious)) { ?>
					<tr id=bodyTable>
						<td>
							<?php
							$previousMaintenancesDate = $resultFormatPrevious[$dbMaintenancesArray["PREVIOUS_SERVICE_DATES"]];
							$datePM = substr($previousMaintenancesDate, 0, 10);
							$explodedDateA = explode($json_constants_array["DASH"], $datePM);
							$previousMaintenancesDate = $explodedDateA[2] . "/" . $explodedDateA[1] . "/" . $explodedDateA[0];
							echo $previousMaintenancesDate;
							?>
						</td>
						<td>
							<?php
							foreach ($serviceTypesArray as $str) {
								if ($resultFormatPrevious[$dbMaintenancesArray["SERVICE_TYPE"]] == $str)
									echo $translations["SERVICE_TYPE"][$str];
							}
							?>
						</td>
						<td>
							<?php
							$previousMaintenancesBattery = $resultFormatPrevious[$dbMaintenancesArray["BATTERY_CHANGE"]];
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
							$previousMaintenancesTicket = $resultFormatPrevious[$dbMaintenancesArray["TICKET_NUMBER"]];
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
								if ($resultFormatPrevious[$dbMaintenancesArray["AGENT_ID"]] == $resultUsers["id"]) {
									echo $resultUsers[$dbAgentArray["USERNAME"]];
									$printedMaintenances = true;
									break;
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
				</tr>
			</tbody>
		</table>
		<table id="formFields">
			<thead>
				<td colspan="3" id=section-header><?php echo $translations["COMPUTER_DATA"] ?></td>
			</thead>
			<tr>
				<td><input type=hidden name=txtServiceDate value="<?php echo $serviceDate; ?>"></td>
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
			<tr>
				<td id=lblFixed><?php echo $translations["PROCESSOR"] ?></td>
				<td id=lblData><?php if ($processor == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $processor;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_AMOUNT"] ?></td>
				<td id=lblData><?php if ($ramAmount == "") {
									echo $json_constants_array["DASH"];
								} else {
									if ($ramAmount / 1024 >= 1024) {
										echo floor($ramAmount / 1024 / 1024) . " TB";
									} else if ($ramAmount / 1024 < 1024 && $ramAmount / 1024 > 1) {
										echo floor($ramAmount / 1024) . " GB";
									} else {
										echo floor($ramAmount) . " MB";
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_TYPE"] ?></td>
				<td id=lblData><?php if ($ramType == "") {
									echo $json_constants_array["DASH"];
								} else {
									$b = false;
									foreach ($ramTypesArray as $str1 => $str2) {
										if ($str1 == $ramType) {
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
				<td id=lblFixed><?php echo $translations["RAM_FREQUENCY"] ?></td>
				<td id=lblData><?php if ($ramFrequency == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $ramFrequency . " MHz";
								}
								?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_SLOTS"] ?></td>
				<td id=lblData><?php if ($ramOccupiedSlots == "" || $ramTotalSlots == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $ramOccupiedSlots . " / " . $ramTotalSlots;
								}
								?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["STORAGE_TOTAL_SIZE"] ?></td>
				<td id=lblData><?php if ($storageTotalSize == "") {
									echo $json_constants_array["DASH"];
								} else {
									if ($storageTotalSize / 1024 >= 1024) {
										echo floor($storageTotalSize / 1024 / 1024) . " TB";
									} else if ($storageTotalSize / 1024 < 1024 && $storageTotalSize / 1024 >= 1) {
										echo floor($storageTotalSize / 1024) . " GB";
									} else {
										echo floor($storageTotalSize) . " MB";
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["STORAGE_SUMMARY"] ?></td>
				<td id=lblData>
					<a id=linksameline onclick="on()">Detalhes</a>
				</td>
			</tr>
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
				<td id=lblFixed><?php echo $translations["VIDEO_CARD_NAME"] ?></td>
				<td id=lblData><?php if ($videoCardName == "") {
									echo $json_constants_array["DASH"];
								} else {
									echo $videoCardName;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIDEO_CARD_RAM"] ?></td>
				<td id=lblData><?php if ($videoCardRam == "") {
									echo $json_constants_array["DASH"];
								} else {
									if ($videoCardRam / 1024 >= 1024) {
										echo floor($videoCardRam / 1024 / 1024) . " TB";
									} else if ($videoCardRam / 1024 < 1024 && $videoCardRam / 1024 >= 1) {
										echo floor($videoCardRam / 1024) . " GB";
									} else {
										echo floor($videoCardRam) . " MB";
									}
								} ?></td>
			</tr>
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
											echo $str2 . "-bit";
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
	</form>
	<div id="overlay">
		<div id=title>Lista de mídias de armazenamento fixas</div>
		<button id="closeButton" onclick="off()">Fechar</button>
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
					while ($resultStorageList = mysqli_fetch_array($queryStorageList)) {
					?>
						<tr id=bodyTable>
							<td>
								<?php
								echo $resultStorageList[$dbStorageListArray["STORAGE_ID"]];
								?>
							</td>
							<td>
								<?php
								foreach ($storageTypesArray as $str1 => $str2) {
									if ($resultStorageList[$dbStorageListArray["TYPE"]] == $str1)
										echo $str2;
								}
								?>
							</td>
							<td>
								<?php
								if ($resultStorageList[$dbStorageListArray["SIZE"]] / 1024 >= 1024) {
									echo floor($resultStorageList[$dbStorageListArray["SIZE"]] / 1024 / 1024) . " TB";
								} else if ($resultStorageList[$dbStorageListArray["SIZE"]] / 1024 < 1024 && $resultStorageList[$dbStorageListArray["SIZE"]] / 1024 >= 1) {
									echo floor($resultStorageList[$dbStorageListArray["SIZE"]] / 1024) . " GB";
								} else {
									echo floor($resultStorageList[$dbStorageListArray["SIZE"]]) . " MB";
								}
								?>
							</td>
							<td>
								<?php
								foreach ($connectionTypesArray as $str1 => $str2) {
									if ($resultStorageList[$dbStorageListArray["CONNECTION"]] == $str1)
										echo $str2;
								}
								?>
							</td>
							<td>
								<?php
								echo $resultStorageList[$dbStorageListArray["MODEL"]];
								?>
							</td>
							<td>
								<?php
								echo $resultStorageList[$dbStorageListArray["SERIAL_NUMBER"]];
								?>
							</td>
							<td>
								<?php
								echo $resultStorageList[$dbStorageListArray["SMART_STATUS"]];
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
</div>
<?php
require_once("foot.php");
?>