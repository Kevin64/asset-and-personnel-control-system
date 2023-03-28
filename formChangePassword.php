<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");
?>

<div id="middle">
	<h2><?php echo $translations["CHANGE_USER_PASSWORD"] ?></h2><br>
	<form action="changePassword.php" method="post" id="formGeneral">
		<input type=hidden name=txtStatus value="0">
		<table id="formFields">
			<tr>
				<td id=label><?php echo $translations["USER"] ?></td>
				<?php
				if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
				?>
					<td><input type=text name=txtUser value=<?php echo $_SESSION["username"] ?> required></td>
				<?php
				} else {
				?>
					<td><input type=text name=txtUser value=<?php echo $_SESSION["username"] ?> readonly></td>
				<?php
				}
				?>
			</tr>
			<?php
			if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
			?>
				<tr>
					<td id=label><?php echo $translations["CURRENT_PASSWORD"] ?></td>
					<td><input type=password name=txtCurrentPassword required></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td id=label><?php echo $translations["NEW_PASSWORD"] ?></td>
				<td><input type=password name=txtPassword1 required></td>
			</tr>
			<tr>
				<td id=label><?php echo $translations["REPEAT_NEW_PASSWORD"] ?></td>
				<td><input type=password name=txtPassword2 required></td>
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