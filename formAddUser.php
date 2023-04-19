<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if (isset($_SESSION["privilegeLevel"])) {
	if ($_SESSION["privilegeLevel"] == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {

?>
		<div id="middle">
			<form action=addNewUser.php method=post id="formGeneral">
				<h2><?php echo $translations["ADD_USER_FORM"] ?></h2><br>
				<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
				<table id="formFields">
					<tr>
						<td id=label><?php echo $translations["USER"] ?><mark id=asterisk>*</mark></td>
						<td><input type=text name=txtUser required></td>
					</tr>
					<tr>
						<td id=label><?php echo $translations["PASSWORD"] ?><mark id=asterisk>*</mark></td>
						<td><input type=password name=txtPassword required></td>
					</tr>
					<tr>
						<td id=label><?php echo $translations["PRIVILEGE"]["NAME"] ?><mark id=asterisk>*</mark></td>
						<td>
							<select name=txtPrivilegeLevel>
								<?php
								foreach ($privilegeLevelsArray as $str1 => $str2) {
								?>
									<option value=<?php echo $str2 ?>> <?php echo $translations["PRIVILEGE"][$str2] ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan=2><br>
							<input id="registerButton" type=submit value="<?php echo $translations["LABEL_REGISTER_BUTTON"] ?>">
						</td>
					</tr>
				</table>
			</form>
		</div>
<?php
		require_once("foot.php");
	} else {
		header("Location: denied.php");
	}
}
?>