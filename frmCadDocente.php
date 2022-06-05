<?php
session_start();
require_once("verifica.php");
require_once("topo.php");
?>

<div id="meio">

	<form action="cadDocente.php" method=post id=frmCadDocente>
		<h2>Formulário de cadastro de docente</h2><br>
		<table>
			<tr>
				<td colspan=2 id=separador>Dados do docente</td>
			</tr>
			<tr>
				<td id="label">SIAPE</td>
				<td><input type=text name=txtSiape placeholder=1234567 maxLength=8 required></td>
			</tr>
			<tr>
				<td id="label">Nome</td>
				<td><input type=text name=txtNome placeholder="Fulano de Tal" required></td>
			</tr>
			<tr>
				<td id="label">E-mail</td>
				<td><input type=email name=txtEmail placeholder=fulano@email.com></td>
			</tr>
			<tr>
				<td id="label">Ramal</td>
				<td><input type=text name=txtRamal placeholder=9876 maxLength=4></td>
			</tr>
			<td id="label">Celular (com DDD)</td>
			<td><input type=text name=txtCelular placeholder=55998765432 maxLength=11 required></td>
			</tr>
			<tr>
				<td id="label">Curso</td>
				<td><input type=text name=txtCurso placeholder="Curso de Humanas" required></td>
			</tr>
			<tr>
				<td id="label">Sala</td>
				<td><input type=text name=txtSala placeholder=4413 maxLength=4></td>
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