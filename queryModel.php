<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$orderBy = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if (isset($_GET["orderBy"]))
	$orderBy = $_GET["orderBy"];

if (isset($_GET["sort"]))
	$sort = $_GET["sort"];

if ($orderBy == "")
	$orderBy = "brand";

if (isset($sort) and $sort == "asc") {
	$sort = "desc";
} else {
	$sort = "asc";
}

if ($send != 1)
	$query = mysqli_query($connection, "select * from " . $dbModelArray["MODEL_TABLE"] . " order by $orderBy $sort") or die($translations["ERROR_QUERY_MODEL"] . mysqli_error($connection));
else {
	$rdCriterion = $_POST["rdCriterion"];
	$search = $_POST["txtSearch"];
	$query = mysqli_query($connection, "select * from " . $dbModelArray["MODEL_TABLE"] . " where $rdCriterion like '%$search%'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
}

$totalRooms = mysqli_num_rows($query);
?>

<div id="middle">
	<table id="tbSearch">
		<form action=queryModel.php method=post>
			<input type=hidden name=txtSend value=1>
			<tr>
				<td align=center><?php echo $translations["SEARCH_FOR"] ?></td>
			</tr>
			<tr>
				<td align=center>
					<select id=filterModel name=rdCriterion>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbModelArray["MODEL"]) echo "selected='selected'"; ?>value="<?php echo $dbModelArray["MODEL"] ?>"><?php echo $translations["MODEL"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbModelArray["BRAND"]) echo "selected='selected'"; ?>value="<?php echo $dbModelArray["BRAND"] ?>"><?php echo $translations["BRAND"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbModelArray["FW_VERSION"]) echo "selected='selected'"; ?>value="<?php echo $dbModelArray["FW_VERSION"] ?>"><?php echo $translations["FW_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbModelArray["FW_TYPE"]) echo "selected='selected'"; ?>value="<?php echo $dbModelArray["FW_TYPE"] ?>"><?php echo $translations["FW_TYPE"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == $dbModelArray["MEDIA_OPERATION_MODE"]) echo "selected='selected'"; ?>value="<?php echo $dbModelArray["TPM_VERSION"] ?>"><?php echo $translations["TPM_VERSION"] ?></option>
						<option <?php if (isset($_POST["rdCriterion"]) && $_POST["rdCriterion"] == "mediaOperationMode") echo "selected='selected'"; ?>value="<?php echo $dbModelArray["MEDIA_OPERATION_MODE"] ?>"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></option>
					</select>
					<input style="width:335px" type=text name=txtSearch> <input id="searchButton" type=submit value="OK">
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
	<h2><?php echo $translations["MODEL_LIST"] . " " ?>(<?php echo $totalRooms; ?>)</h2><br>
	<form action="eraseSelectedModel.php" method="post">
		<table id="modelData" cellspacing=0>
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
				<th><a href="?orderBy=<?php echo $dbModelArray["MODEL"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["MODEL"] ?></a></th>
				<th><a href="?orderBy=<?php echo $dbModelArray["BRAND"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["BRAND"] ?></a></th>
				<th><a href="?orderBy=<?php echo $dbModelArray["FW_VERSION"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["FW_VERSION"] ?></a></th>
				<?php
				if (!in_array(true, $devices)) {
				?>
					<th><a href="?orderBy=<?php echo $dbModelArray["FW_TYPE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["FW_TYPE"] ?></a></th>
					<th><a href="?orderBy=<?php echo $dbModelArray["TPM_VERSION"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["TPM_VERSION"] ?></a></th>
					<th><a href="?orderBy=<?php echo $dbModelArray["MEDIA_OPERATION_MODE"] ?>&sort=<?php echo $sort; ?>"><?php echo $translations["MEDIA_OPERATION_MODE"] ?></a></th>
				<?php
				}
				?>
			</thead>
			<tbody>
				<?php
				while ($result = mysqli_fetch_array($query)) {
					$idModel = $result["id"];
					$brand = $result[$dbModelArray["BRAND"]];
					$model = $result[$dbModelArray["MODEL"]];
					$fwVersion = $result[$dbModelArray["FW_VERSION"]];
					$fwType = $result[$dbModelArray["FW_TYPE"]];
					$tpmVersion = $result[$dbModelArray["TPM_VERSION"]];
					$mediaOperationMode = $result[$dbModelArray["MEDIA_OPERATION_MODE"]];
				?>
					<tr id="data">
						<?php
						if (isset($_SESSION["privilegeLevel"])) {
							if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
						?>
								<td><input type="checkbox" name="chkDelete[]" value="<?php echo $idModel; ?>" onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled = false;}else{input.disabled=true;}"></td>
						<?php
							}
						}
						?>
						<td><a href="formDetailModel.php?id=<?php echo $idModel; ?>"><?php echo $model; ?></a></td>
						<td><?php echo $brand; ?></td>
						<td><?php echo $fwVersion; ?></td>
						<?php
						if (!in_array(true, $devices)) {
						?>
							<td><?php echo $fwTypesArray[$fwType]; ?></td>
							<?php if (isset($tpmTypesArray[$tpmVersion])) { ?>
								<td><?php echo $tpmTypesArray[$tpmVersion];
								} else { ?>
								<td style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>"><?php echo $translations["INCOMPLETE_REGISTRATION_DATA"];
																																									} ?></td>
								<?php if (isset($tpmTypesArray[$tpmVersion])) { ?>
									<td><?php echo $mediaOpTypesArray[$mediaOperationMode];
									} else { ?>
									<td style="background:<?php echo $colorArray["MISSING_DATA_BACKGROUND"] ?>;color:<?php echo $colorArray["MISSING_DATA_FOREGROUND"] ?>"><?php echo $translations["INCOMPLETE_REGISTRATION_DATA"];
																																										} ?></td>
								<?php
							}
								?>
					</tr>
			</tbody>
			<?php
				}
				if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
			?>
				<tr>
					<td colspan=7 align="center"><br><input id="eraseButton" type="submit" value="<?php echo $translations["LABEL_ERASE_BUTTON"] ?>" disabled></td>
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