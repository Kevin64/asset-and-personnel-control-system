<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query = mysqli_query($connection, "delete from teacher where id = '$delete[$i]'") or die($translations["ERROR_DELETE_TEACHER"] . mysqli_error($connection));
	}
}

header("Location: queryTeacher.php?del=ok");
