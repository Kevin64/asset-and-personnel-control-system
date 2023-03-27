<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$username = $_POST["txtUser"];
if ($_POST["txtPassword"] != "") {
	$password = password_hash($_POST["txtPassword"], PASSWORD_BCRYPT);
} else {
	$password = null;
}
$privilegeLevel = $_POST["txtStatus"];

$query = mysqli_query($connection, "select * from users where user = '$username'") or die($translations["ERROR_ADD_USER"] . mysqli_error($connection));
$total = mysqli_num_rows($query);

if ($total > 0) {
?>
	<div id="middle">
		<h2><?php echo $translations["USER_ALREADY_EXIST"] ?></h2><br><br>
		<a href=queryUser.php>[<?php echo $translations["USER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_HOME"] ?>]</a>
	</div>
	<?php
} else {
	if ($password != null) {
		mysqli_query($connection, "insert into users (user, password, status, status) values ('$username', '$password', '$privilegeLevel', '$privilegeLevel')") or die($translations["ERROR_ADD_USER"] . mysqli_error($connection));
	?>
		<div id="middle">
			<h2><?php echo $translations["SUCCESS_ADD_USER"] ?></h2><br><br>
			<a href=frmAdduser.php>[<?php echo $translations["ADD_ANOTHER"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=consultaruser.php>[<?php echo $translations["USER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_HOME"] ?>]</a>
		</div>
	<?php
	} else {
	?>
		<div id="middle">
			<h2><?php echo $translations["ERROR_PASSWORD_BLANK"] ?></h2><br><br>
			<a href=queryUser.php>[<?php echo $translations["USER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_HOME"] ?>]</a>
		</div>
<?php
	}
}
require_once("foot.php");
?>