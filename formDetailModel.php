<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$idModel = null;
$brand = null;
$model = null;
$fwVersion = null;
$fwType = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	if (isset($_GET["id"]))
		$idModel = $_GET["id"];

	if (isset($_GET["brand"]))
		$brand = $_GET["brand"];

	if (isset($_GET["model"]))
		$model = $_GET["model"];

	if (isset($_GET["fwVersion"]))
		$fwVersion = $_GET["fwVersion"];

	if (isset($_GET["fwType"]))
		$fwType = $_GET["fwType"];

	if (isset($_GET["tpmVersion"]))
		$tpmVersion = $_GET["tpmVersion"];

	if (isset($_GET["mediaOperationMode"]))
		$mediaOperationMode = $_GET["mediaOperationMode"];

	$query = mysqli_query($connection, "select * from model where id = '$idModel'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($connection));
} else {
	$idModel = $_POST["txtIdModel"];
	$brand = $_POST["txtBrand"];
	$model = $_POST["txtModel"];
	$oldModel = $_POST["txtOldModel"];
	$fwVersion = $_POST["txtFwVersion"];
	$fwType = $_POST["txtFwType"];
	$tpmVersion = $_POST["txtTpmVersion"];
	$mediaOperationMode = $_POST["txtMediaOperationMode"];

	$query = mysqli_query($connection, "select * from model where model = '$model'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		mysqli_query($connection, "update model set brand = '$brand', model = '$model', fwVersion = '$fwVersion', fwType = '$fwType', tpmVersion = '$tpmVersion', mediaOperationMode = '$mediaOperationMode' where id = '$idModel'") or die($translations["ERROR_UPDATE_MODEL_DATA"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $model == $oldModel) {
		mysqli_query($connection, "update model set brand = '$brand', fwVersion = '$fwVersion', fwType = '$fwType', tpmVersion = '$tpmVersion', mediaOperationMode = '$mediaOperationMode' where id = '$idModel'") or die($translations["ERROR_UPDATE_MODEL_DATA"] . mysqli_error($connection));
	}
	$query = mysqli_query($connection, "select * from model where id = '$idModel'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($connection));
}
?>

<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
					if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }} ?>>
	<form action="formDetailModel.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["MODEL_DETAIL"] ?></h2><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $model != $oldModel) {
				echo "<font color=red>" . $translations["MODEL_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=blue>" . $translations["SUCCESS_UPDATE_MODEL_DATA"] . "</font><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idModel = $result["id"];
				$brand = $result["brand"];
				$model = $result["model"];
				$oldModel = $result["model"];
				$fwVersion = $result["fwVersion"];
				$fwType = $result["fwType"];
				$tpmVersion = $result["tpmVersion"];
				$mediaOperationMode = $result["mediaOperationMode"];
			?>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["MODEL_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["BRAND"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtBrand placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required value="<?php echo $brand; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["MODEL"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdModel value="<?php echo $idModel; ?>">
					<input type=hidden name=txtOldModel value="<?php echo $oldModel; ?>">
					<td><input type=text name=txtModel placeholder="Ex.: 9010, 6005, etc" required value="<?php echo $model; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["FW_VERSION"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtFwVersion placeholder="Ex.: A30, 1.17, etc" required value="<?php echo $fwVersion; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["FW_TYPE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtFwType required>
							<?php
							foreach ($fwTypesArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($fwType == $str1) echo "selected='selected'"; ?>><?php echo $str2 ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TPM_VERSION"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtTpmVersion required>
							<?php
							foreach ($tpmTypesArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($tpmVersion == $str1) echo "selected='selected'"; ?>><?php echo $str2; ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["MEDIA_OPERATION_MODE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtMediaOperationMode required>
							<?php
							foreach ($mediaOpTypesArray as $str1 => $str2) {
							?>
								<option value=<?php echo $str1 ?> <?php if ($mediaOperationMode == $str1) echo "selected='selected'"; ?>><?php echo $str2 ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				</tr>
			<?php
			}
			if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {
			?>
				<tr>
					<td colspan=2 align=center><br><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
				</tr>
			<?php
			}
			?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>