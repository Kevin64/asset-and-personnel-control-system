<?php

header("Content-Type:application/json");

if (isset($_GET["model"]) && $_GET["model"] != "") {
	$model = $_GET["model"];
	include("../connection.php");
	$query = mysqli_query($connection, "select * from " . $dbModelArray["MODEL_TABLE"] . " where " . $dbModelArray["MODEL"] . " = '$model'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));

	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$row_array["id"] = $row["id"];
			$row_array["brand"] = $row[$dbModelArray["BRAND"]];
			$row_array["model"] = $row[$dbModelArray["MODEL"]];
			$row_array["fwVersion"] = $row[$dbModelArray["FW_VERSION"]];
			$row_array["fwType"] = $row[$dbModelArray["FW_TYPE"]];
			$row_array["tpmVersion"] = $row[$dbModelArray["TPM_VERSION"]];
			$row_array["mediaOperationMode"] = $row[$dbModelArray["MEDIA_OPERATION_MODE"]];
			$jsonCmd = json_encode($row_array, JSON_UNESCAPED_UNICODE);
		}
		echo $jsonCmd;
	}
}
