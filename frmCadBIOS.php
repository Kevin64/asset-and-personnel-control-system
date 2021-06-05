<?php
session_start();
require_once ("verifica.php");
require_once ("topo.php");

?>

	<div id="meio">

		<form action="cadBIOS.php" method=post id=frmCadBIOS>
		<h2>Formulário de cadastro de patrimônio</h2><br>
		<table>
		<tr>
		<td colspan=2 id=separador>Dados da BIOS</td>
		</tr>
		<tr>
		<td id="label">Marca</td>
		<td><input type=text name=txtMarca></td>
		</tr>
		<tr>
		<td id="label">Modelo</td>
		<td><input type=text name=txtModelo></td>
		</tr>
		<tr>
		<td id="label">Versão da BIOS/UEFI</td>
		<td><input type=text name=txtVersao></td>
		</tr>
		<tr>
		<td id="label">Tipo</td>
		<td><input type=text name=txtTipo></td>
		</tr>
		<tr>
		<td colspan="2" align="center"><br>
		<input type="submit" value="Cadastrar"></td>
		</tr>
		</table>
		</form>
	</div>

<?php
require_once ("rodape.php");
?>
