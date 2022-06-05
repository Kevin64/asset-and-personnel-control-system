<?php
require_once __DIR__ . '/../conexao.php';
include '../conexao.php';

$enviar = $_POST["txtEnviar"];
$usuario = $_POST["txtUsuario"];
$senha = md5($_POST["txtSenha"]);
$queryAutentica = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario' and senha = '$senha'") or die ("Erro na autenticação do usuário! ".mysqli_error($conexao));
$total = mysqli_num_rows($queryAutentica);

if ($total > 0) {
	session_start();
	while($row = mysqli_fetch_assoc($queryAutentica)) {
		$id = $row['id'];
		$usuario = $row['usuario'];
		$nivel = $row['nivel'];
	}
	$_SESSION["id"] = $id;
	$_SESSION["usuario"] = $usuario;
	$_SESSION["nivel"] = $nivel;
	mysqli_query($conexao, "update usuarios set status = 1 where usuario = '$usuario'") or die ("Erro ao tentar mudar status do usuário! ".mysqli_error($conexao));

	header("Location: index.php");
} else {
	header("Location: negado.php");
}

?>
