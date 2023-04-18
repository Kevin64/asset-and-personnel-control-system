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

$validateEmployee = mysqli_query($connection, "select * from " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " where " . $dbEmployeeArray["EMPLOYEE_REGISTRATION_NUMBER"] . " = '$employeeRegistrationNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$totalEmployee = mysqli_num_rows($validateEmployee);

if ($totalEmployee == 0) {
	mysqli_query($connection, "insert into " . $dbEmployeeArray["EMPLOYEE_TABLE"] . " (" . $dbEmployeeArray["EMPLOYEE_REGISTRATION_NUMBER"] . ", " . $dbEmployeeArray["EMPLOYEE_TYPE"] . ", " . $dbEmployeeArray["NAME"] . ", " . $dbEmployeeArray["EMAIL"] . ", " . $dbEmployeeArray["PHONE_EXTENSION"] . ", " . $dbEmployeeArray["PHONE_NUMBER"] . ", " . $dbEmployeeArray["SECTOR"] . ", " . $dbEmployeeArray["ROOM_NUMBER"] . ") values ('$employeeRegistrationNumber', '$employeeType', '$name', '$email', '$phoneExtension', '$phoneNumber', '$sector', '$roomNumber')") or die($translations["ERROR_ADD_EMPLOYEE"] . mysqli_error($connection));

	header("Location: successEmployee.php");
} else
	header("Location: employeeAlreadyExists.php?employeeRegistrationNumber='$employeeRegistrationNumber'");
