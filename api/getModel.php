<?php

header("Content-Type:application/json; charset=UTF-8");

if (isset($_GET["model"]) && $_GET["model"] != "") {
	$model = $_GET["model"];
	include("../connection.php");
	$query = mysqli_query($connection, "select * from " . $dbModelArray["MODEL_TABLE"] . " where " . $dbModelArray["MODEL"] . " = '$model'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$jsonCmd = json_encode($row, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		}
		echo $jsonCmd;
	}
}
