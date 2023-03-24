<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");
?>

<div id="meio">
	<h2><?php echo $translations["CHANGE_USER_PASSWORD"] ?></h2><br>
	<form action="changePassword.php" method="post" id="frmGeneral">
		<input type=hidden name=txtStatus value="0">
		<table id="frmFields">
			<tr>
				<td id=label><?php echo $translations["USER"] ?></td>
				<?php
				if ($_SESSION["nivel"] == $json_config_array["ADMIN_LEVEL"]) {
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
			if ($_SESSION["nivel"] != $json_config_array["ADMIN_LEVEL"]) {
			?>
				<tr>
					<td id=label><?php echo $translations["CURRENT_PASSWORD"] ?></td>
					<td><input type=password name=txtSenhaAtual required></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td id=label><?php echo $translations["NEW_PASSWORD"] ?></td>
				<td><input type=password name=txtSenha1 required></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["REPEAT_NEW_PASSWORD"] ?></td>
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
require_once("foot.php");
?>