<?php
require_once ("verifica.php");
require_once ("conexao.php");
require_once ("topo.php");

$usuario = $_POST["txtUsuario"];
$senha = md5($_POST["txtSenha"]);
$nivel = $_POST["txtNivel"];
$status = $_POST["txtStatus"];

$query = mysql_query("insert into usuarios (usuario, senha, nivel, status) values ('$usuario', '$senha', '$nivel', '$status')") or die ("Erro ao cadastrar novo usuário! ".mysql_error());
?>

<div id="meio">
	<h2>Novo usuário cadastrado com sucesso!</h2><br><br>
	<a href=index.php>[Voltar ao início]</a>
</div>

<?php
require_once("rodape.php");
?>
