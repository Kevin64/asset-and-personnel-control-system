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

	$queryAssetLocation = mysqli_query($connection, "select " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["BUILDING"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["DELIVERED_TO_REGISTRATION_NUMBER"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["LAST_DELIVERY_DATE"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["LAST_DELIVERY_MADE_BY"] . ", " . $dbLocationArray["LOCATION_TABLE"] . "." . $dbLocationArray["ROOM_NUMBER"] . " from (select * from " . $dbAssetArray["ASSET_TABLE"] . " where id = '$idAsset') as a inner join " . $dbLocationArray["LOCATION_TABLE"] . " on a." . $dbAssetArray["ASSET_NUMBER"] . " = " . $dbLocationArray["LOCATION_TABLE"] . ".assetNumberFK") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));
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
	$adRegistered = $_POST["txtAdRegistered"];
	$inUse = $_POST["txtInUse"];
	$sealNumber = $_POST["txtSealNumber"];
	$tag = $_POST["txtTag"];

	$building = $_POST["txtBuilding"];
	$roomNumber = $_POST["txtRoomNumber"];

	$query = mysqli_query($connection, "select * from " . $dbAssetArray["ASSET_TABLE"] . " where " . $dbAssetArray["ASSET_NUMBER"] . " = '$assetNumber'") or die($translations["ERROR_SHOW_DETAIL_ASSET"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		$queryAsset = mysqli_query($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER"] . " = '" . $_POST["txtAssetNumber"] . "', " .
			$dbAssetArray["SEAL_NUMBER"] . " = '" . $_POST["txtSealNumber"] . "', " .
			$dbAssetArray["AD_REGISTERED"] . " = '" . $_POST["txtAdRegistered"] . "', " .
			$dbAssetArray["STANDARD"] . " = '" . $_POST["txtStandard"] . "', " .
			$dbAssetArray["DISCARDED"] . " = '" . $_POST["chkBoxDiscard"] . "', " .
			$dbAssetArray["NOTE"] . " = '" . $_POST["txtNote"] . "', " .
			$dbAssetArray["IN_USE"] . " = '" . $_POST["txtInUse"] . "', " .
			$dbAssetArray["TAG"] . " = '" . $_POST["txtTag"] . "'
		where " . $dbAssetArray["ASSET_NUMBER"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetLocation = mysqli_query($connection, "update " . $dbLocationArray["LOCATION_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "', " .
			$dbLocationArray["ROOM_NUMBER"] . " = '" . $_POST["txtRoomNumber"] . "', " .
			$dbLocationArray["BUILDING"] . " = '" . $_POST["txtBuilding"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetFirmware = mysqli_query($connection, "update " . $dbFirmwareArray["FIRMWARE_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetHardware = mysqli_query($connection, "update " . $dbHardwareArray["HARDWARE_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetRam = mysqli_query($connection, "update " . $dbRamArray["RAM_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetStorage = mysqli_query($connection, "update " . $dbStorageArray["STORAGE_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetVideoCard = mysqli_query($connection, "update " . $dbVideoCardArray["VIDEO_CARD_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetMaintenance = mysqli_query($connection, "update " . $dbMaintenanceArray["MAINTENANCE_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetNetwork = mysqli_query($connection, "update " . $dbNetworkArray["NETWORK_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetOperatingSystem = mysqli_query($connection, "update " . $dbOperatingSystemArray["OPERATING_SYSTEM_TABLE"] . " set " .
			$dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtOldAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $assetNumber == $oldAssetNumber) {
		$queryAsset = mysqli_query($connection, "update " . $dbAssetArray["ASSET_TABLE"] . " set " .
			$dbAssetArray["SEAL_NUMBER"] . " = '" . $_POST["txtSealNumber"] . "', " .
			$dbAssetArray["AD_REGISTERED"] . " = '" . $_POST["txtAdRegistered"] . "', " .
			$dbAssetArray["STANDARD"] . " = '" . $_POST["txtStandard"] . "', " .
			$dbAssetArray["DISCARDED"] . " = '" . $discarded . "', " .
			$dbAssetArray["NOTE"] . " = '" . $_POST["txtNote"] . "', " .
			$dbAssetArray["IN_USE"] . " = '" . $_POST["txtInUse"] . "', " .
			$dbAssetArray["TAG"] . " = '" . $_POST["txtTag"] . "'
		where " . $dbAssetArray["ASSET_NUMBER"] . " = '" . $_POST["txtAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));

		$queryAssetLocation = mysqli_query($connection, "update " . $dbLocationArray["LOCATION_TABLE"] . " set " .
			$dbLocationArray["ROOM_NUMBER"] . " = '" . $_POST["txtRoomNumber"] . "', " .
			$dbLocationArray["BUILDING"] . " = '" . $_POST["txtBuilding"] . "'
		where " . $dbAssetArray["ASSET_NUMBER_FK"] . " = '" . $_POST["txtAssetNumber"] . "';
		") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
	}

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
				echo "<label style=color:var(--error-forecolor)>" . $translations["ASSET_ALREADY_EXIST"] . "</label><br><br>";
			} else {
				echo "<label style=color:var(--success-forecolor)>" . $translations["SUCCESS_UPDATE_ASSET_DATA"] . "</label><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
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
					<td id=lblFixed><?php echo $translations["ASSET_NUMBER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdAsset value="<?php echo $idAsset; ?>">
					<input type=hidden name=txtOldAssetNumber value="<?php echo $oldAssetNumber; ?>">
					<td colspan=5><input type=text name=txtAssetNumber placeholder="<?php echo $translations["PLACEHOLDER_ASSET_NUMBER"] ?>" maxlength=<?php echo $assetNumberDigitLimit; ?> required value="<?php echo $assetNumber; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["SEAL_NUMBER"] ?></td>
					<td><input type="text" name="txtSealNumber" maxlength=<?php echo $sealNumberDigitLimit; ?> value="<?php echo $sealNumber; ?>"></td>
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
						<td id=lblFixed><?php echo $translations["BUILDING"] ?><mark id=asterisk>*</mark></td>
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
						<td id=lblFixed><?php echo $translations["ASSET_ROOM"] ?><mark id=asterisk>*</mark></td>
						<td colspan=5><input id="formFields" type=text name=txtRoomNumber placeholder="<?php echo $translations["PLACEHOLDER_ASSET_ROOM_NUMBER"] ?>" maxlength=<?php echo $roomNumberDigitLimit; ?> required value="<?php echo $roomNumber; ?>"></td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td id=lblFixed><?php echo $translations["IN_USE"] ?><mark id=asterisk>*</mark></td>
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
					<td id=lblFixed><?php echo $translations["TAG"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name="txtTag">
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value=1 <?php if ($tag == "1") echo "selected"; ?>><?php echo $translations["YES"] ?></option>
							<option value=0 <?php if ($tag == "0") echo "selected"; ?>><?php echo $translations["NO"] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["AD_REGISTERED"] ?><mark id=asterisk>*</mark></td>
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
					<td id=lblFixed><?php echo $translations["STANDARD"] ?><mark id=asterisk>*</mark></td>
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
			<?php
			}
			?>
			<tr>
				<td id=h-separator colspan=7 align=center><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>