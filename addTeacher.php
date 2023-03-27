<?php
require_once("checkSession.php");
require_once("connection.php");

$deliveredToRegistrationNumber = $_POST["txtRegNum"];
$typeEmployee = $_POST["txtTypeEmployee"];
$name = $_POST["txtname"];
$email = $_POST["txtEmail"];
$extNum = $_POST["txtExtNum"];
$phone = $_POST["txtPhone"];
$course = $_POST["txtCourse"];
$room = $_POST["txtRoom"];

$validateTeacher = mysqli_query($connection, "select * from teacher where regNum = '$deliveredToRegistrationNumber'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$totalTeacher = mysqli_num_rows($validateTeacher);

if ($totalTeacher == 0) {
	mysqli_query($connection, "insert into teacher (regNum, typeEmployee, name, email, extNum, phone, course, room) values ('$deliveredToRegistrationNumber', '$typeEmployee', '$name', '$email', '$extNum', '$phone', '$course', '$room')") or die($translations["ERROR_ADD_TEACHER"] . mysqli_error($connection));

	header("Location: successTeacher.php");
} else
	header("Location: teacherAlreadyExists.php?regNum='$deliveredToRegistrationNumber'");
