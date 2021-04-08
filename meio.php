	<div id="meio">
		<br><br><Br><Br>

		<?php
		if (!isset($_SESSION["id"])) {
		?>

		<form action="autentica.php" method="post" id="frmLogin">
		<h2>Acesso restrito</h2>
		<br>
		<input type="hidden" name="txtEnviar" value="1">
		<label for="txtUsuario">Usuário <input type="text" name="txtUsuario"></label><br><br>
		<label for="txtSenha">Senha <input type="password" name="txtSenha"></label><br><br>
		<input type="submit" value="Entrar">
		</form>

		<?php
		} else {
			echo "<h1>Sistema de controle de patrimônio e docentes</h1>";
			echo "<h2>Use o menu acima para navegar</h2>";
		}
		?>
	</div>
