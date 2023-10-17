<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$orderBy = null;
$rdCriterion = null;
$rdCriterionTable = null;
$search = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if (isset($_GET["orderBy"]))
	$orderBy = $_GET["orderBy"];

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

if (isset($_POST["rdCriterion"]))
	$rdCriterion = $_POST["rdCriterion"];

if (isset($_POST["txtSearch"]))
	$search = $_POST["txtSearch"];

if (isset($_POST["radioSearch"]))
	$search = $_POST["radioSearch"];

if ($orderBy == "")
	$orderBy = "serviceDate";

if (isset($sort) and $sort == "desc") {
	$sort = "asc";
} else {
	$sort = "desc";
}

if ($send != 1) {
	$queryActive = mysqli_query($connection, "select t1.id, t1." . $dbAssetArray["ASSET_NUMBER"] . ", t1." . $dbAssetArray["DISCARDED"] . ", t2." . $dbLocationArray["BUILDING"] . ", t2." . $dbLocationArray["ROOM_NUMBER"] . ", t1." . $dbAssetArray["STANDARD"] . ", t3." . $dbHardwareArray["BRAND"] . ", t3." . $dbHardwareArray["MODEL"] . ", t4." . $dbNetworkArray["IP_ADDRESS"] . ", t5." . $dbMaintenanceArray["SERVICE_DATE"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["DISCARDED"] . " = 0) as t1 inner join " . $dbLocationArray["LOCATION_TABLE"] . " as t2 inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " as t3 inner join " . $dbNetworkArray["NETWORK_TABLE"] . " as t4 inner join " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " as t5 on t1." . $dbAssetArray["ASSET_NUMBER"] . " = t2." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t3." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t4." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t5." . $dbAssetArray["ASSET_NUMBER_FK"] . " group by t1." . $dbAssetArray["ASSET_NUMBER"] . ";") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryDiscarded = mysqli_query($connection, "select t1.id, t1." . $dbAssetArray["ASSET_NUMBER"] . ", t1." . $dbAssetArray["DISCARDED"] . ", t2." . $dbLocationArray["BUILDING"] . ", t2." . $dbLocationArray["ROOM_NUMBER"] . ", t1." . $dbAssetArray["STANDARD"] . ", t3." . $dbHardwareArray["BRAND"] . ", t3." . $dbHardwareArray["MODEL"] . ", t4." . $dbNetworkArray["IP_ADDRESS"] . ", t5." . $dbMaintenanceArray["SERVICE_DATE"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["DISCARDED"] . " = 1) as t1 inner join " . $dbLocationArray["LOCATION_TABLE"] . " as t2 inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " as t3 inner join " . $dbNetworkArray["NETWORK_TABLE"] . " as t4 inner join " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " as t5 on t1." . $dbAssetArray["ASSET_NUMBER"] . " = t2." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t3." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t4." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t5." . $dbAssetArray["ASSET_NUMBER_FK"] . " group by t1." . $dbAssetArray["ASSET_NUMBER"] . ";") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$totalActive = mysqli_num_rows($queryActive);
	$totalDiscarded = mysqli_num_rows($queryDiscarded);
} else {
	if($_POST["rdCriterion"] == $dbAssetArray["ASSET_NUMBER"] || $_POST["rdCriterion"] == $dbAssetArray["DISCARDED"] || $_POST["rdCriterion"] == $dbAssetArray["STANDARD"] || $_POST["rdCriterion"] == $dbAssetArray["AD_REGISTERED"] || $_POST["rdCriterion"] == $dbAssetArray["IN_USE"] || $_POST["rdCriterion"] == $dbAssetArray["SEAL_NUMBER"] || $_POST["rdCriterion"] == $dbAssetArray["TAG"] || $_POST["rdCriterion"] == $dbAssetArray["NOTE"]) {
		$tableChoice = "(select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbFirmwareArray["TYPE"] ||  $_POST["rdCriterion"] == $dbFirmwareArray["VERSION"] || $_POST["rdCriterion"] == $dbFirmwareArray["MEDIA_OPERATION_MODE"] || $_POST["rdCriterion"] == $dbFirmwareArray["SECURE_BOOT"] || $_POST["rdCriterion"] == $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] || $_POST["rdCriterion"] == $dbFirmwareArray["TPM_VERSION"]) {
		$tableChoice = "(select * from " . $dbFirmwareArray["FIRMWARE_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbHardwareArray["BRAND"] || $_POST["rdCriterion"] == $dbHardwareArray["TYPE"] || $_POST["rdCriterion"] == $dbHardwareArray["MODEL"] || $_POST["rdCriterion"] == $dbHardwareArray["PROCESSOR"] || $_POST["rdCriterion"] == $dbHardwareArray["SERIAL_NUMBER"]) {
		$tableChoice = "(select * from " . $dbHardwareArray["HARDWARE_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbRamArray["AMOUNT"] || $_POST["rdCriterion"] == $dbRamArray["TYPE"] || $_POST["rdCriterion"] == $dbRamArray["FREQUENCY"] || $_POST["rdCriterion"] == $dbRamArray["OCCUPIED_SLOTS"] || $_POST["rdCriterion"] == $dbRamArray["TOTAL_SLOTS"]) {
		$tableChoice = "(select * from " . $dbRamArray["RAM_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbStorageArray["STORAGE_ID"] || $_POST["rdCriterion"] == $dbStorageArray["TYPE"] || $_POST["rdCriterion"] == $dbStorageArray["SIZE"] || $_POST["rdCriterion"] == $dbStorageArray["CONNECTION"] || $_POST["rdCriterion"] == $dbStorageArray["MODEL"] || $_POST["rdCriterion"] == $dbStorageArray["SERIAL_NUMBER"] || $_POST["rdCriterion"] == $dbStorageArray["SMART_STATUS"]) {
		$tableChoice = "(select * from " . $dbStorageArray["STORAGE_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbVideoCardArray["RAM"] || $_POST["rdCriterion"] == $dbVideoCardArray["NAME"] || $_POST["rdCriterion"] == $dbVideoCardArray["GPU_ID"]) {
		$tableChoice = "(select * from " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbLocationArray["BUILDING"] || $_POST["rdCriterion"] == $dbLocationArray["ROOM_NUMBER"] || $_POST["rdCriterion"] == $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] || $_POST["rdCriterion"] == $dbLocationArray["LAST_DELIVERY_MADE_BY"] || $_POST["rdCriterion"] == $dbLocationArray["LAST_DELIVERY_DATE"]) {
		$tableChoice = "(select * from " . $dbLocationArray["LOCATION_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbMaintenanceArray["SERVICE_DATE"] || $_POST["rdCriterion"] == $dbMaintenanceArray["SERVICE_TYPE"] || $_POST["rdCriterion"] == $dbMaintenanceArray["BATTERY_CHANGE"] || $_POST["rdCriterion"] == $dbMaintenanceArray["TICKET_NUMBER"] || $_POST["rdCriterion"] == $dbMaintenanceArray["AGENT_ID"]) {
		$tableChoice = "(select * from " . $dbMaintenanceArray["MAINTENANCE_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbNetworkArray["MAC_ADDRESS"] || $_POST["rdCriterion"] == $dbNetworkArray["IP_ADDRESS"] || $_POST["rdCriterion"] == $dbNetworkArray["HOSTNAME"]) {
		$tableChoice = "(select * from " . $dbNetworkArray["NETWORK_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}
	else if($_POST["rdCriterion"] == $dbOperatingSystemArray["NAME"] || $_POST["rdCriterion"] == $dbOperatingSystemArray["VERSION"] || $_POST["rdCriterion"] == $dbOperatingSystemArray["BUILD"] || $_POST["rdCriterion"] == $dbOperatingSystemArray["ARCH"]) {
		$tableChoice = "(select * from " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " where " . $rdCriterion . " like '%$search%')";
	}

	$querySearch = mysqli_query($connection, "select t1.id, t1." . $dbAssetArray["ASSET_NUMBER"] . ", t1." . $dbAssetArray["DISCARDED"] . ", t2." . $dbLocationArray["BUILDING"] . ", t2." . $dbLocationArray["ROOM_NUMBER"] . ", t1." . $dbAssetArray["STANDARD"] . ", t3." . $dbHardwareArray["BRAND"] . ", t3." . $dbHardwareArray["MODEL"] . ", t4." . $dbNetworkArray["IP_ADDRESS"] . ", t5." . $dbMaintenanceArray["SERVICE_DATE"] . " from " . $tableChoice . " as t1 inner join " . $dbLocationArray["LOCATION_TABLE"] . " as t2 inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " as t3 inner join " . $dbNetworkArray["NETWORK_TABLE"] . " as t4 inner join " . $dbMaintenanceArray["MAINTENANCES_TABLE"] . " as t5 on t1." . $dbAssetArray["ASSET_NUMBER"] . " = t2." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t3." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t4." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND t1." . $dbAssetArray["ASSET_NUMBER"] . " = t5." . $dbAssetArray["ASSET_NUMBER_FK"] . " group by t1." . $dbAssetArray["ASSET_NUMBER"] . ";") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	
	$totalSearch = mysqli_num_rows($querySearch);
}

?>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/show-controls.js"></script>
<div id="middle">
	<form action=queryAsset.php method=post onsubmit='return getOption();'>
		<table id="tbSearch" cellspacing=0>
			<input type=hidden name=txtSend value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td id=testRadioInput align=center>
					<select id=filterAsset name=rdCriterion>
						<!-- <select id=filterAsset name=rdCriterion onchange='f(document.getElementById("filterAsset").selectedIndex, <?php echo json_encode($tpmTypesArray) ?>)'> -->
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["ASSET_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["ASSET_NUMBER"] ?>"><?php echo $translations["ASSET_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["DISCARDED"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["DISCARDED"] ?>"><?php echo $translations["ASSETS_DISCARDED_STATUS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["SEAL_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["SEAL_NUMBER"] ?>"><?php echo $translations["SEAL_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbLocationArray["ROOM_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbLocationArray["ROOM_NUMBER"] ?>"><?php echo $translations["ASSET_ROOM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbLocationArray["BUILDING"]) echo "selected='selected'"; ?>value="<?php echo $dbLocationArray["BUILDING"] ?>"><?php echo $translations["BUILDING"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["AD_REGISTERED"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["AD_REGISTERED"] ?>"><?php echo $translations["AD_REGISTERED"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["STANDARD"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["STANDARD"] ?>"><?php echo $translations["STANDARD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbMaintenanceArray["SERVICE_DATE"]) echo "selected='selected'"; ?>value="<?php echo $dbMaintenanceArray["SERVICE_DATE"] ?>"><?php echo $translations["LAST_MAINTENANCE_DATE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["BRAND"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["BRAND"] ?>"><?php echo $translations["BRAND"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["MODEL"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["MODEL"] ?>"><?php echo $translations["MODEL"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["SERIAL_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["SERIAL_NUMBER"] ?>"><?php echo $translations["SERIAL_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbProcessorArray["NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbProcessorArray["NAME"] ?>"><?php echo $translations["PROCESSOR"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="<?php echo $dbRamArray["AMOUNT"] ?>"><?php echo $translations["RAM_AMOUNT"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="<?php echo $dbRamArray["TYPE"] ?>"><?php echo $translations["RAM_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="<?php echo $dbRamArray["FREQUENCY"] ?>"><?php echo $translations["RAM_FREQUENCY"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["STORAGE_TOTAL_SIZE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["STORAGE_TOTAL_SIZE"] ?>"><?php echo $translations["STORAGE_TOTAL_SIZE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbOperatingSystemArray["NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbOperatingSystemArray["NAME"] ?>"><?php echo $translations["OPERATING_SYSTEM_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbOperatingSystemArray["VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbOperatingSystemArray["VERSION"] ?>"><?php echo $translations["OPERATING_SYSTEM_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbOperatingSystemArray["BUILD"]) echo "selected='selected'"; ?>value="<?php echo $dbOperatingSystemArray["BUILD"] ?>"><?php echo $translations["OPERATING_SYSTEM_BUILD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbOperatingSystemArray["ARCH"]) echo "selected='selected'"; ?>value="<?php echo $dbOperatingSystemArray["ARCH"] ?>"><?php echo $translations["OPERATING_SYSTEM_ARCH"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbNetworkArray["HOSTNAME"]) echo "selected='selected'"; ?>value="<?php echo $dbNetworkArray["HOSTNAME"] ?>"><?php echo $translations["HOSTNAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbNetworkArray["MAC_ADDRESS"]) echo "selected='selected'"; ?>value="<?php echo $dbNetworkArray["MAC_ADDRESS"] ?>"><?php echo $translations["MAC_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbNetworkArray["IP_ADDRESS"]) echo "selected='selected'"; ?>value="<?php echo $dbNetworkArray["IP_ADDRESS"] ?>"><?php echo $translations["IP_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["VERSION"] ?>"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["TYPE"] ?>"><?php echo $translations["HW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["TYPE"] ?>"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbVideoCardArray["NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbVideoCardArray["NAME"] ?>"><?php echo $translations["VIDEO_CARD_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["MEDIA_OPERATION_MODE"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["MEDIA_OPERATION_MODE"] ?>"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["SECURE_BOOT"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["SECURE_BOOT"] ?>"><?php echo $translations["SECURE_BOOT"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["VIRTUALIZATION_TECHNOLOGY"] ?>"><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["TPM_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["TPM_VERSION"] ?>"><?php echo $translations["TPM_VERSION"] ?></option>
					</select>
					<input style="width:335px" type=text name=txtSearch>
					<input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</table>
	</form>
	<br>
	<?php
	if (!isset($totalSearch)) {
	?>
		<h2><?php echo $translations["ASSET_ACTIVE"] ?> (<?php echo $totalActive; ?>)</h2>
		<h2><?php echo $translations["ASSETS_DISCARDED"] ?> (<?php echo $totalDiscarded; ?>)</h2><br>
	<?php
	} else {
		$queryActive = $querySearch;
	?>
		<h2><?php echo $translations["RESULTING_ASSETS"] ?> (<?php echo $totalSearch; ?>)</h2><br>
	<?php
	}
	?>
	<form action="eraseSelectedAsset.php" method="post">
		<table id="assetData" cellspacing=1>
			<thead id="header_">
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<th><img src="<?php echo $imgArray["TRASH"] ?>" width="22" height="29"></th>
				<?php
					}
				}
				?>
				<th><a href="?orderBy=<?php echo $dbAssetArray["ASSET_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_ASSET"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbLocationArray["BUILDING"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BUILDING"] ?></a></th>
				<?php
				}
				?>
				<th><a href="?orderBy=<?php echo $dbLocationArray["ROOM_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["ASSET_ROOM"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbAssetArray["STANDARD"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["STANDARD"] ?></a></th>
					<th><a href="?orderBy=<?php echo $dbHardwareArray["BRAND"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></th>
				<?php
				}
				?>
				<th><a href="?orderBy=<?php echo $dbHardwareArray["MODEL"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
				<th><a href="?orderBy=<?php echo $dbNetworkArray["IP_ADDRESS"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["IP_ADDRESS"] ?></a></th>
			<?php
					}
			?>
			<th><a href="?orderBy=<?php echo $dbMaintenanceArray["SERVICE_DATE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_LAST_MAINTENANCE_DATE"] ?></a></th>
			</thead>
			<tbody>
				<?php
				while ($result = mysqli_fetch_array($queryActive)) {
					$idAsset = $result["id"];
					$assetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
					$discarded = $result[$dbAssetArray["DISCARDED"]];
					$building = $result[$dbLocationArray["BUILDING"]];
					$roomNumber = $result[$dbLocationArray["ROOM_NUMBER"]];
					$standard = $result[$dbAssetArray["STANDARD"]];
					$brand = $result[$dbHardwareArray["BRAND"]];
					$model = $result[$dbHardwareArray["MODEL"]];
					$ipAddress = $result[$dbNetworkArray["IP_ADDRESS"]];
					$serviceDate = $result[$dbMaintenanceArray["SERVICE_DATE"]];

					$formatDate = substr($serviceDate, 0, 10);
					$explodedDate = explode("-", $formatDate);
					if ($explodedDate[0] != "")
						$serviceDate = $explodedDate[2] . "/" . $explodedDate[1] . "/" . $explodedDate[0];
				?>
					<tr id=tableList>
						<?php
						if (isset($_SESSION["privilegeLevel"])) {
							if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
						?>
								<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idAsset; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}" <?php if ($discarded == 1) { ?> disabled <?php } ?>></td>
						<?php
							}
						}
						?>
						<td><a href="formDetailAsset.php?id=<?php echo $idAsset; ?>" <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $assetNumber; ?></a></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $buildingArray[$building]; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $roomNumber; ?></label></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $translations["ENTITY_TYPES"][$standard] ?></label></td>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $brand; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $model; ?></label></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $ipAddress; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $serviceDate; ?></label></td>
					</tr>
					<?php
				}
				if (!isset($totalSearch)) {
					while ($result = mysqli_fetch_array($queryDiscarded)) {
						$idAsset = $result["id"];
						$assetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
						$discarded = $result[$dbAssetArray["DISCARDED"]];
						$building = $result[$dbLocationArray["BUILDING"]];
						$roomNumber = $result[$dbLocationArray["ROOM_NUMBER"]];
						$standard = $result[$dbAssetArray["STANDARD"]];
						$brand = $result[$dbHardwareArray["BRAND"]];
						$model = $result[$dbHardwareArray["MODEL"]];
						$serviceDate = $result[$dbMaintenanceArray["SERVICE_DATE"]];
						$ipAddress = $result[$dbNetworkArray["IP_ADDRESS"]];

						$formatDate = substr($serviceDate, 0, 10);
						$explodedDate = explode("-", $formatDate);
						if ($explodedDate[0] != "")
							$serviceDate = $explodedDate[2] . "/" . $explodedDate[1] . "/" . $explodedDate[0];
					?>
						<tr id=tableList>
							<?php
							if (isset($_SESSION["privilegeLevel"])) {
								if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
							?>
									<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idAsset; ?>" onclick="var input = document.getElementById(" eraseButton"); if(this.checked){ input.disabled=false;}else{input.disabled=true;}" <?php if ($discarded == 1) { ?> disabled <?php } ?>></td>
							<?php
								}
							}
							?>
							<td><a href="formDetailAsset.php?id=<?php echo $idAsset; ?>" <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $assetNumber; ?></a></td>
							<?php
							if (!in_array(true, $devices)) {
							?>
								<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $buildingArray[$building]; ?></label></td>
							<?php
							}
							?>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $roomNumber; ?></label></td>
							<?php
							if (!in_array(true, $devices)) {
							?>
								<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $translations["ENTITY_TYPES"][$standard] ?></label></td>
								<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $brand; ?></label></td>
							<?php
							}
							?>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $model; ?></label></td>
							<?php
							if (!in_array(true, $devices)) {
							?>
								<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $ipAddress; ?></label></td>
							<?php
							}
							?>
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $serviceDate; ?></label></td>
						</tr>
			</tbody>
		<?php
					}
				}
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
		?>
			<tr>
				<td id=h-separator colspan=9 align="center"><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
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