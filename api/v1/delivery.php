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
		if (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST") {
			$json = file_get_contents('php://input');
			$newAsset = json_decode($json, true);

			$assetTable = $dbAssetArray["ASSET_TABLE"];
			$assetNumber = $dbAssetArray["ASSET_NUMBER"];
			$assetNumberFK = $dbAssetArray["ASSET_NUMBER_FK"];

			$locationTable = $dbLocationArray["LOCATION_TABLE"];
			$deliveredToRegistrationNumber = $dbLocationArray["LOC_DELIVERED_TO_REGISTRATION_NUMBER"];
			$lastDeliveryMadeBy = $dbLocationArray["LOC_LAST_DELIVERY_MADE_BY"];
			$lastDeliveryDate = $dbLocationArray["LOC_LAST_DELIVERY_DATE"];

			$assetJsonSection = $newAsset;
			$locationJsonSection = $newAsset["location"];

			$queryGetAsset = mysqli_query($connection, "select * from " . $assetTable . " where " . $assetNumber . " = " . $newAsset[$assetNumber]) or die($translations["ERROR_QUERY"] . mysqli_error($connection));
			$total = mysqli_num_rows($queryGetAsset);

			if ($total >= 1) {
				$queryAssetLocation = mysqli_query($connection, "update " . $locationTable . " set " .
					$deliveredToRegistrationNumber . " = '$locationJsonSection[$deliveredToRegistrationNumber]', " .
					$lastDeliveryMadeBy . " = '$locationJsonSection[$lastDeliveryMadeBy]', " .
					$lastDeliveryDate . " = '$locationJsonSection[$lastDeliveryDate]'
			where " . $assetNumberFK . " = '$newAsset[$assetNumber]';
			") or die($translations["ERROR_QUERY_UPDATE"] . mysqli_error($connection));
				http_response_code(200);
				echo "Ativo atualizado\n";
			}
			header("Connection: close");
		} else {
			$row1 = array("message" => "Invalid asset number");
			$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			http_response_code(400);
			echo $jsonFinal;
		}
	} else {
		$row1 = array("message" => "Unauthorized request");
		$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		http_response_code(401);
		echo $jsonFinal;
	}
} else {
	$row1 = array("message" => "Unauthorized request");
	$jsonFinal = json_encode($row1, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	http_response_code(401);
	echo $jsonFinal;
}
