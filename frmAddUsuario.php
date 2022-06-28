<?php
session_start();
require_once("verifica.php");
require_once("topo.php");
?>

<div id="meio">
	<form action=cadNovoUsuario.php method=post id="frmGeneral">
		<h2>Formulário de cadastro de usuário</h2><br>
		<input type=hidden name=txtStatus value="0">
		<table id="frmFields">
			<tr>
				<td id=label>Usuário</td>
				<td><input type=text name=txtUsuario></td>
			</tr>
			<tr>
				<td id=label>Senha</td>
				<td><input type=password name=txtSenha></td>
			</tr>
			<tr>
				<td id=label>Privilégio</td>
				<td>
					<select name=txtNivel>
						<option value="adm">Administrador</option>
						<option value="user">Usuário</option>
						<option value="limit">Limitado</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan=2><br>
					<input id="registerButton" type=submit value="Cadastrar">
				</td>
			</tr>
		</table>
	</form>
</div>
<?php
require_once("rodape.php");
?>