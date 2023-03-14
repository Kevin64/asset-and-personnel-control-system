<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/conexao.php";
?>

<div id="meio">
	<h2>Alterar senha do usuário</h2><br>
	<form action="alteraSenha.php" method="post" id="frmGeneral">
		<input type=hidden name=txtStatus value="0">
		<table id="frmFields">
			<tr>
				<td id=label>Usuário</td>
				<?php
				if ($_SESSION["nivel"] == "Administrador") {
				?>
					<td><input type=text name=txtUsuario value=<?php echo $_SESSION["usuario"] ?> required></td>
				<?php
				} else {
				?>
					<td><input type=text name=txtUsuario value=<?php echo $_SESSION["usuario"] ?> readonly></td>
				<?php
				}
				?>
			</tr>
			<?php
			if ($_SESSION["nivel"] != "Administrador") {
			?>
				<tr>
					<td id=label>Senha atual</td>
					<td><input type=password name=txtSenhaAtual required></td>
				</tr>
			<?php
			}
			?>
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