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
	$orderBy = "mainServiceDate";

if (isset($sort) and $sort == "desc") {
	$sort = "asc";
} else {
	$sort = "desc";
}

if ($send != 1) {
	$s = "select ANY_VALUE(t1.id), ANY_VALUE(t1." . $dbAssetArray["ASSET_NUMBER"] . "), ANY_VALUE(t1." . $dbAssetArray["DISCARDED"] . "), ANY_VALUE(t2." . $dbLocationArray["LOC_BUILDING"] . "), ANY_VALUE(t2." . $dbLocationArray["LOC_ROOM_NUMBER"] . "), ANY_VALUE(t1." . $dbAssetArray["STANDARD"] . "), ANY_VALUE(t3." . $dbHardwareArray["HW_BRAND"] . "), ANY_VALUE(t3." . $dbHardwareArray["HW_MODEL"] . "), ANY_VALUE(t4." . $dbNetworkArray["NET_IP_ADDRESS"] . "), ANY_VALUE(t5." . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ")
		from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["DISCARDED"] . " = 0) as t1
			inner join " . $dbLocationArray["LOCATION_TABLE"] . " as t2
			inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " as t3
			inner join " . $dbNetworkArray["NETWORK_TABLE"] . " as t4
			inner join (select distinct * from " . $dbMaintenanceArray["MAINTENANCE_TABLE"] . " order by ANY_VALUE(" . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ") desc) as t5 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t2." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t3." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t4." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t5." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			group by t1." . $dbAssetArray["ASSET_NUMBER"] . "
			order by ANY_VALUE(" . $orderBy . ") " . $sort . ";";
	$queryActive = mysqli_query($connection, $s) or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$queryDiscarded = mysqli_query($connection, "select ANY_VALUE(t1.id), ANY_VALUE(t1." . $dbAssetArray["ASSET_NUMBER"] . "), ANY_VALUE(t1." . $dbAssetArray["DISCARDED"] . "), ANY_VALUE(t2." . $dbLocationArray["LOC_BUILDING"] . "), ANY_VALUE(t2." . $dbLocationArray["LOC_ROOM_NUMBER"] . "), ANY_VALUE(t1." . $dbAssetArray["STANDARD"] . "), ANY_VALUE(t3." . $dbHardwareArray["HW_BRAND"] . "), ANY_VALUE(t3." . $dbHardwareArray["HW_MODEL"] . "), ANY_VALUE(t4." . $dbNetworkArray["NET_IP_ADDRESS"] . "), ANY_VALUE(t5." . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ")
		from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["DISCARDED"] . " = 1) as t1
			inner join " . $dbLocationArray["LOCATION_TABLE"] . " as t2
			inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " as t3
			inner join " . $dbNetworkArray["NETWORK_TABLE"] . " as t4
			inner join (select distinct * from " . $dbMaintenanceArray["MAINTENANCE_TABLE"] . " order by ANY_VALUE(" . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ") desc) as t5 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t2." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t3." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t4." . $dbAssetArray["ASSET_NUMBER_FK"] . " AND
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t5." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			group by t1." . $dbAssetArray["ASSET_NUMBER"] . "
			order by ANY_VALUE(" . $orderBy . ") " . $sort . ";") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$totalActive = mysqli_num_rows($queryActive);
	$totalDiscarded = mysqli_num_rows($queryDiscarded);
} else {
	$s = "select ANY_VALUE(t1.id), ANY_VALUE(t1." . $dbAssetArray["ASSET_NUMBER"] . "), ANY_VALUE(t1." . $dbAssetArray["DISCARDED"] . "), ANY_VALUE(t2." . $dbLocationArray["LOC_BUILDING"] . "), ANY_VALUE(t2." . $dbLocationArray["LOC_ROOM_NUMBER"] . "), ANY_VALUE(t1." . $dbAssetArray["STANDARD"] . "), ANY_VALUE(t3." . $dbHardwareArray["HW_BRAND"] . "), ANY_VALUE(t3." . $dbHardwareArray["HW_MODEL"] . "), ANY_VALUE(t4." . $dbNetworkArray["NET_IP_ADDRESS"] . "), ANY_VALUE(t5." . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ")
		from " . $dbAssetArray["ASSET_TABLE"] . " as t1
			inner join " . $dbLocationArray["LOCATION_TABLE"] . " as t2 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t2." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbHardwareArray["HARDWARE_TABLE"] . " as t3 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t3." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbNetworkArray["NETWORK_TABLE"] . " as t4 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t4." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join (select distinct * from " . $dbMaintenanceArray["MAINTENANCE_TABLE"] . " order by ANY_VALUE(" . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ") desc) as t5 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t5." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbFirmwareArray["FIRMWARE_TABLE"] . " as t6 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t6." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " as t7 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t7." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbProcessorArray["PROCESSOR_TABLE"] . " as t8 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t8." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbRamArray["RAM_TABLE"] . " as t9 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t9." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbStorageArray["STORAGE_TABLE"] . " as t10 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t10." . $dbAssetArray["ASSET_NUMBER_FK"] . "
			inner join " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " as t11 on
				t1." . $dbAssetArray["ASSET_NUMBER"] . " = t11." . $dbAssetArray["ASSET_NUMBER_FK"] . "
		where $rdCriterion like '%$search%'
			group by t1." . $dbAssetArray["ASSET_NUMBER"] . "
			order by ANY_VALUE(" . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ") desc;";
	$querySearch = mysqli_query($connection, $s) or die($translations["ERROR_QUERY"] . mysqli_error($connection));

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
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbLocationArray["LOC_ROOM_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbLocationArray["LOC_ROOM_NUMBER"] ?>"><?php echo $translations["ASSET_ROOM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbLocationArray["LOC_BUILDING"]) echo "selected='selected'"; ?>value="<?php echo $dbLocationArray["LOC_BUILDING"] ?>"><?php echo $translations["BUILDING"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["AD_REGISTERED"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["AD_REGISTERED"] ?>"><?php echo $translations["AD_REGISTERED"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["STANDARD"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["STANDARD"] ?>"><?php echo $translations["STANDARD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbMaintenanceArray["MAIN_SERVICE_DATE"]) echo "selected='selected'"; ?>value="<?php echo $dbMaintenanceArray["MAIN_SERVICE_DATE"] ?>"><?php echo $translations["LAST_MAINTENANCE_DATE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["HW_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["HW_TYPE"] ?>"><?php echo $translations["HW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["HW_BRAND"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["HW_BRAND"] ?>"><?php echo $translations["BRAND"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["HW_MODEL"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["HW_MODEL"] ?>"><?php echo $translations["MODEL"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbHardwareArray["HW_SERIAL_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbHardwareArray["HW_SERIAL_NUMBER"] ?>"><?php echo $translations["SERIAL_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbProcessorArray["PROC_NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbProcessorArray["PROC_NAME"] ?>"><?php echo $translations["PROCESSOR"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbRamArray["RAM_AMOUNT"]) echo "selected='selected'"; ?>value="<?php echo $dbRamArray["RAM_AMOUNT"] ?>"><?php echo $translations["RAM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbStorageArray["STOR_SIZE"]) echo "selected='selected'"; ?>value="<?php echo $dbStorageArray["STOR_SIZE"] ?>"><?php echo $translations["STORAGE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbVideoCardArray["VC_NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbVideoCardArray["VC_NAME"] ?>"><?php echo $translations["VIDEO_CARD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbOperatingSystemArray["OS_NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbOperatingSystemArray["OS_NAME"] ?>"><?php echo $translations["OPERATING_SYSTEM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbNetworkArray["NET_HOSTNAME"]) echo "selected='selected'"; ?>value="<?php echo $dbNetworkArray["NET_HOSTNAME"] ?>"><?php echo $translations["HOSTNAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbNetworkArray["NET_MAC_ADDRESS"]) echo "selected='selected'"; ?>value="<?php echo $dbNetworkArray["NET_MAC_ADDRESS"] ?>"><?php echo $translations["MAC_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbNetworkArray["NET_IP_ADDRESS"]) echo "selected='selected'"; ?>value="<?php echo $dbNetworkArray["NET_IP_ADDRESS"] ?>"><?php echo $translations["IP_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["FW_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["FW_VERSION"] ?>"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["FW_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["FW_TYPE"] ?>"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["FW_MEDIA_OPERATION_MODE"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["FW_MEDIA_OPERATION_MODE"] ?>"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["FW_SECURE_BOOT"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["FW_SECURE_BOOT"] ?>"><?php echo $translations["SECURE_BOOT"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["FW_VIRTUALIZATION_TECHNOLOGY"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["FW_VIRTUALIZATION_TECHNOLOGY"] ?>"><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbFirmwareArray["FW_TPM_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbFirmwareArray["FW_TPM_VERSION"] ?>"><?php echo $translations["TPM_VERSION"] ?></option>
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
				<th><a href="?orderBy=<?php echo $dbAssetArray["ASSET_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_ASSET_NUMBER"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbLocationArray["LOC_BUILDING"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BUILDING"] ?></a></th>
				<?php
				}
				?>
				<th><a href="?orderBy=<?php echo $dbLocationArray["LOC_ROOM_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["ASSET_ROOM"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbAssetArray["STANDARD"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["STANDARD"] ?></a></th>
					<th><a href="?orderBy=<?php echo $dbHardwareArray["HW_BRAND"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></th>
				<?php
				}
				?>
				<th><a href="?orderBy=<?php echo $dbHardwareArray["HW_MODEL"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
				<th><a href="?orderBy=<?php echo $dbNetworkArray["NET_IP_ADDRESS"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["IP_ADDRESS"] ?></a></th>
			<?php
					}
			?>
			<th><a href="?orderBy=<?php echo $dbMaintenanceArray["MAIN_SERVICE_DATE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_LAST_MAINTENANCE_DATE"] ?></a></th>
			</thead>
			<tbody>
				<?php
				while ($result = mysqli_fetch_array($queryActive)) {
					$idAsset = $result["ANY_VALUE(t1.id)"];
					$assetNumber = $result["ANY_VALUE(t1." . $dbAssetArray["ASSET_NUMBER"] . ")"];
					$discarded = $result["ANY_VALUE(t1." . $dbAssetArray["DISCARDED"] . ")"];
					$building = $result["ANY_VALUE(t2." . $dbLocationArray["LOC_BUILDING"] . ")"];
					$roomNumber = $result["ANY_VALUE(t2." . $dbLocationArray["LOC_ROOM_NUMBER"] . ")"];
					$standard = $result["ANY_VALUE(t1." . $dbAssetArray["STANDARD"] . ")"];
					$brand = $result["ANY_VALUE(t3." . $dbHardwareArray["HW_BRAND"] . ")"];
					$model = $result["ANY_VALUE(t3." . $dbHardwareArray["HW_MODEL"] . ")"];
					$ipAddress = $result["ANY_VALUE(t4." . $dbNetworkArray["NET_IP_ADDRESS"] . ")"];
					$serviceDate = $result["ANY_VALUE(t5." . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ")"];

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
						$idAsset = $result["ANY_VALUE(t1.id)"];
						$assetNumber = $result["ANY_VALUE(t1." . $dbAssetArray["ASSET_NUMBER"] . ")"];
						$discarded = $result["ANY_VALUE(t1." . $dbAssetArray["DISCARDED"] . ")"];
						$building = $result["ANY_VALUE(t2." . $dbLocationArray["LOC_BUILDING"] . ")"];
						$roomNumber = $result["ANY_VALUE(t2." . $dbLocationArray["LOC_ROOM_NUMBER"] . ")"];
						$standard = $result["ANY_VALUE(t1." . $dbAssetArray["STANDARD"] . ")"];
						$brand = $result["ANY_VALUE(t3." . $dbHardwareArray["HW_BRAND"] . ")"];
						$model = $result["ANY_VALUE(t3." . $dbHardwareArray["HW_MODEL"] . ")"];
						$ipAddress = $result["ANY_VALUE(t4." . $dbNetworkArray["NET_IP_ADDRESS"] . ")"];
						$serviceDate = $result["ANY_VALUE(t5." . $dbMaintenanceArray["MAIN_SERVICE_DATE"] . ")"];

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