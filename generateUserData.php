<?php
require_once("connection.php");

$message = $translations["SUCCESS_USER_DATA_EXPORT"];

if (isset($_GET["username"]))
	$username = $_GET["username"];
if (isset($_GET["password"]))
	$password = $_GET["password"];
if (isset($_GET["privilegeLevel"]))
	$privilegeLevel = $_GET["privilegeLevel"];
if (isset($_GET["lastLoginDate"]))
	$lastLoginDate = $_GET["lastLoginDate"];

$usersFile = __DIR__ . "/output/users.json";
$usersChecksum = __DIR__ . "/output/users-checksum.txt";

$query = mysqli_query($connection, "select * from " . $dbAgentsArray["AGENTS_TABLE"] . "") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$return_arr = array();

if (file_exists($usersFile) || file_exists($usersChecksum)) {
	unlink($usersFile);
	unlink($usersChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array["id"] = $row["id"];
	$row_array["username"] = $row[$dbAgentArray["USERNAME"]];
	$row_array["password"] = $row[$dbAgentArray["PASSWORD"]];
	$row_array["privilegeLevel"] = $row[$dbAgentArray["PRIVILEGE_LEVEL"]];
	$row_array["lastLoginDate"] = $row[$dbAgentArray["LAST_LOGIN_DATE"]];
	array_push($return_arr, $row_array);

	$fp = fopen($usersFile, "w");
	$jsonCmd = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
	fwrite($fp, $jsonCmd);
	$checksum = hash("sha256", $jsonCmd);
	$fp2 = fopen($usersChecksum, "w");
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
}

if (!isset($row_array)) {
	$fp = fopen($usersFile, "w");
	fwrite($fp, json_encode($return_arr));
	$checksum = hash("sha256", json_encode($return_arr));
	$fp2 = fopen($usersChecksum, "w");
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
}

?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body bgcolor=blue>
	<center>
		<font size=3 color=white><b><?php echo $message; ?></b></font>
	</center>
</body>

</html>