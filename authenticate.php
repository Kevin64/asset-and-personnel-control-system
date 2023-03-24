<?php
require_once("connection.php");

$enviar = $_POST["txtEnviar"];
$usuario = $_POST["txtUsuario"];
$queryResult = mysqli_query($conexao, "select senha from usuarios where usuario = '$usuario'") or die($translations["USER_NOT_EXIST"] . mysqli_error($conexao));
$obtemSenha = mysqli_fetch_assoc($queryResult);
$senha = $obtemSenha["senha"];
$verificaSenha = password_verify($_POST["txtSenha"], $senha);

if ($verificaSenha) {
	$queryAutentica = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario'") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));
	$total = mysqli_num_rows($queryAutentica);

	if ($total > 0) {
		session_start();
		while ($row = mysqli_fetch_assoc($queryAutentica)) {
			$id = $row["id"];
			$usuario = $row["usuario"];
			$nivel = $row["nivel"];
		}
		$_SESSION["id"] = $id;
		$_SESSION["usuario"] = $usuario;
		$_SESSION["nivel"] = $nivel;
		mysqli_query($conexao, "update usuarios set status = 1 where usuario = '$usuario'") or die($translations["ERROR_CHANGE_USER_STATUS"] . mysqli_error($conexao));

		header("Location: index.php");
	} else {
		header("Location: denied.php");
	}
} else {
	header("Location: denied.php");
}
