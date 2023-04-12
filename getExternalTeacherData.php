<?php
require_once("connection.php");

$deliveredToRegistrationNumber = $_GET["teacherRegistrationNumber"];
$name = $_GET["name"];
$email = strtoupper($_GET["email"]);
$phoneExtension = strtoupper($_GET["extNum"]);
$phoneNumber = strtoupper($_GET["phone"]);
$course = strtoupper($_GET["course"]);
$roomNumber = strtoupper($_GET["roomNumber"]);
$faltas = strtoupper($_GET["faltas"]);
$data_ultima_falta = strtoupper($_GET["data_ultima_falta"]);

$queryGetTeacher = mysqli_query($connection, "select * from teacher where teacherRegistrationNumber = '$deliveredToRegistrationNumber'") or die("Erro na query! " . mysqli_error($connection));
$total = mysqli_num_rows($queryGetTeacher);

if ($total >= 1) {
	$query = mysqli_query($connection, "update teacher set teacherRegistrationNumber = '$deliveredToRegistrationNumber', name = '$name', email = '$email', extNum = '$phoneExtension', phone = '$phoneNumber', course = '$course', roomNumber = '$roomNumber', faltas = '$faltas', data_ultima_falta = '$data_ultima_falta'") or die("Erro na query de currentização! " . mysqli_error($connection));
	$message = $translations["UPDATED_DATA_SUCCESS"];
} else {
	$query = mysqli_query($connection, "insert into teacher (teacherRegistrationNumber, name, email, extNum, phone, course, roomNumber) values('$deliveredToRegistrationNumber', '$name', '$email', '$phoneExtension', '$phoneNumber', '$course', '$roomNumber', '$faltas', '$data_ultima_falta')") or die("Erro ao incluir os dados! " . mysqli_error($connection));
	$message = $translations["REGISTERED_DATA"];
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