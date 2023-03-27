<?php

require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query = mysqli_query($connection, "delete from users where id = '$delete[$i]'") or die($translations["ERROR_DELETE_USER"] . mysqli_error($connection));
	}
}

header("Location: queryUser.php?del=ok");