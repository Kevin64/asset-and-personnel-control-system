<?php
require_once("verifica.php");
require_once("top.php");
require_once __DIR__ . "/connection.php";

if (isset($_SESSION["nivel"])) {
	if ($_SESSION["nivel"] == "Administrador") {

?>

		<div id="meio">
			<form action="cadBIOS.php" method=post id=frmGeneral>
				<h2>Formulário de cadastro de modelo de hardware</h2><br>
				<label id=asteriskWarning>Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
				<table id="frmFields">
					<tr>
						<td colspan=2 id=separador>Dados do modelo</td>
					</tr>
					<tr>
						<td id="label">Marca<mark id=asterisk>*</mark></td>
						<td><input type=text name=txtMarca placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required></td>
					</tr>
					<tr>
						<td id="label">Modelo<mark id=asterisk>*</mark></td>
						<td><input type=text name=txtModelo placeholder="Ex.: 9010, 6005, etc" required></td>
					</tr>
					<tr>
						<td id="label">Versão da BIOS/UEFI<mark id=asterisk>*</mark></td>
						<td><input type=text name=txtVersao placeholder="Ex.: A30, 1.17, etc" required></td>
					</tr>
					<tr>
						<td id="label">Tipo de firmware<mark id=asterisk>*</mark></td>
						<td>
							<select name=txtTipo required>
								<option disabled selected value> -- Selecione uma opção -- </option>
								<option value=BIOS>BIOS</option>
								<option value=UEFI>UEFI</option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label">Versão TPM<mark id=asterisk>*</mark></td>
						<td>
							<select name=txtTPM required>
								<option disabled selected value> -- Selecione uma opção -- </option>
								<option value=Nenhum>Não existente</option>
								<option value=1.2>1.2</option>
								<option value=2.0>2.0</option>
							</select>
						</td>
					</tr>
					<tr>
						<td id="label">Modo Armaz.<mark id=asterisk>*</mark></td>
						<td>
							<select name=txtMediaOp required>
								<option disabled selected value> -- Selecione uma opção -- </option>
								<option value=IDE/RAID>IDE/RAID</option>
								<option value=AHCI>AHCI</option>
								<option value=NVMe>NVMe</option>
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
		header("Location: deny.php");
	}
}
?>