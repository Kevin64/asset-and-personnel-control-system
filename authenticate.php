<?php
require_once("connection.php");

$send = $_POST["txtSend"];
$username = $_POST["txtUser"];
$queryResult = mysqli_query($connection, "select " . $dbAgentsArray["PASSWORD"] . " from " . $dbAgentsArray["AGENTS_TABLE"] . " where " . $dbAgentsArray["USERNAME"] . " = '$username'") or die($translations["USER_NOT_EXIST"] . mysqli_error($connection));
$getPassword = mysqli_fetch_assoc($queryResult);
$password = $getPassword["password"];
$verifyPassword = password_verify($_POST["txtPassword"], $password);

if ($verifyPassword) {
	$queryAuthenticate = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . " where " . $dbAgentsArray["USERNAME"] . " = '$username'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$total = mysqli_num_rows($queryAuthenticate);
	$lastLoginDate = date("Y-m-d H:i:s");

	if ($total > 0) {
		session_start();
		while ($row = mysqli_fetch_assoc($queryAuthenticate)) {
			$id = $row["id"];
			$username = $row[$dbAgentsArray["USERNAME"]];
			$privilegeLevel = $row[$dbAgentsArray["PRIVILEGE_LEVEL"]];
		}
		$_SESSION["id"] = $id;
		$_SESSION["username"] = $username;
		$_SESSION["privilegeLevel"] = $privilegeLevel;
		mysqli_query($connection, "update " . $dbAgentsArray["AGENTS_TABLE"] . " set " . $dbAgentsArray["LAST_LOGIN_DATE"] . " = '$lastLoginDate' where " . $dbAgentsArray["USERNAME"] . " = '$username'") or die($translations["ERROR_CHANGE_USER_STATUS"] . mysqli_error($connection));

		header("Location: index.php");
	} else {
		header("Location: denied.php");
	}
} else {
	header("Location: denied.php");
}
