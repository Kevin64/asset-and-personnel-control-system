<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$orderBy = null;
$rdCriterion = null;
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
	$queryActive = mysqli_query($connection, "select * from (select * from " . $dbAssetArray["ASSET_TABLE"] . " order by $orderBy $sort) T where " . $dbAssetArray["DISCARDED"] . " = 0") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryDiscarded = mysqli_query($connection, "select * from (select * from " . $dbAssetArray["ASSET_TABLE"] . " order by $orderBy $sort) T where " . $dbAssetArray["DISCARDED"] . " = 1") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));

	$totalActive = mysqli_num_rows($queryActive);
	$totalDiscarded = mysqli_num_rows($queryDiscarded);
} else {
	$querySearch = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
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
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["ROOM_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["ROOM_NUMBER"] ?>"><?php echo $translations["ASSET_ROOM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["BUILDING"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["BUILDING"] ?>"><?php echo $translations["BUILDING"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["AD_REGISTERED"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["AD_REGISTERED"] ?>"><?php echo $translations["AD_REGISTERED"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["STANDARD"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["STANDARD"] ?>"><?php echo $translations["STANDARD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["SERVICE_DATE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["SERVICE_DATE"] ?>"><?php echo $translations["LAST_MAINTENANCE_DATE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["BRAND"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["BRAND"] ?>"><?php echo $translations["BRAND"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["MODEL"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["MODEL"] ?>"><?php echo $translations["MODEL"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["SERIAL_NUMBER"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["SERIAL_NUMBER"] ?>"><?php echo $translations["SERIAL_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["PROCESSOR"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["PROCESSOR"] ?>"><?php echo $translations["PROCESSOR"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["RAM_AMOUNT"] ?>"><?php echo $translations["RAM_AMOUNT"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["RAM_TYPE"] ?>"><?php echo $translations["RAM_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["RAM_FREQUENCY"] ?>"><?php echo $translations["RAM_FREQUENCY"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["STORAGE_SIZE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["STORAGE_SIZE"] ?>"><?php echo $translations["STORAGE_SIZE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["OPERATING_SYSTEM_NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["OPERATING_SYSTEM_NAME"] ?>"><?php echo $translations["OPERATING_SYSTEM_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["OPERATING_SYSTEM_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["OPERATING_SYSTEM_VERSION"] ?>"><?php echo $translations["OPERATING_SYSTEM_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["OPERATING_SYSTEM_BUILD"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["OPERATING_SYSTEM_BUILD"] ?>"><?php echo $translations["OPERATING_SYSTEM_BUILD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["OPERATING_SYSTEM_ARCH"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["OPERATING_SYSTEM_ARCH"] ?>"><?php echo $translations["OPERATING_SYSTEM_ARCH"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["HOSTNAME"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["HOSTNAME"] ?>"><?php echo $translations["HOSTNAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["MAC_ADDRESS"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["MAC_ADDRESS"] ?>"><?php echo $translations["MAC_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["IP_ADDRESS"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["IP_ADDRESS"] ?>"><?php echo $translations["IP_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["FW_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["FW_VERSION"] ?>"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["HW_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["HW_TYPE"] ?>"><?php echo $translations["HW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["FW_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["FW_TYPE"] ?>"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["STORAGE_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["STORAGE_TYPE"] ?>"><?php echo $translations["STORAGE_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["VIDEO_CARD_NAME"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["VIDEO_CARD_NAME"] ?>"><?php echo $translations["VIDEO_CARD_NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["MEDIA_OPERATION_MODE"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["MEDIA_OPERATION_MODE"] ?>"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["SECURE_BOOT"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["SECURE_BOOT"] ?>"><?php echo $translations["SECURE_BOOT"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["VIRTUALIZATION_TECHNOLOGY"] ?>"><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbAssetArray["TPM_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbAssetArray["TPM_VERSION"] ?>"><?php echo $translations["TPM_VERSION"] ?></option>
					</select>
					<input style="width:335px" type=text name=txtSearch>
					<input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</table>
	</form>
	<br><br>
	<?php
	if (!isset($totalSearch)) {
	?>
		<h3><?php echo $translations["ASSET_ACTIVE"] ?> (<?php echo $totalActive; ?>)</h3>
		<h3><?php echo $translations["ASSETS_DISCARDED"] ?> (<?php echo $totalDiscarded; ?>)</h3><br>
	<?php
	} else {
		$queryActive = $querySearch;
	?>
		<h3><?php echo $translations["RESULTING_ASSETS"] ?> (<?php echo $totalSearch; ?>)</h3><br>
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
					<th><a href="?orderBy=<?php echo $dbAssetArray["BUILDING"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BUILDING"] ?></a></th>
				<?php
				}
				?>
				<th><a href="?orderBy=<?php echo $dbAssetArray["ROOM_NUMBER"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["ASSET_ROOM"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbAssetArray["STANDARD"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["STANDARD"] ?></a></th>
					<th><a href="?orderBy=<?php echo $dbAssetArray["BRAND"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></th>
				<?php
				}
				?>
				<th><a href="?orderBy=<?php echo $dbAssetArray["MODEL"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></td>
					<?php
					if (!in_array(true, $devices)) {
					?>
				<th><a href="?orderBy=<?php echo $dbAssetArray["IP_ADDRESS"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["IP_ADDRESS"] ?></a></th>
			<?php
					}
			?>
			<th><a href="?orderBy=<?php echo $dbAssetArray["SERVICE_DATE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_LAST_MAINTENANCE_DATE"] ?></a></th>
			</thead>
			<tbody>
				<?php
				while ($result = mysqli_fetch_array($queryActive)) {
					$idAsset = $result["id"];
					$assetNumber = $result[$dbAssetArray["ASSET_NUMBER"]];
					$discarded = $result[$dbAssetArray["DISCARDED"]];
					$building = $result[$dbAssetArray["BUILDING"]];
					$roomNumber = $result[$dbAssetArray["ROOM_NUMBER"]];
					$standard = $result[$dbAssetArray["STANDARD"]];
					$brand = $result[$dbAssetArray["BRAND"]];
					$model = $result[$dbAssetArray["MODEL"]];
					$inUse = $result[$dbAssetArray["IN_USE"]];
					$serviceDate = $result[$dbAssetArray["SERVICE_DATE"]];
					$ipAddress = $result[$dbAssetArray["IP_ADDRESS"]];

					if ($inUse == "0") {
						$color = $colorArray["NOT_IN_USE"];
					} else {
						$color = $colorArray["IN_USE"];
					}

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
						<td><a href="formDetailAsset.php?id=<?php echo $idAsset; ?>" <?php if ($discarded == 1) { ?> id=inactive <?php } else { ?> style="color: <?php echo $color;
																																								} ?>"><?php echo $assetNumber; ?></a></td>
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
						$building = $result[$dbAssetArray["BUILDING"]];
						$roomNumber = $result[$dbAssetArray["ROOM_NUMBER"]];
						$standard = $result[$dbAssetArray["STANDARD"]];
						$brand = $result[$dbAssetArray["BRAND"]];
						$model = $result[$dbAssetArray["MODEL"]];
						$inUse = $result[$dbAssetArray["IN_USE"]];
						$serviceDate = $result[$dbAssetArray["SERVICE_DATE"]];
						$ipAddress = $result[$dbAssetArray["IP_ADDRESS"]];

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
							<td><a href="formDetailAsset.php?id=<?php echo $idAsset; ?>" <?php if ($discarded == 1) { ?> id=inactive <?php } else { ?> style="color: <?php echo $color;
																																									} ?>"><?php echo $assetNumber; ?></a></td>
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