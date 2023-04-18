<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$delete = $_POST["chkDelete"];

if (isset($delete)) {
	for ($i = 0; $i < count($delete); $i++) {
		$query = mysqli_query($connection, "delete from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where id = '$delete[$i]'") or die($translations["ERROR_DELETE_EMPLOYEE"] . mysqli_error($connection));
	}
}

header("Location: queryEmployee.php?del=ok");
