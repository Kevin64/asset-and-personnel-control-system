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
				<input type=hidden name=txtStatus value="0">
				<table id="formFields">
					<tr>
						<td id=label><?php echo $translations["USER"] ?></td>
						<td><input type=text name=txtUser></td>
					</tr>
					<tr>
						<td id=label><?php echo $translations["PASSWORD"] ?></td>
						<td><input type=password name=txtPassword></td>
					</tr>
					<tr>
						<td id=label><?php echo $translations["PRIVILEGE"] ?></td>
						<td>
							<select name=txtPrivilegeLevel>
								<option value=<?php $privilegeLevelsArray["ADMINISTRATOR_LEVEL"] ?>><?php echo $translations["ADMINISTRATOR_NAME"] ?></option>
								<option value=<?php $privilegeLevelsArray["STANDARD_LEVEL"] ?>><?php echo $translations["STANDARD_NAME"] ?></option>
								<option value=<?php $privilegeLevelsArray["LIMITED_LEVEL"] ?>><?php echo $translations["LIMITED_NAME"] ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan=2><br>
							<input id="registerButton" type=submit value="<?php echo $translations["REGISTER"] ?>">
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