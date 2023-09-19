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

if ($send != 1) {
	if (isset($_GET["id"]))
		$idModel = $_GET["id"];

	$query = mysqli_query($connection, "select * from " . $dbModelArray["MODEL_TABLE"] . " where id = '$idModel'") or die($translations["ERROR_SHOW_DETAIL_MODEL"] . mysqli_error($connection));
}
?>

<div id="middle" <?php if (isset($_SESSION["privilegeLevel"])) {
						if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["LIMITED_LEVEL"]) { ?> class="readonly" <?php }
																													} ?>>
	<form id="formGeneral">
		<h2><?php echo $translations["MODEL_DETAIL"] ?></h2><br>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idModel = $result["id"];
				$brand = $result[$dbModelArray["BRAND"]];
				$model = $result[$dbModelArray["MODEL"]];
				$oldModel = $result[$dbModelArray["MODEL"]];
				$fwVersion = $result[$dbModelArray["FW_VERSION"]];
				$fwType = $result[$dbModelArray["FW_TYPE"]];
				$tpmVersion = $result[$dbModelArray["TPM_VERSION"]];
				$mediaOperationMode = $result[$dbModelArray["MEDIA_OPERATION_MODE"]];
			?>
				<tr>
					<td colspan=3 id=section-header><?php echo $translations["MODEL_DATA"] ?></td>
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
					<input type=hidden name=txtIdModel value="<?php echo $idModel; ?>">
					<input type=hidden name=txtOldModel value="<?php echo $oldModel; ?>">

					<td id=lblData><?php if ($model == "") {
										echo $json_constants_array["DASH"];
									} else {
										echo $model;
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
									} ?>
					</td>
				</tr>
				<?php
			}
			if (isset($_SESSION["privilegeLevel"])) {
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
					<tr>
						<td id=h-separator colspan=3 align=center><input id="updateButton" type=button onclick="location.href='editModel.php?id=<?php echo $idModel ?>'" value=<?php echo $translations["LABEL_EDIT_BUTTON"] ?>></td>
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