<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/conexao.php";

if (isset($_SESSION["nivel"])) {
	if ($_SESSION["nivel"] == "Administrador") {

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
								<option value="Administrador">Administrador</option>
								<option value="Padrão">Padrão</option>
								<option value="Limitado">Limitado</option>
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
	} else {
		header("Location: negado.php");
	}
}
?>