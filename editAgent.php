<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME']) && $_SESSION["privilegeLevel"] != $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
	header('HTTP/1.1 403 Forbidden', TRUE, 403);
	die(header('location: /denied.php'));
}

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idUser = $_GET["id"];
	$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_AGENT"] . mysqli_error($connection));
} else {
	if (isset($_POST["txtIdUser"]))
		$idUser = $_POST["txtIdUser"];
	if (isset($_POST["txtUser"]))
		$username = $_POST["txtUser"];
	$oldUsername = $_POST["txtOldUsername"];
	if (isset($_POST["txtName"]))
		$name = $_POST["txtName"];
	if (isset($_POST["txtSurname"]))
		$surname = $_POST["txtSurname"];
	if (isset($_POST["txtRole"]))
		$role = $_POST["txtRole"];
	if (isset($_POST["txtPrivilegeLevel"]))
		$privilegeLevel = $_POST["txtPrivilegeLevel"];
	if (isset($_POST["txtLastLoginDate"]))
		$lastLoginDate = $_POST["txtLastLoginDate"];
	if (isset($_POST["chkBoxBlocked"])) {
		$blocked = $_POST["chkBoxBlocked"];
	} else {
		$blocked = "0";
	}

	$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where " . $dbAgentArray["USERNAME"] . " = '$username'") or die($translations["ERROR_SHOW_DETAIL_AGENT"] . mysqli_error($connection));

	$num_rows = mysqli_num_rows($query);

	if ($num_rows == 0) {
		mysqli_query($connection, "update " . $dbAgentArray["AGENTS_TABLE"] . " set " . $dbAgentArray["USERNAME"] . " = '$username', " . $dbAgentArray["NAME"] . " = '$name', " . $dbAgentArray["SURNAME"] . " = '$surname', " . $dbAgentArray["ROLE"] . " = '$role', " . $dbAgentArray["PRIVILEGE_LEVEL"] . " = '$privilegeLevel', " . $dbAgentArray["BLOCKED"] . " = '$blocked' where id = '$idUser'") or die($translations["ERROR_UPDATE_AGENT_DATA"] . mysqli_error($connection));
	} else if ($num_rows == 1 && $username == $oldUsername) {
		mysqli_query($connection, "update " . $dbAgentArray["AGENTS_TABLE"] . " set " . $dbAgentArray["PRIVILEGE_LEVEL"] . " = '$privilegeLevel', " . $dbAgentArray["BLOCKED"] . " = '$blocked' where id = '$idUser'") or die($translations["ERROR_UPDATE_AGENT_DATA"] . mysqli_error($connection));
	}

	$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_AGENT"] . mysqli_error($connection));

	header("Location: formDetailAgent.php?id=$idUser");
}
?>

<div id="middle">
	<form action="editAgent.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h1><?php echo $translations["AGENT_EDIT"] ?></h1><br>
		<?php
		if ($send == 1) {
			if ($num_rows > 0 && $username != $oldUsername) {
				echo "<font color=" . $colorArray["ERROR"] . ">" . $translations["AGENT_ALREADY_EXIST"] . "</font><br><br>";
			} else {
				echo "<font color=" . $colorArray["SUCCESS_REGISTER_BACKGROUND"] . ">" . $translations["SUCCESS_UPDATE_AGENT_DATA"] . "</font><br><br>";
			}
		}
		?>
		<label id=asteriskWarning><?php echo $translations["ASTERISK_MARK_MANDATORY"] ?> (<mark id=asterisk>*</mark>)</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idUser = $result["id"];
				$username = $result[$dbAgentArray["USERNAME"]];
				$oldUsername = $result[$dbAgentArray["USERNAME"]];
				$name = $result[$dbAgentArray["NAME"]];
				$surname = $result[$dbAgentArray["SURNAME"]];
				$role = $result[$dbAgentArray["ROLE"]];
				$privilegeLevel = $result[$dbAgentArray["PRIVILEGE_LEVEL"]];
				$lastLoginDate = $result[$dbAgentArray["LAST_LOGIN_DATE"]];
				$blocked = $result[$dbAgentArray["BLOCKED"]];
			?>
				<tr>
					<td colspan=3 id=section-header><?php echo $translations["AGENT_DATA"] ?></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["USERNAME"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdUser value="<?php echo $idUser; ?>">
					<input type=hidden name=txtOldUsername value="<?php echo $oldUsername; ?>">
					<td><input type=text name=txtUser required value="<?php echo $username; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["AGENT_NAME"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtName required value="<?php echo $name; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["AGENT_SURNAME"] ?><mark id=asterisk>*</mark></td>
					<td><input type=text name=txtSurname required value="<?php echo $surname; ?>"></td>
				</tr>
				<tr>
					<td id=lblFixed><?php echo $translations["PRIVILEGE"]["NAME"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtPrivilegeLevel required onclick="var input = document.getElementById('eraseButton'); if(this.checked){ input.disabled=false;}else{input.disabled=true;}" <?php if ($_SESSION["id"] == $idUser) { ?> id=inactive disabled <?php } ?>>
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
					<td id=lblFixed>
						<?php echo $translations["BLOCKED_AGENT"] ?>
					</td>
					<td colspan=5><input type=checkbox class=chkBox name=chkBoxBlocked value="1" <?php echo ($blocked == 1 ? "checked" : ""); ?> <?php if ($_SESSION["id"] == $idUser) { ?> id=inactive disabled <?php } ?>></td>
				</tr>
			<?php
			}
			if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["LIMITED_LEVEL"]) {
			?>
				<tr>
					<td id=h-separator colspan=3 align=center><input id="updateButton" type=submit value=<?php echo $translations["LABEL_UPDATE_BUTTON"] ?>></td>
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