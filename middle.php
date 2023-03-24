	<div id="meio">
		<br><br><Br><Br>
		<?php
		if (!isset($_SESSION["id"])) {
		?>
			<form action="autentica.php" method="post" id="frmLogin">
				<h2><?php echo $translations["RESTRICTED_ACCESS"] ?></h2>
				<br>
				<input type="hidden" name="txtEnviar" value="1">
				<label for="txtUsuario"><?php echo $translations["USERNAME"] ?><br><input type="text" name="txtUsuario"></label><br><br>
				<label for="txtSenha"><?php echo $translations["PASSWORD"] ?><br><input type="password" name="txtSenha"></label><br><br>
				<input type="submit" value="Entrar">
			</form>
		<?php
		} else {
			echo "<h1>" . $translations["ATCS"] . "</h1>";
			echo "<h2>" . $translations["USE_NAVIGATION_MENU"] . "</h2>";
		}
		?>
	</div>