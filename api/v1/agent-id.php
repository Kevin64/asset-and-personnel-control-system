<?php

header("Content-Type:application/json; charset=UTF-8");

if (strtoupper($_SERVER["REQUEST_METHOD"]) == "GET" && isset($_GET["id"]) && $_GET["id"] != "") {
	$id = $_GET["id"];
	include("../../connection.php");
	$query = mysqli_query($connection, "select id, " . $dbAgentArray["NAME"] . ", " . $dbAgentArray["SURNAME"] . " from " . $dbAgentArray["AGENTS_TABLE"] . " where id = '$id'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$jsonCmd = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		}
		http_response_code(200);
		echo $jsonCmd;
	}
	else {
		$row1 = array("message" => "Not Found");
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		http_response_code(404);
		echo $jsonFinal;
	}
}
else {
	$row1 = array("message" => "Invalid id number");
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	echo $jsonFinal;
	http_response_code(400);
}