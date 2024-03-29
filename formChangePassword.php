<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");
?>

<div id="middle">
	<h2><?php echo $translations["CHANGE_AGENT_PASSWORD"] ?></h2><br>
	<form action="changePassword.php" method="post" id="formGeneral">
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<input type=hidden name=txtStatus value="0">
		<table id="formFields">
			<tr>
				<td id=lblFixed><?php echo $translations["USERNAME"] ?><mark id=asterisk>*</mark></td>

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
					<td id=lblFixed><?php echo $translations["CURRENT_PASSWORD"] ?><mark id=asterisk>*</mark></td>

					<td><input type=password name=txtCurrentPassword required></td>
				</tr>
			<?php
			}
			?>
			<tr>
				<td id=lblFixed><?php echo $translations["NEW_PASSWORD"] ?><mark id=asterisk>*</mark></td>

				<td><input type=password name=txtPassword1 required></td>
			</tr>
			<tr>
				<td id=lblFixed><?php echo $translations["REPEAT_NEW_PASSWORD"] ?><mark id=asterisk>*</mark></td>

				<td><input type=password name=txtPassword2 required></td>
			</tr>
			<tr>
				<td id=h-separator colspan=3><input id="updateButton" type=submit value="<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>"></td>
			</tr>
		</table>
	</form>
</div>

<?php
require_once("foot.php");
?>