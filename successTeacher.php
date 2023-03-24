<?php
require_once("top.php");
?>

<div id="meio">
	<h2><?php echo $translations["SUCCESS_ADD_TEACHER"] ?></h2><br><br><br>
	<a href=formAddTeacher.php>[<?php echo $translations["ADD_ANOTHER"] ?></a> &nbsp;&nbsp;&nbsp; <a href=queryTeacher.php>[<?php echo $translations["SEE_TEACHER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
</div>

<?php
require_once("foot.php");
?>