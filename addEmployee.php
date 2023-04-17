<?php
require_once("checkSession.php");
require_once("connection.php");

$employeeRegistrationNumber = $_POST["txtEmployeeRegistrationNumber"];
$employeeType = $_POST["txtEmployeeType"];
$name = $_POST["txtName"];
$email = $_POST["txtEmail"];
$phoneExtension = $_POST["txtPhoneExtension"];
$phoneNumber = $_POST["txtPhoneNumber"];
$sector = $_POST["txtSector"];
$roomNumber = $_POST["txtRoomNumber"];

$validateEmployee = mysqli_query($connection, "select * from employee where employeeRegistrationNumber = '$employeeRegistrationNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$totalEmployee = mysqli_num_rows($validateEmployee);

if ($totalEmployee == 0) {
	mysqli_query($connection, "insert into employee (employeeRegistrationNumber, employeeType, name, email, phoneExtension, phoneNumber, sector, roomNumber) values ('$employeeRegistrationNumber', '$employeeType', '$name', '$email', '$phoneExtension', '$phoneNumber', '$sector', '$roomNumber')") or die($translations["ERROR_ADD_EMPLOYEE"] . mysqli_error($connection));

	header("Location: successEmployee.php");
} else
	header("Location: employeeAlreadyExists.php?employeeRegistrationNumber='$employeeRegistrationNumber'");
