<?php

header("Content-Type:application/json; charset=UTF-8");

if (isset($_GET["username"]) && $_GET["username"] != "") {
	$username = $_GET["username"];
	include("../connection.php");
	$query = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where " . $dbAgentArray["USERNAME"] . " = '$username'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$row_array["id"] = $row["id"];
			$row_array["username"] = $row[$dbAgentArray["USERNAME"]];
			$row_array["password"] = $row[$dbAgentArray["PASSWORD"]];
			$row_array["privilegeLevel"] = $row[$dbAgentArray["PRIVILEGE_LEVEL"]];
			$row_array["lastLoginDate"] = $row[$dbAgentArray["LAST_LOGIN_DATE"]];
			$jsonCmd = json_encode($row_array, JSON_UNESCAPED_UNICODE);
		}
		echo $jsonCmd;
	}
}
