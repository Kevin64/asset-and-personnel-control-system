	<div id="middle">
		<br><br><Br><Br>
		<?php
		if (!isset($_SESSION["id"])) {
		?>
			<form action="authenticate.php" method="post" id="formLogin">
				<h2><?php echo $translations["RESTRICTED_ACCESS"] ?></h2>
				<br>
				<input type="hidden" name="txtSend" value="1">
				<label for="txtUser"><?php echo $translations["USERNAME"] ?><br><input type="text" name="txtUser"></label><br><br>
				<label for="txtPassword"><?php echo $translations["PASSWORD"] ?><br><input type="password" name="txtPassword"></label><br><br>
				<input type="submit" value="Entrar">
			</form>
		<?php
		} else {
			echo "<h1>" . $translations["APCS"] . "</h1>";
			echo "<h2>" . $translations["USE_NAVIGATION_MENU"] . "</h2>";
		}
		?>
	</div>