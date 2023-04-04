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

if ($orderBy == "")
	$orderBy = "serviceDate";

if (isset($sort) and $sort == "desc") {
	$sort = "asc";
} else {
	$sort = "desc";
}

if ($send != 1) {
	$queryActive = mysqli_query($connection, "select * from (select * from asset order by $orderBy $sort) T where discarded = 0") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));
	$queryDiscarded = mysqli_query($connection, "select * from (select * from asset order by $orderBy $sort) T where discarded = 1") or die($translations["ERROR_QUERY_ASSET"] . mysqli_error($connection));

	$totalActive = mysqli_num_rows($queryActive);
	$totalDiscarded = mysqli_num_rows($queryDiscarded);
} else {
	$querySearch = mysqli_query($connection, "select * from asset where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$totalSearch = mysqli_num_rows($querySearch);
}

?>

<div id="middle">
	<table id="tbSearch">
		<form action=queryAsset.php method=post>
			<input type=hidden name=txtSend value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterAsset name=rdCriterion>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "asset") echo "selected='selected'"; ?>value="assetNumber"><?php echo $translations["ASSETS_ACTIVE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "discarded") echo "selected='selected'"; ?>value="discarded"><?php echo $translations["ASSETS_DISCARDED"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "sealNumber") echo "selected='selected'"; ?>value="sealNumber"><?php echo $translations["SEAL_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "room") echo "selected='selected'"; ?>value="room"><?php echo $translations["ASSET_ROOM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "building") echo "selected='selected'"; ?>value="building"><?php echo $translations["BUILDING"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "adRegistered") echo "selected='selected'"; ?>value="adRegistered"><?php echo $translations["AD_REGISTERED"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "standard") echo "selected='selected'"; ?>value="standard"><?php echo $translations["STANDARD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "serviceDate") echo "selected='selected'"; ?>value="serviceDate"><?php echo $translations["LAST_MAINTENANCE_DATE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "brand") echo "selected='selected'"; ?>value="brand"><?php echo $translations["BRAND"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "model") echo "selected='selected'"; ?>value="model"><?php echo $translations["MODEL"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "serialNumber") echo "selected='selected'"; ?>value="serialNumber"><?php echo $translations["SERIAL_NUMBER"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "processor") echo "selected='selected'"; ?>value="processor"><?php echo $translations["PROCESSOR"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ram") echo "selected='selected'"; ?>value="ram"><?php echo $translations["RAM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "storageSize") echo "selected='selected'"; ?>value="storageSize"><?php echo $translations["STORAGE_SIZE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "operatingSystem") echo "selected='selected'"; ?>value="operatingSystem"><?php echo $translations["OPERATING_SYSTEM"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "hostname") echo "selected='selected'"; ?>value="hostname"><?php echo $translations["HOSTNAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "macAddress") echo "selected='selected'"; ?>value="macAddress"><?php echo $translations["MAC_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "ipAddress") echo "selected='selected'"; ?>value="ipAddress"><?php echo $translations["IP_ADDRESS"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "model") echo "selected='selected'"; ?>value="model"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "type") echo "selected='selected'"; ?>value="hwType"><?php echo $translations["HW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "typeFW") echo "selected='selected'"; ?>value="fwType"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "storageType") echo "selected='selected'"; ?>value="storageType"><?php echo $translations["STORAGE_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "gpu") echo "selected='selected'"; ?>value="videoCard"><?php echo $translations["VIDEO_CARD"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "mediaOperationMode") echo "selected='selected'"; ?>value="mediaOperationMode"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "secBoot") echo "selected='selected'"; ?>value="secureBoot"><?php echo $translations["SECURE_BOOT"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "vt") echo "selected='selected'"; ?>value="virtualizationTechnology"><?php echo $translations["VIRTUALIZATION_TECHNOLOGY"]["NAME"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "tpm") echo "selected='selected'"; ?>value="tpmVersion"><?php echo $translations["TPM_VERSION"] ?></option>
					</select>
					<input style="width:300px" type=text name=txtSearch> <input id="searchButton" type=submit value="OK">
				</td>
			</tr>
		</form>
		<?php
		if (isset($_POST["txtSearch"])) {
			if (isset($_POST["rdCriterion"])) {
				$value = $_POST["rdCriterion"];
			}
		}
		?>
	</table>
	<br><br>
	<?php
	if (!isset($totalSearch)) {
	?>
		<h3><?php echo $translations["ASSETS_ACTIVE"] ?> (<?php echo $totalActive; ?>)</h3>
		<h3><?php echo $translations["ASSETS_DISCARDED"] ?> (<?php echo $totalDiscarded; ?>)</h3><br>
	<?php
	} else {
		$queryActive = $querySearch;
	?>
		<h3><?php echo $translations["RESULTING_ASSETS"] ?> (<?php echo $totalSearch; ?>)</h3><br>
	<?php
	}
	?>
	<table id="assetData" cellspacing=0>
		<form action="eraseSelectedAsset.php" method="post">
			<tr id="header_">
				<?php
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
						<td><img src="img/trash.png" width="22" height="29"></td>
				<?php
					}
				}
				?>
				<td><a href="?orderBy=assetNumber&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_ASSET"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?orderBy=building&sort=<?php echo $sort; ?>"><?php echo $translations["BUILDING"] ?></a></td>
				<?php
				}
				?>
				<td><a href="?orderBy=room&sort=<?php echo $sort; ?>"><?php echo $translations["ASSET_ROOM"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?orderBy=standard&sort=<?php echo $sort; ?>"><?php echo $translations["STANDARD"] ?></a></td>
					<td><a href="?orderBy=brand&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></td>
				<?php
				}
				?>
				<td><a href="?orderBy=model&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></td>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<td><a href="?orderBy=ipAddress&sort=<?php echo $sort; ?>"><?php echo $translations["IP_ADDRESS"] ?></a></td>
				<?php
				}
				?>
				<td><a href="?orderBy=serviceDate&sort=<?php echo $sort; ?>"><?php echo $translations["SHORT_LAST_MAINTENANCE_DATE"] ?></a></td>
			</tr>
			<?php
			while ($result = mysqli_fetch_array($queryActive)) {
				$idAsset = $result["id"];
				$assetNumber = $result["assetNumber"];
				$discarded = $result["discarded"];
				$building = $result["building"];
				$room = $result["room"];
				$standard = $result["standard"];
				$brand = $result["brand"];
				$model = $result["model"];
				$inUse = $result["inUse"];
				$formatacao = $result["serviceDate"];
				$ipAddress = $result["ipAddress"];

				$inUseOk = substr($inUse, 0, 1);

				if ($inUseOk == "N") $inUse = "Não";

				if ($inUse == "Não") {
					$color = "red";
				} else {
					$color = "green";
				}

				$formatDate = substr($formatacao, 0, 10);
				$explodedDate = explode("-", $formatDate);
				if ($explodedDate[0] != "")
					$serviceDate = $explodedDate[2] . "/" . $explodedDate[1] . "/" . $explodedDate[0];
			?>
				<tr id="data">
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
						<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $building; ?></label></td>
					<?php
					}
					?>
					<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $room; ?></label></td>
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
					$assetNumber = $result["assetNumber"];
					$discarded = $result["discarded"];
					$building = $result["building"];
					$room = $result["room"];
					$standard = $result["standard"];
					$brand = $result["brand"];
					$model = $result["model"];
					$inUse = $result["inUse"];
					$formatacao = $result["serviceDate"];
					$ipAddress = $result["ipAddress"];

					$inUseOk = substr($inUse, 0, 1);

					if ($inUseOk == "N") $inUse = "Não";

					if ($inUse == "Não") {
						$color = "red";
					} else {
						$color = "green";
					}

					$formatDate = substr($formatacao, 0, 10);
					$explodedDate = explode("-", $formatDate);
					if ($explodedDate[0] != "")
						$serviceDate = $explodedDate[2] . "/" . $explodedDate[1] . "/" . $explodedDate[0];
				?>
					<tr id="data">
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
							<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $building; ?></label></td>
						<?php
						}
						?>
						<td><label <?php if ($discarded == 1) { ?> id=inactive <?php } ?>><?php echo $room; ?></label></td>
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
			}
			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
					<tr>
						<td colspan=9 align="center"><br><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
					</tr>
			<?php
				}
			}
			?>
		</form>
	</table>
</div>
<?php
require_once("foot.php");
?>