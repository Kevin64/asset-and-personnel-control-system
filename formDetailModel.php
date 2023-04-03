<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;
$id = null;
$brand = null;
$model = null;
$fwVersion = null;
$fwType = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	if (isset($_GET["id"]))
		$id = $_GET["id"];

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

	$query = mysqli_query($connection, "select * from model where id = '$id'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($connection));
} else {
	$id = $_POST["txtIdModel"];
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
		mysqli_query($connection, "update model set brand = '$brand', model = '$model', fwVersion = '$fwVersion', fwType = '$fwType', tpmVersion = '$tpmVersion', mediaOperationMode = '$mediaOperationMode' where id = '$id'") or die($translations["ERROR_UPDATE_MODEL_DATA"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $model == $oldModel) {
		mysqli_query($connection, "update model set brand = '$brand', fwVersion = '$fwVersion', fwType = '$fwType', tpmVersion = '$tpmVersion', mediaOperationMode = '$mediaOperationMode' where id = '$id'") or die($translations["ERROR_UPDATE_MODEL_DATA"] . mysqli_error($connection));
	}
	$query = mysqli_query($connection, "select * from model where id = '$id'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($connection));
}
?>

<div id="middle">
	<form action="formDetailModel.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php echo $translations["MODEL_DETAIL"] ?></h2><br>
		<?php
		if ($send == 1) {
			if($num_rows > 0 && $model != $oldModel) {
				echo "<font color=red>" . $translations["MODEL_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=blue>" . $translations["SUCCESS_UPDATE_MODEL_DATA"] . "</font><br><br>";
			}
		}
		?>
		<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$id = $result["id"];
				$brand = $result["brand"];
				$model = $result["model"];
				$fwVersion = $result["fwVersion"];
				$fwType = $result["fwType"];
				$tpmVersion = $result["tpmVersion"];
				$mediaOperationMode = $result["mediaOperationMode"];

				$oldModel = $result["model"];
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
					<input type=hidden name=txtIdModel value="<?php echo $id; ?>">
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
							<option value=BIOS <?php if ($fwType == $fwTypesArray[0]) echo "selected='selected'"; ?>><?php echo $fwTypesArray[0] ?></option>
							<option value=UEFI <?php if ($fwType == $fwTypesArray[1]) echo "selected='selected'"; ?>><?php echo $fwTypesArray[1] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["TPM_VERSION"] ?><mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtTpmVersion required>
							<option value=<?php echo $tpmTypesArray[0] ?> <?php if ($tpmVersion == $tpmTypesArray[0]) echo "selected='selected'"; ?>><?php echo $translations["NONE"] ?></option>
							<option value=<?php echo $tpmTypesArray[1] ?> <?php if ($tpmVersion == $tpmTypesArray[1]) echo "selected='selected'"; ?>><?php echo $tpmTypesArray[1] ?></option>
							<option value=<?php echo $tpmTypesArray[2] ?> <?php if ($tpmVersion == $tpmTypesArray[2]) echo "selected='selected'"; ?>><?php echo $tpmTypesArray[2] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["MEDIA_OPERATION_MODE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<?php
						?>
						<select name=txtMediaOperationMode required>
							<option value=IDE/RAID <?php if ($mediaOperationMode == $mediaOpTypesArray[0]) echo "selected='selected'"; ?>><?php echo $mediaOpTypesArray[0] ?></option>
							<option value=AHCI <?php if ($mediaOperationMode == $mediaOpTypesArray[1]) echo "selected='selected'"; ?>><?php echo $mediaOpTypesArray[1] ?></option>
							<option value=NVMe <?php if ($mediaOperationMode == $mediaOpTypesArray[2]) echo "selected='selected'"; ?>><?php echo $mediaOpTypesArray[2] ?></option>
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