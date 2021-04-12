<?php
session_start();
require_once ("verifica.php");
require_once ("topo.php");

?>
	<div id="meio">

		<form action="cadDocente.php" method=post id=frmCadDocente>
		<h2>Formulário de cadastro de docente</h2><br>
		<table>
		<tr>
		<td colspan=2 id=separador>Dados do docente</td>
		</tr>
		<tr>
		<td id="label">Siape</td>
		<td><input type=text name=txtSiape></td>
		</tr>
		<tr>
		<td id="label">Nome</td>
		<td><input type=text name=txtNome></td>
		</tr>
		<tr>
		<td id="label">E-mail</td>
		<td><input type=text name=txtEmail></td>
		</tr>
		<tr>
		<td id="label">Ramal</td>
		<td><input type=text name=txtRamal></td>
		</tr>
		<td id="label">Celular</td>
		<td><input type=text name=txtCelular></td>
		</tr>
		<tr>
		<td id="label">Curso</td>
		<td><input type=text name=txtCurso></td>
		</tr>
		<tr>
		<td id="label">Sala</td>
		<td><input type=text name=txtSala></td>
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
