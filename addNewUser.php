<?php
require_once("checkSession.php");
require_once("top.php");
require_once("connection.php");

$usuario = $_POST["txtUsuario"];
if ($_POST["txtSenha"] != "") {
	$senha = password_hash($_POST["txtSenha"], PASSWORD_BCRYPT);
} else {
	$senha = null;
}
$nivel = $_POST["txtNivel"];
$status = $_POST["txtStatus"];

$query = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario'") or die($translations["ERROR_ADD_USER"] . mysqli_error($conexao));
$total = mysqli_num_rows($query);

if ($total > 0) {
?>
	<div id="meio">
		<h2><?php echo $translations["USER_ALREADY_EXIST"] ?></h2><br><br>
		<a href=queryUser.php>[<?php echo $translations["USER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_HOME"] ?>]</a>
	</div>
	<?php
} else {
	if ($senha != null) {
		mysqli_query($conexao, "insert into usuarios (usuario, senha, nivel, status) values ('$usuario', '$senha', '$nivel', '$status')") or die($translations["ERROR_ADD_USER"] . mysqli_error($conexao));
	?>
		<div id="meio">
			<h2><?php echo $translations["SUCCESS_ADD_USER"] ?></h2><br><br>
			<a href=frmAddUsuario.php>[<?php echo $translations["ADD_ANOTHER"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=consultarUsuario.php>[<?php echo $translations["USER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_HOME"] ?>]</a>
		</div>
	<?php
	} else {
	?>
		<div id="meio">
			<h2><?php echo $translations["ERROR_PASSWORD_BLANK"] ?></h2><br><br>
			<a href=consultarUsuario.php>[<?php echo $translations["USER_LIST"] ?>]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[<?php echo $translations["BACK_HOME"] ?>]</a>
		</div>
<?php
	}
}
require_once("foot.php");
?>