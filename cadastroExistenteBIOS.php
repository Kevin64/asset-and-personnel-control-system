<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/conexao.php";

$modelo = $_GET["modelo"];
?>

<div id="meio">
	<h2>Erro ao cadastrar BIOS</h2><br><br>
	O modelo <strong><?php echo $modelo; ?></strong> já está cadastrado no banco de dados!<br><br><br>
	<a href="frmCadBIOS.php">[Cadastrar outro]</a><br>
	<a href="index.php">[Voltar ao início]</a>
</div>

<?php
require_once("rodape.php");
?>