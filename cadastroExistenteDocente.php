<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/conexao.php";

$siape = $_GET["siape"];
?>

<div id="meio">
	<h2>Erro ao cadastrar docente</h2><br><br>
	O docente <strong><?php echo $siape; ?></strong> já está cadastrado no banco de dados!<br><br><br>
	<a href="frmCadDocente.php">[Cadastrar outro]</a><br>
	<a href="index.php">[Voltar ao início]</a>
</div>

<?php
require_once("rodape.php");
?>