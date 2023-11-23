<?php

header("Content-Type:application/json; charset=UTF-8");
header("WWW-Authenticate: Basic");

if (isset($_SERVER["HTTP_AUTHORIZATION"]) && $_SERVER["HTTP_AUTHORIZATION"] != "") {
	require("../../connection.php");

	$auth = $_SERVER["HTTP_AUTHORIZATION"];
	$auth_array1 = explode(" ", $auth);
	$auth_array2 = explode(":", base64_decode($auth_array1[1]));
	$agent = $auth_array2[0];
	$password = $auth_array2[1];

	$queryAuthenticate = mysqli_query($connection, "select * from " . $dbAgentArray["AGENTS_TABLE"] . " where " . $dbAgentArray["USERNAME"] . " = '$agent'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
	$total = mysqli_num_rows($queryAuthenticate);
	$row = mysqli_fetch_array($queryAuthenticate);
	if ($total > 0 && password_verify($password, $row[$dbAgentArray["PASSWORD"]])) {
		if (strtoupper($_SERVER["REQUEST_METHOD"]) == "GET" && isset($_GET["username"]) && $_GET["username"] != "") {
			$username = $_GET["username"];
			$query = mysqli_query($connection, "select id, " . $dbAgentArray["USERNAME"] . ", " . $dbAgentArray["PASSWORD"] . ", " . $dbAgentArray["NAME"] . ", " . $dbAgentArray["SURNAME"] . ", " . $dbAgentArray["PRIVILEGE_LEVEL"] . ", " . $dbAgentArray["LAST_LOGIN_DATE"] . ", " . $dbAgentArray["BLOCKED"] . " from " . $dbAgentArray["AGENTS_TABLE"] . " where " . $dbAgentArray["USERNAME"] . " = '$username'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

			if (mysqli_num_rows($query) > 0) {
				while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
					$jsonCmd = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
				}
				http_response_code(200);
				echo $jsonCmd;
			} else {
				$row1 = array("message" => "Not Found");
				$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
				http_response_code(204);
				echo $jsonFinal;
			}
		} else {
			$row1 = array("message" => "Invalid username");
			$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			echo $jsonFinal;
			http_response_code(400);
		}
	} else {
		$row1 = array("message" => "Unauthorized request");
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		echo $jsonFinal;
		http_response_code(401);
	}
} else {
	$row1 = array("message" => "Unauthorized request");
	$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	echo $jsonFinal;
	http_response_code(401);
}
