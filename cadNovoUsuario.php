<?php
session_start();
require_once("topo.php");
require_once("verifica.php");
require_once __DIR__ . '/../conexao.php';

$usuario = $_POST["txtUsuario"];
$senha = md5($_POST["txtSenha"]);
$nivel = $_POST["txtNivel"];
$status = $_POST["txtStatus"];

$query = mysqli_query($conexao, "insert into usuarios (usuario, senha, nivel, status) values ('$usuario', '$senha', '$nivel', '$status')") or die("Erro ao cadastrar novo usuário! " . mysqli_error($conexao));

?>

<div id="meio">
	<h2>Novo usuário cadastrado com sucesso!</h2><br><br>
	<a href=index.php>[Voltar ao início]</a>
</div>

<?php
require_once("rodape.php");
?>