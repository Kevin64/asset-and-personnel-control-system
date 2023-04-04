<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$teacherRegistrationNumber = $_GET["teacherRegistrationNumber"];
?>

<div id="middle">
	<h2><?php echo $translations["ERROR_ADD_TEACHER"] ?></h2><br><br>
	<?php echo $translations["TEACHER_ALREADY_EXIST"] ?><br><br><br>
	<a href="formAddTeacher.php">[<?php echo $translations["ADD_ANOTHER"] ?>]</a><br>
	<a href="index.php">[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
</div>

<?php
require_once("foot.php");
?>