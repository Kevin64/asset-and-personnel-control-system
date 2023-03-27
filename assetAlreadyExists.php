<?php
require_once("verify.php");
require_once("top.php");
require_once("connection.php");

$assetNumber = $_GET["asset"];
?>

<div id="middle">
	<h2>Erro ao cadastrar patrimônio</h2><br><br>
	O patrimônio <strong><?php echo $assetNumber; ?></strong> já está cadastrado no banco de dados!<br><br><br>
	<a href="frmCadasset.php">[Cadastrar outro]</a><br>
	<a href="index.php">[Voltar ao início]</a>
</div>

<?php
require_once("foot.php");
?>