<?php
session_start();
require_once("verifica.php");
require_once("topo.php");
?>

<div id="meio">

	<form action="cadBIOS.php" method=post id=frmCadBIOS>
		<h2>Formulário de cadastro de modelo de hardware</h2><br>
		<table id=frmCadBIOSTable>
			<tr>
				<td colspan=2 id=separador>Dados do modelo</td>
			</tr>
			<tr>
				<td id="label">Marca</td>
				<td><input type=text name=txtMarca placeholder="Ex.: Dell, Hewlett-Packard, LENOVO, etc" required></td>
			</tr>
			<tr>
				<td id="label">Modelo</td>
				<td><input type=text name=txtModelo placeholder="Ex.: 9010, 6005, etc" required></td>
			</tr>
			<tr>
				<td id="label">Versão da BIOS/UEFI</td>
				<td><input type=text name=txtVersao placeholder="Ex.: A30, 1.17, etc" required></td>
			</tr>
			<tr>
				<td id="label">Tipo</td>
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
					<input type="submit" value="Cadastrar">
				</td>
			</tr>
		</table>
	</form>
</div>

<?php
require_once("rodape.php");
?>