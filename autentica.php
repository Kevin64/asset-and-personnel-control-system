<?php
require_once __DIR__ . '/../conexao.php';

$enviar = $_POST["txtEnviar"];
$usuario = $_POST["txtUsuario"];
$senha = md5($_POST["txtSenha"]);

$queryAutentica = mysql_query("select * from usuarios where usuario = '$usuario' and senha = '$senha'") or die ("Erro na autenticação do usuário! ".mysql_error());
$total = mysql_num_rows($queryAutentica);
if ($total > 0) {
	session_start();
	$_SESSION["id"] = mysql_result($queryAutentica, 0, "id");
	$_SESSION["usuario"] = mysql_result($queryAutentica, 0, "usuario");
	$_SESSION["nivel"] = mysql_result($queryAutentica, 0, "nivel");

	mysql_query("update usuarios set status = 1 where usuario = '$usuario'") or die ("Erro ao tentar mudar status do usuário! ".mysql_error());

	header("Location: index.php");
} else {
	header("Location: negado.php");
}

?>
