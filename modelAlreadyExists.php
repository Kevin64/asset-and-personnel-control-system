<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$modelo = $_GET["modelo"];
?>

<div id="meio">
	<h2><?php echo $translations["ERROR_ADD_MODEL"] ?></h2><br><br>
	O modelo <strong><?php echo $modelo; ?></strong> já está cadastrado no banco de dados!<br><br><br>
	<a href="frmCadBIOS.php">[<?php echo $translations["ADD_ANOTHER"] ?>]</a><br>
	<a href="index.php">[<?php echo $translations["BACK_TO_HOME"] ?>]</a>
</div>

<?php
require_once("foot.php");
?>