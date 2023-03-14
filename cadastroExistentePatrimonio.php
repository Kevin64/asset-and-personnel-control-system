<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/conexao.php";

$patrimonio = $_GET["patrimonio"];
?>

<div id="meio">
	<h2>Erro ao cadastrar patrimônio</h2><br><br>
	O patrimônio <strong><?php echo $patrimonio; ?></strong> já está cadastrado no banco de dados!<br><br><br>
	<a href="frmCadPatrimonio.php">[Cadastrar outro]</a><br>
	<a href="index.php">[Voltar ao início]</a>
</div>

<?php
require_once("rodape.php");
?>