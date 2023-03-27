<?php
require_once("connection.php");

$send = $_POST["txtSend"];
$username = $_POST["txtUser"];
$queryResult = mysqli_query($connection, "select password from users where username = '$username'") or die($translations["USER_NOT_EXIST"] . mysqli_error($connection));
$getPassword = mysqli_fetch_assoc($queryResult);
$password = $getPassword["password"];
$verifyPassword = password_verify($_POST["txtPassword"], $password);

if ($verifyPassword) {
	$queryAuthenticate = mysqli_query($connection, "select * from users where username = '$username'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$total = mysqli_num_rows($queryAuthenticate);

	if ($total > 0) {
		session_start();
		while ($row = mysqli_fetch_assoc($queryAuthenticate)) {
			$id = $row["id"];
			$username = $row["username"];
			$privilegeLevel = $row["privilegeLevel"];
		}
		$_SESSION["id"] = $id;
		$_SESSION["username"] = $username;
		$_SESSION["privilegeLevel"] = $privilegeLevel;
		mysqli_query($connection, "update users set status = 1 where username = '$username'") or die($translations["ERROR_CHANGE_USER_STATUS"] . mysqli_error($connection));

		header("Location: index.php");
	} else {
		header("Location: denied.php");
	}
} else {
	header("Location: denied.php");
}
