<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idUser = $_GET["id"];
	$query = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . " where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));
} else {
	if (isset($_POST["txtIdUser"]))
		$idUser = $_POST["txtIdUser"];
	if (isset($_POST["txtUser"]))
		$username = $_POST["txtUser"];
	$oldUsername = $_POST["txtOldUsername"];
	if (isset($_POST["txtPrivilegeLevel"]))
		$privilegeLevel = $_POST["txtPrivilegeLevel"];
	if (isset($_POST["txtLastLoginDate"]))
		$lastLoginDate = $_POST["txtLastLoginDate"];

	$query = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . " where " . $dbAgentsArray["USERNAME"] . " = '$username'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		mysqli_query($connection, "update " . $dbAgentsArray["AGENTS_TABLE"] . " set " . $dbAgentsArray["USERNAME"] . " = '$username', " . $dbAgentsArray["PRIVILEGE_LEVEL"] . " = '$privilegeLevel' where id = '$idUser'") or die($translations["ERROR_UPDATE_USER_DATA"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $username == $oldUsername) {
		mysqli_query($connection, "update " . $dbAgentsArray["AGENTS_TABLE"] . " set " . $dbAgentsArray["PRIVILEGE_LEVEL"] . " = '$privilegeLevel' where id = '$idUser'") or die($translations["ERROR_UPDATE_USER_DATA"] . mysqli_error($connection));
	}

	$query = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . " where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));
}
?>

<div id="middle">
	<form action="formDetailUser.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2><?php $translations["USER_DETAIL"] ?></h2><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $username != $oldUsername) {
				echo "<font color=red>" . $translations["USER_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=blue>" . $translations["SUCCESS_UPDATE_USER_DATA"] . "</font><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idUser = $result["id"];
				$username = $result["username"];
				$oldUsername = $result["username"];
				$privilegeLevel = $result["privilegeLevel"];
				$lastLoginDate = $result["lastLoginDate"];
			?>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["USER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["USER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdUser value="<?php echo $idUser; ?>">
					<input type=hidden name=txtOldUsername value="<?php echo $oldUsername; ?>">
					<td><input type=text name=txtUser required value="<?php echo $username; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["PRIVILEGE"]["NAME"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtPrivilegeLevel required>
							<?php
							foreach ($privilegeLevelsArray as $str2) {
							?>
								<option value=<?php echo $str2 ?> <?php if ($privilegeLevel == $str2) echo "selected"; ?>><?php echo $translations["PRIVILEGE"][$str2] ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["LAST_LOGIN_DATE"] ?></td>
					<td><?php echo $lastLoginDate; ?></td>
				</tr>
			<?php
			}
			if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {
			?>
				<tr>
					<td colspan=2 align=center><br><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
				</tr>
			<?php
			}
			?>
		</table>
	</form>
</div>
<?php
require_once("foot.php");
?>