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

	$queryStorageList = mysqli_query($connection, "select " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["TYPE"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["SIZE"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["CONNECTION"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["MODEL"] . "," . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["SERIAL_NUMBER"] . ", " . $dbStorageListArray["STORAGE_LIST_TABLE"] . "." . $dbStorageListArray["SMART_STATUS"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbStorageListArray["STORAGE_LIST_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbStorageListArray["STORAGE_LIST_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
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
				$totalRamSlots = $result[$dbAssetArray["TOTAL_RAM_SLOTS"]];
				$occupiedRamSlots = $result[$dbAssetArray["OCCUPIED_RAM_SLOTS"]];
				$storageSize = $result[$dbAssetArray["STORAGE_SIZE"]];
				$operatingSystem = $result[$dbAssetArray["OPERATING_SYSTEM"]];
				$hostname = $result[$dbAssetArray["HOSTNAME"]];
				$inUse = $result[$dbAssetArray["IN_USE"]];
				$sealNumber = $result[$dbAssetArray["SEAL_NUMBER"]];
				$tag = $result[$dbAssetArray["TAG"]];
				$hwType = $result[$dbAssetArray["HW_TYPE"]];
				$macAddress = $result[$dbAssetArray["MAC_ADDRESS"]];
				$ipAddress = $result[$dbAssetArray["IP_ADDRESS"]];
				$fwVersion = $result[$dbAssetArray["FW_VERSION"]];
				$fwType = $result[$dbAssetArray["FW_TYPE"]];
				$storageType = $result[$dbAssetArray["STORAGE_TYPE"]];
				$videoCard = $result[$dbAssetArray["VIDEO_CARD"]];
				$mediaOperationMode = $result[$dbAssetArray["MEDIA_OPERATION_MODE"]];
				$secureBoot = $result[$dbAssetArray["SECURE_BOOT"]];
				$virtualizationTechnology = $result[$dbAssetArray["VIRTUALIZATION_TECHNOLOGY"]];
				$tpmVersion = $result[$dbAssetArray["TPM_VERSION"]];
			?>

				<tr>
					<td colspan=7 id=spacer><?php echo $translations["ASSET_DATA"] ?></td>
				</tr>
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<tr>
							<td id=lblFixed><?php echo $translations["STATUS"] ?></td>
							
							<td id=lblData><?php if ($discarded == "0") { ?><font color=<?php echo $colorArray["OPERATIONAL"]; ?>><?php echo $translations["OPERATIONAL"]; ?></font> <?php } else { ?> <font color=<?php echo $colorArray["NON_OPERATIONAL"]; ?>><?php echo $translations["NON_OPERATIONAL"]; ?></font> <?php } ?></td>
						</tr>
				<?php
					}
				}
				?>
				<tr>
					<td id=lblFixed><?php echo $translations["ASSET_NUMBER"] ?></td>
					
					<input type=hidden name=txtIdAsset value="<?php echo $idAsset; ?>">
					<input type=hidden name=txtOldAssetNumber value="<?php echo $oldAssetNumber; ?>">
					<td id=lblData><?php echo $assetNumber; ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SEAL_NUMBER"] ?></td>
					
					<td id=lblData><?php if ($sealNumber == "") {
										echo "-";
									} else {
										echo $sealNumber;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["BUILDING"] ?></td>
					
					<td id=lblData>
						<?php if ($building == "") {
							echo "-";
						} else {
							foreach ($buildingArray as $str1 => $str2) {
								if ($str1 == $building) {
									echo $str2;
								}
							}
						} ?>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["ASSET_ROOM"] ?></td>
					
					<td id=lblData><?php if ($roomNumber == "") {
										echo "-";
									} else {
										echo $roomNumber;
									} ?></td>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["IN_USE"] ?></td>
					
					<td id=lblData><?php if ($inUse == "") {
										echo "-";
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
										echo "-";
									} else {
										foreach ($hwTypesArray as $str1 => $str2) {
											if ($str1 == $hwType) {
												echo $str2;
											}
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["TAG"] ?></td>
					
					<td id=lblData><?php if ($tag == "") {
										echo "-";
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
										echo "-";
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
										echo "-";
									} else {
										foreach ($entityTypesArray as $str1 => $str2) {
											if ($str1 == $standard) {
												echo $translations["ENTITY_TYPES"][$str1];
											}
										}
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["DELIVERED_TO_REGISTRATION_NUMBER"] ?></td>
					
					<td id=lblData><?php if ($deliveredToRegistrationNumber == "") {
										echo "-";
									} else {
										echo $deliveredToRegistrationNumber;
									} ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["LAST_DELIVERY_DATE"] ?></td>
					
					<td id=lblData><?php if ($lastDeliveryDate == "") {
										echo "-";
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
								echo "-";
							?>
						</label>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["NOTE"] ?></td>
					
					<td id=lblData><?php if ($note == "") {
										echo "-";
									} else {
										echo $note;
									} ?></td>
				</tr>
		</table>
		<table>
			<thead>
				<td colspan=5 id=spacer><?php echo $translations["PERFORMED_MAINTENANCES_TITLE"] ?></td>
				<tr id=headerPreviousMaintenance>
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
					<tr id=bodyPreviousMaintenance>
						<td>
							<label>
								<?php $previousMaintenancesDate = $resultFormatPrevious[$dbMaintenancesArray["PREVIOUS_SERVICE_DATES"]];
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
									if ($resultFormatPrevious[$dbMaintenancesArray["SERVICE_TYPE"]] == $str)
										echo $translations["SERVICE_TYPE"][$str];
								}
								?>
							</label>
						</td>
						<td>
							<label>
								<?php $previousMaintenancesBattery = $resultFormatPrevious[$dbMaintenancesArray["BATTERY_CHANGE"]];
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
								<?php $previousMaintenancesTicket = $resultFormatPrevious[$dbMaintenancesArray["TICKET_NUMBER"]];
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
									if ($resultFormatPrevious[$dbMaintenancesArray["AGENT_ID"]] == $resultUsers["id"]) {
										echo $resultUsers[$dbAgentArray["USERNAME"]];
										$printedMaintenances = true;
										break;
									}
									?>
								</label>
							<?php
							}
							?>
							<label>
								<?php
								if ($printedMaintenances != true)
									echo "-";
								?>
							</label>
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
				<td colspan="3" id=spacer><?php echo $translations["COMPUTER_DATA"] ?></td>
			</thead>
			<tr>
				<td><input type=hidden name=txtServiceDate value="<?php echo $serviceDate; ?>"></td>
			</tr>

			<tr>
				<td id=lblFixed><?php echo $translations["BRAND"] ?></td>
				
				<td id=lblData><?php if ($brand == "") {
									echo "-";
								} else {
									echo $brand;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["MODEL"] ?></td>
				
				<td id=lblData><?php if ($model == "") {
									echo "-";
								} else {
									echo $model;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["SERIAL_NUMBER"] ?></td>
				
				<td id=lblData><?php if ($serialNumber == "") {
									echo "-";
								} else {
									echo $serialNumber;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["PROCESSOR"] ?></td>
				
				<td id=lblData><?php if ($processor == "") {
									echo "-";
								} else {
									echo $processor;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_AMOUNT"] ?></td>
				
				<td id=lblData><?php if ($ramAmount == "") {
									echo "-";
								} else {
									if ($ramAmount / 1024 >= 1024) {
										echo $ramAmount / 1024 / 1024 . " TB";
									} else if ($ramAmount / 1024 < 1024 && $ramAmount / 1024 > 1) {
										echo $ramAmount / 1024 . " GB";
									} else {
										echo $ramAmount . " MB";
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_TYPE"] ?></td>
				
				<td id=lblData><?php if ($ramType == "") {
									echo "-";
								} else {
									foreach ($ramTypesArray as $str1 => $str2) {
										if ($str1 == $ramType) {
											echo $str2;
										}
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_FREQUENCY"] ?></td>
				
				<td id=lblData><?php if ($ramFrequency == "") {
									echo "-";
								} else {
									echo $ramFrequency . " MHz";
								}
								?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["RAM_SLOTS"] ?></td>
				
				<td id=lblData><?php if ($occupiedRamSlots == "" || $totalRamSlots == "") {
									echo "-";
								} else {
									echo $occupiedRamSlots . " / " . $totalRamSlots;
								}
								?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["STORAGE_SIZE"] ?></td>
				
				<td id=lblData><?php if ($storageSize == "") {
									echo "-";
								} else {
									if ($storageSize / 1024 >= 1024) {
										echo $storageSize / 1024 / 1024 . " TB";
									} else if ($storageSize / 1024 < 1024 && $storageSize / 1024 >= 1) {
										echo $storageSize / 1024 . " GB";
									} else {
										echo $storageSize . " MB";
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["STORAGE_TYPE"] ?></td>
				
				<td id=lblData><?php if ($storageType == "") {
									echo "-";
								} else {
									echo $storageType; ?>&nbsp;&nbsp;<a id=linksameline onclick="on()">Detalhes</a>
				<?php
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["MEDIA_OPERATION_MODE"] ?></td>
				
				<td id=lblData><?php if ($mediaOperationMode == "") {
									echo "-";
								} else {
									foreach ($mediaOpTypesArray as $str1 => $str2) {
										if ($str1 == $mediaOperationMode) {
											echo $str2;
										}
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIDEO_CARD"] ?></td>
				
				<td id=lblData><?php if ($videoCard == "") {
									echo "-";
								} else {
									echo $videoCard;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["OPERATING_SYSTEM"] ?></td>
				
				<td id=lblData><?php if ($operatingSystem == "") {
									echo "-";
								} else {
									echo $operatingSystem;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["HOSTNAME"] ?></td>
				
				<td id=lblData><?php if ($hostname == "") {
									echo "-";
								} else {
									echo $hostname;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["MAC_ADDRESS"] ?></td>
				
				<td id=lblData><?php if ($macAddress == "") {
									echo "-";
								} else {
									echo $macAddress;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["IP_ADDRESS"] ?></td>
				
				<td id=lblData><?php if ($ipAddress == "") {
									echo "-";
								} else {
									echo $ipAddress;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["FW_TYPE"] ?></td>
				
				<td id=lblData><?php if ($fwType == "") {
									echo "-";
								} else {
									foreach ($fwTypesArray as $str1 => $str2) {
										if ($str1 == $fwType) {
											echo $str2;
										}
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["FW_VERSION"] ?></td>
				
				<td id=lblData><?php if ($fwVersion == "") {
									echo "-";
								} else {
									echo $fwVersion;
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["SECURE_BOOT"]["NAME"] ?></td>
				
				<td id=lblData><?php if ($secureBoot == "") {
									echo "-";
								} else {
									foreach ($secureBootArray as $str) {
										if ($str == $secureBoot) {
											echo $translations["SECURE_BOOT"][$str];
										}
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></td>
				
				<td id=lblData><?php if ($virtualizationTechnology == "") {
									echo "-";
								} else {
									foreach ($virtualizationTechnologyArray as $str) {
										if ($str == $virtualizationTechnology) {
											echo $translations["VIRTUALIZATION_TECHNOLOGY"][$str];
										}
									}
								} ?></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["TPM_VERSION"] ?></td>
				
				<td id=lblData><?php if ($tpmVersion == "") {
									echo "-";
								} else {
									foreach ($tpmTypesArray as $str1 => $str2) {
										if ($str1 == $tpmVersion) {
											echo $str2;
										}
									}
								} ?></td>
			</tr>

			</tr>
			<?php
			}
			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"] or $_SESSION["privilegeLevel"] == $privilegeLevelsArray["STANDARD_LEVEL"]) {
			?>
				<tr>
					<td colspan=7 align=center><br><input id="updateButton" type=button onclick="location.href='editAsset.php?id=<?php echo $idAsset ?>'" value=<?php echo $translations["LABEL_EDIT_BUTTON"] ?>></td>
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
				<thead id=headerPreviousMaintenance>
					<tr>
						<th>
							Tipo
						</th>
						<th>
							Tamanho
						</th>
						<th>
							Conexão
						</th>
						<th>
							Modelo
						</th>
						<th>
							Número de série
						</th>
						<th>
							S.M.A.R.T.
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($resultStorageList = mysqli_fetch_array($queryStorageList)) {
					?>
						<tr id=bodyPreviousMaintenance>
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
									echo $resultStorageList[$dbStorageListArray["SIZE"]] / 1024 / 1024 . " TB";
								} else if ($resultStorageList[$dbStorageListArray["SIZE"]] / 1024 < 1024 && $resultStorageList[$dbStorageListArray["SIZE"]] / 1024 >= 1) {
									echo $resultStorageList[$dbStorageListArray["SIZE"]] / 1024 . " GB";
								} else {
									echo $resultStorageList[$dbStorageListArray["SIZE"]] . " MB";
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