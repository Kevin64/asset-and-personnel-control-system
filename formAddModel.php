<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"]) {

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
						<td><input type=text name=txtVersion placeholder="Ex.: A30, 1.17, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["FW_TYPE"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtType required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=model><?php echo $json_config_array["FW_model"] ?></option>
								<option value=UEFI><?php echo $json_config_array["FW_UEFI"] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["TPM_VERSION"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtTPM required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=Nenhum>Não existente</option>
								<option value=1.2><?php echo $json_config_array["TPM_1_2"] ?></option>
								<option value=2.0><?php echo $json_config_array["TPM_2_0"] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["MEDIA_OPERATION_MODE"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtMediaOp required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=IDE/RAID><?php echo $json_config_array["MEDIA_OP_IDE"] ?></option>
								<option value=AHCI><?php echo $json_config_array["MEDIA_OP_AHCI"] ?></option>
								<option value=NVMe><?php echo $json_config_array["MEDIA_OP_NVME"] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><br>
							<input id="registerButton" type="submit" value="Cadastrar">
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