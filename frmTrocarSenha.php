<?php
require_once("verifica.php");
require_once("topo.php");

?>

<div id="meio">
	<h2>Alterar senha do usuário</h2><br>
	<form action="alteraSenha.php" method="post" id="frmGeneral">
		<input type=hidden name=txtNivel value="user">
		<input type=hidden name=txtStatus value="0">
		<table id="frmFields">
			<tr>
				<td id=label>Usuário</td>
				<td><input type=text name=txtUsuario required></td>
			</tr>
			<tr>
				<td id=label>Senha atual</td>
				<td><input type=password name=txtSenhaAtual required></td>
			</tr>
			<tr>
				<td id=label>Nova senha</td>
				<td><input type=password name=txtSenha1 required></td>
			</tr>
			<tr>
				<td id=label>Repita a nova senha</td>
				<td><input type=password name=txtSenha2 required></td>
			</tr>
			<tr>
				<td colspan=2><br>
					<input type=submit value="Alterar">
				</td>
			</tr>
		</table>
	</form>
</div>

<?php
require_once("rodape.php");
?>