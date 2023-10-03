<?php

header("Content-Type:application/json; charset=UTF-8");

if (isset($_GET["model"]) && $_GET["model"] != "") {
	$model = $_GET["model"];
	if(str_contains($model, "-")) {
		$model = str_replace("-", " ", $model);
	}
	include("../connection.php");
	$query = mysqli_query($connection, "select " . $dbModelArray["BRAND"] . ", " . $dbModelArray["MODEL"] . ", " . $dbModelArray["FW_VERSION"] . ", " . $dbModelArray["FW_TYPE"] . ", " . $dbModelArray["TPM_VERSION"] . ", " . $dbModelArray["MEDIA_OPERATION_MODE"] . " from " . $dbModelArray["MODEL_TABLE"] . " where " . $dbModelArray["MODEL"] . " = '$model'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

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
