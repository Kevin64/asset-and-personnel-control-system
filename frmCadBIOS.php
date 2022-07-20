<?php
session_start();
require_once("verifica.php");
require_once("topo.php");
?>

<div id="meio">
	<form action="cadBIOS.php" method=post id=frmGeneral>
		<h2>Formulário de cadastro de modelo de hardware</h2><br>
		<label style="color:darkblue">Os campos marcados com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
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
				<td colspan="2" align="center"><br>
					<input id="registerButton" type="submit" value="Cadastrar">
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("rodape.php");
?>