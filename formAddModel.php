<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {

?>

		<div id="middle">
			<form action="addModel.php" method=post id=formGeneral>
				<h2><?php echo $translations["ADD_MODEL_FORM"] ?></h2><br>
				<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
				<table id="formFields">
					<tr>
						<td colspan=3 id=spacer><?php echo $translations["MODEL_DATA"] ?></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["BRAND"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=text name=txtBrand placeholder="<?php echo $translations["PLACEHOLDER_MODEL_BRAND"] ?>" required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["MODEL"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=text name=txtModel placeholder="<?php echo $translations["PLACEHOLDER_MODEL_MODEL"] ?>" required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["FW_VERSION"] ?><mark id=asterisk>*</mark></td>
						
						<td><input type=text name=txtFwVersion placeholder="<?php echo $translations["PLACEHOLDER_MODEL_FW_VERSION"] ?>" required></td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["FW_TYPE"] ?><mark id=asterisk>*</mark></td>
						
						<td>
							<select name=txtFwType required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<?php
								foreach ($fwTypesArray as $str1 => $str2) {
								?>
									<option value=<?php echo $str1 ?>><?php echo $str2 ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["TPM_VERSION"] ?><mark id=asterisk>*</mark></td>
						
						<td>
							<select name=txtTpmVersion required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<?php
								foreach ($tpmTypesArray as $str1 => $str2) {
								?>
									<option value=<?php echo $str1 ?>><?php echo $str2 ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td id=lblFixed><?php echo $translations["MEDIA_OPERATION_MODE"] ?><mark id=asterisk>*</mark></td>
						
						<td>
							<select name=txtMediaOperationMode required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<?php
								foreach($mediaOpTypesArray as $str1 => $str2) {
								?>
									<option value=<?php echo $str1 ?>><?php echo $str2 ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan=3 align="center"><br>
							<input id="registerButton" type="submit" value="<?php echo $translations["LABEL_REGISTER_BUTTON"] ?>">
						</td>
					</tr>
				</table>
			</form>
		</div>
<?php
		require_once("foot.php");
	} else {
		header("Location: denied.php");
	}
}
?>