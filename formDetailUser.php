<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$idUser = $_GET["id"];
	$query = mysqli_query($connection, "select * from users where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));
} else {
	if (isset($_POST["txtIdUser"]))
		$idUser = $_POST["txtIdUser"];
	if (isset($_POST["txtUser"]))
		$username = $_POST["txtUser"];
	if (isset($_POST["txtPrivilegeLevel"]))
		$privilegeLevel = $_POST["txtPrivilegeLevel"];
	if (isset($_POST["txtLastLoginDate"]))
		$lastLoginDate = $_POST["txtLastLoginDate"];

	//currentizando os dados do agente
	mysqli_query($connection, "update users set username = '$username', privilegeLevel = '$privilegeLevel' where id = '$idUser'") or die($translations["ERROR_UPDATE_USER_DATA"] . mysqli_error($connection));

	$query = mysqli_query($connection, "select * from users where id = '$idUser'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));
}
?>

<div id="middle">
	<form action="formDetailUser.php" method="post" id="formGeneral">
		<input type=hidden name=txtSend value="1">
		<h2>Detalhes do agente</h2><br>
		<?php
		if ($send == 1) {
			echo "<font color=blue>" . $translations["SUCCESS_UPDATE_USER_DATA"] . "</font><br><br>";
		}
		?>
		<label id=asteriskWarning>Os campos branddos com asterisco (<mark id=asterisk>*</mark>) são obrigatórios!</label>
		<table id="formFields">
			<?php
			while ($result = mysqli_fetch_array($query)) {
				$idUser = $result["id"];
				$username = $result["username"];
				$privilegeLevel = $result["privilegeLevel"];
				$lastLoginDate = $result["lastLoginDate"];
			?>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["USER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["USER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIdUser value="<?php echo $idUser; ?>">
					<td><input type=text name=txtUser required value="<?php echo $username; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["PRIVILEGE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtPrivilegeLevel required>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value=<?php echo $privilegeLevelsArray["ADMINISTRATOR_LEVEL"] ?> <?php if ($privilegeLevel == $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["ADMINISTRATOR_NAME"] ?></option>
							<option value=<?php echo $privilegeLevelsArray["STANDARD_LEVEL"] ?> <?php if ($privilegeLevel == $privilegeLevelsArray["STANDARD_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["STANDARD_NAME"] ?></option>
							<option value=<?php echo $privilegeLevelsArray["LIMITED_LEVEL"] ?> <?php if ($privilegeLevel == $privilegeLevelsArray["LIMITED_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["LIMITED_NAME"] ?></option>
						</select>
					</td>
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