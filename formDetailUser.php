<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$send = null;

if (isset($_POST["txtSend"]))
	$send = $_POST["txtSend"];

if ($send != 1) {
	$iduser = $_GET["id"];
	$query = mysqli_query($connection, "select * from users where id = '$iduser'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));
} else {
	if (isset($_POST["txtIduser"]))
		$iduser = $_POST["txtIduser"];
	if (isset($_POST["txtuser"]))
		$username = $_POST["txtuser"];
	if (isset($_POST["txtstatus"]))
		$privilegeLevel = $_POST["txtstatus"];

	//currentizando os dados do agente
	mysqli_query($connection, "update users set user = '$username', status = '$privilegeLevel' where id = '$iduser'") or die($translations["ERROR_UPDATE_USER_DATA"] . mysqli_error($connection));

	$query = mysqli_query($connection, "select * from users where id = '$iduser'") or die($translations["ERROR_SHOW_DETAIL_USER"] . mysqli_error($connection));
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
				$iduser = $result["id"];
				$username = $result["user"];
				$privilegeLevel = $result["status"];
			?>
				<tr>
					<td colspan=2 id=spacer><?php echo $translations["USER_DATA"] ?></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["USER"] ?><mark id=asterisk>*</mark></td>
					<input type=hidden name=txtIduser value="<?php echo $iduser; ?>">
					<td><input type=text name=txtuser required value="<?php echo $username; ?>"></td>
				</tr>
				<tr>
					<td id="label"><?php echo $translations["PRIVILEGE"] ?><mark id=asterisk>*</mark></td>
					<td>
						<select name=txtstatus required>
							<option disabled selected value> <?php echo $translations["SELECT_AN_OPTION"] ?> </option>
							<option value="Administrador" <?php if ($privilegeLevel == $json_config_array["PrivilegeLevels"]["ADMIN_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["ADMIN"] ?></option>
							<option value="Padrão" <?php if ($privilegeLevel == $json_config_array["PrivilegeLevels"]["STANDARD_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["STD"] ?></option>
							<option value="Limitado" <?php if ($privilegeLevel == $json_config_array["PrivilegeLevels"]["LIMITED_LEVEL"]) echo "selected='selected'"; ?>><?php echo $translations["LIMIT"] ?></option>
						</select>
					</td>
				</tr>
			<?php
			}
			if ($_SESSION["privilegeLevel"] != $json_config_array["PrivilegeLevels"]["LIMITED_LEVEL"]) {
			?>
				<tr>
					<td colspan=2 align=center><br><input id="updateButton" type=submit value=currentizar></td>
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