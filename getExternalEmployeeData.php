<?php
require_once("connection.php");

$deliveredToRegistrationNumber = $_GET["employeeRegistrationNumber"];
$name = $_GET["name"];
$email = strtoupper($_GET["email"]);
$phoneExtension = strtoupper($_GET["extNum"]);
$phoneNumber = strtoupper($_GET["phone"]);
$sector = strtoupper($_GET["sector"]);
$roomNumber = strtoupper($_GET["roomNumber"]);
$faltas = strtoupper($_GET["faltas"]);
$data_ultima_falta = strtoupper($_GET["data_ultima_falta"]);

$queryGetEmployee = mysqli_query($connection, "select * from employee where employeeRegistrationNumber = '$deliveredToRegistrationNumber'") or die("Erro na query! " . mysqli_error($connection));
$total = mysqli_num_rows($queryGetEmployee);

if ($total >= 1) {
	$query = mysqli_query($connection, "update employee set employeeRegistrationNumber = '$deliveredToRegistrationNumber', name = '$name', email = '$email', extNum = '$phoneExtension', phone = '$phoneNumber', sector = '$sector', roomNumber = '$roomNumber', faltas = '$faltas', data_ultima_falta = '$data_ultima_falta'") or die("Erro na query de currentização! " . mysqli_error($connection));
	$message = $translations["UPDATED_DATA_SUCCESS"];
} else {
	$query = mysqli_query($connection, "insert into employee (employeeRegistrationNumber, name, email, extNum, phone, sector, roomNumber) values('$deliveredToRegistrationNumber', '$name', '$email', '$phoneExtension', '$phoneNumber', '$sector', '$roomNumber', '$faltas', '$data_ultima_falta')") or die("Erro ao incluir os dados! " . mysqli_error($connection));
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