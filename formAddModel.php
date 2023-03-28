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
				<label id=asteriskWarning>Os campos branddos com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
				<table id="formFields">
					<tr>
						<td colspan=2 id=spacer><?php echo $translations["MODEL_DATA"] ?></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["BRAND"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtBrand placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["MODEL"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtModel placeholder="Ex.: 9010, 6005, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["FW_VERSION"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtFwVersion placeholder="Ex.: A30, 1.17, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["FW_TYPE"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtFwType required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=<?php echo $fwTypesArray[0] ?>><?php echo $fwTypesArray[0] ?></option>
								<option value=<?php echo $fwTypesArray[1] ?>><?php echo $fwTypesArray[1] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TPM_VERSION"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtTpmVersion required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=<?php echo $tpmTypesArray[0] ?>><?php echo $translations["NONE"] ?></option>
								<option value=<?php echo $tpmTypesArray[1] ?>><?php echo $tpmTypesArray[1] ?></option>
								<option value=<?php echo $tpmTypesArray[2] ?>><?php echo $tpmTypesArray[2] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["MEDIA_OPERATION_MODE"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtMediaOperationMode required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=<?php echo $mediaOpTypesArray[0] ?>><?php echo $mediaOpTypesArray[0] ?></option>
								<option value=<?php echo $mediaOpTypesArray[1] ?>><?php echo $mediaOpTypesArray[1] ?></option>
								<option value=<?php echo $mediaOpTypesArray[2] ?>><?php echo $mediaOpTypesArray[2] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><br>
							<input id="registerButton" type="submit" value="<?php echo $translations["REGISTER"] ?>">
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