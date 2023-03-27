<?php
require_once("connection.php");

$message = $translations["SUCCESS_USER_DATA_EXPORT"];

if(isset($_GET["user"]))
	$username = $_GET["user"];
if(isset($_GET["password"]))
	$password = $_GET["password"];
if(isset($_GET["status"]))
	$privilegeLevel = $_GET["status"];
if(isset($_GET["status"]))
	$privilegeLevel = $_GET["status"];

$loginFile = __DIR__."/output/login.json";
$loginChecksum = __DIR__."/output/login-checksum.txt";

$query = mysqli_query($connection, "select * from users") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$return_arr = array();

if (file_exists($loginFile) || file_exists($loginChecksum)) {
	unlink($loginFile);
	unlink($loginChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array["id"] = $row["id"];
	$row_array["user"] = $row["user"];
	$row_array["password"] = $row["password"];
	$row_array["status"] = $row["status"];
	$row_array["status"] = $row["status"];
	array_push($return_arr, $row_array);

	$fp = fopen($loginFile, "w");
	$jsonCmd = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
	fwrite($fp, $jsonCmd);
	$checksum = hash("sha256", $jsonCmd);
	$fp2 = fopen($loginChecksum, "w");
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
}

if(!isset($row_array)) {
	$fp = fopen($loginFile, "w");
	fwrite($fp, json_encode($return_arr));
	$checksum = hash("sha256", json_encode($return_arr));
	$fp2 = fopen($loginChecksum, "w");
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