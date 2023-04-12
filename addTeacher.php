<?php
require_once("checkSession.php");
require_once("connection.php");

$teacherRegistrationNumber = $_POST["txtTeacherRegistrationNumber"];
$employeeType = $_POST["txtEmployeeType"];
$name = $_POST["txtName"];
$email = $_POST["txtEmail"];
$phoneExtension = $_POST["txtPhoneExtension"];
$phoneNumber = $_POST["txtPhoneNumber"];
$course = $_POST["txtCourse"];
$roomNumber = $_POST["txtRoomNumber"];

$validateTeacher = mysqli_query($connection, "select * from teacher where teacherRegistrationNumber = '$teacherRegistrationNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$totalTeacher = mysqli_num_rows($validateTeacher);

if ($totalTeacher == 0) {
	mysqli_query($connection, "insert into teacher (teacherRegistrationNumber, employeeType, name, email, phoneExtension, phoneNumber, course, roomNumber) values ('$teacherRegistrationNumber', '$employeeType', '$name', '$email', '$phoneExtension', '$phoneNumber', '$course', '$roomNumber')") or die($translations["ERROR_ADD_TEACHER"] . mysqli_error($connection));

	header("Location: successTeacher.php");
} else
	header("Location: teacherAlreadyExists.php?teacherRegistrationNumber='$teacherRegistrationNumber'");
