<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$employeeRegistrationNumber = $_GET["employeeRegistrationNumber"];
?>

<div id="middle">
	<h2><?php echo $translations["ERROR_ADD_EMPLOYEE"] ?></h2><br><br>
	<?php echo $translations["EMPLOYEE_ALREADY_EXIST"] ?><br><br><br>
	<a href="formAddEmployee.php">[<?php echo $translations["ADD_ANOTHER"] ?>]</a><br>
	<a href="index.php">[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
</div>

<?php
require_once("foot.php");
?>