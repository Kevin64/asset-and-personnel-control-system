<?php
require_once("top.php");
?>

<div id="middle">
	<h2><?php echo $translations["SUCCESS_ADD_EMPLOYEE"] ?></h2><br><br><br>
	<a href=formAddEmployee.php>[<?php echo $translations["ADD_ANOTHER"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=queryEmployee.php>[<?php echo $translations["SEE_EMPLOYEE_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
</div>

<?php
require_once("foot.php");
?>