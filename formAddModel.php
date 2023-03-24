<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["nivel"])) {
	if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {

?>

		<div id="meio">
			<form action="addModel.php" method=post id=frmGeneral>
				<h2><?php echo $translations["ADD_MODEL_FORM"] ?></h2><br>
				<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
				<table id="frmFields">
					<tr>
						<td colspan=2 id=separador><?php echo $translations["MODEL_DATA"] ?></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["BRAND"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtMarca placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["MODEL"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtModelo placeholder="Ex.: 9010, 6005, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["FW_VERSION"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtVersao placeholder="Ex.: A30, 1.17, etc" required></td>
					</tr>
					<tr>
						<td id="label"><?php echo $translations["FW_TYPE"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtTipo required>
								<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
								<option value=BIOS><?php echo $json_config_array["FW_BIOS"] ?></option>
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