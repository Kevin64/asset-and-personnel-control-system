<?php

require_once("checkSession.php");
require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query = mysqli_query($connection, "delete from users where id = '$delete[$i]'") or die($translations["ERROR_DELETE_USER"] . mysqli_error($connection));
		if ($_SESSION["id"] == $delete[$i]) {
			$_SESSION = array();
			header("Location: index.php");
		}
	}
}

if (isset($_SESSION["id"]))
	header("Location: queryUser.php?del=ok");
