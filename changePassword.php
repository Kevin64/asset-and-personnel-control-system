<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$message = "";

$idUser = null;
$username = $_POST["txtUser"];
$newPassword = password_hash($_POST["txtPassword1"], PASSWORD_BCRYPT);
$verifyPasswordAlt = password_verify($_POST["txtPassword2"], $newPassword);

$query = mysqli_query($connection, "select * from users where username = '$username'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

while ($row = mysqli_fetch_array($query)) {
	$idUser = $row["id"];
	$password = $row["password"];
}

if (mysqli_num_rows($query) == 0) {
	$message = "<font color=red>" . $translations["USER_NOT_EXIST"] . "</font>";
} else {
	if ($_SESSION["privilegeLevel"] != $privilegeLevelsArray["ADMINISTRATOR_LEVEL"]) {
		$currentPassword = password_verify($_POST["txtCurrentPassword"], $password);
		if ($verifyPasswordAlt) {
			if ($password == $currentPassword) {
				$queryChangePassword = mysqli_query($connection, "update users set password = '$newPassword' where id = '$idUser'") or die($translations["ERROR_UPDATE_PASSWORD"] . mysqli_error($connection));
				$message = "<font color=blue>" . $translations["SUCCESS_UPDATE_PASSWORD"] . "</font>";
			} else {
				$message = "<font color=red>" . $translations["OLD_PASSWORD_NOT_MATCH"] . "</font>";
			}
		} else {
			$message = "<font color=red>" . $translations["TWO_PASSWORD_NOT_MATCH"] . "</font>";
		}
	} else {
		if ($verifyPasswordAlt) {
			$queryChangePassword = mysqli_query($connection, "update users set password = '$newPassword' where id = '$idUser'") or die($translations["ERROR_UPDATE_PASSWORD"] . mysqli_error($connection));
			$message = "<font color=blue>" . $translations["SUCCESS_UPDATE_PASSWORD"] . "</font>";
		} else {
			$message = "<font color=red>" . $translations["TWO_PASSWORD_NOT_MATCH"] . "</font>";
		}
	}
}
?>

<div id="middle">
	<h2><?php echo $translations["CHANGE_PASSWORD"] ?></h2><br><br>
	<?php echo $message; ?><Br><Br>
	<a href=formChangePassword.php>[<?php echo $translations["BACK"] ?>]</a>

</div>

<?php
require_once("foot.php");
?>