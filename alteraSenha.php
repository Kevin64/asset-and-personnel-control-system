<?php
require_once __DIR__ . '/../conexao.php';
require_once ("topo.php");
require_once ("verifica.php");

$mensagem = "";

$senhaAtual = md5($_POST["txtSenhaAtual"]);
$senhaNova = md5($_POST["txtSenha1"]);
$senhaNova2 = md5($_POST["txtSenha2"]);

$query = mysql_query ("select * from usuarios where senha = '$senhaAtual'") or die ("erro ao procurar Senha! ".mysql_error());
$total = mysql_num_rows($query);
$id = mysql_result($query, 0, "id");

if ($senhaNova == $senhaNova2) {
	if ($total >= 1) {
		$queryTrocaSenha = mysql_query ("update usuarios set senha = '$senhaNova' where id = '$id'") or die ("Erro ao alterar as senhas! ".mysql_error());
		$mensagem = "<font size=2 color=blue face=verdana>Senha alterada com sucesso!</font>";
	} else {
		$mensagem = "<font size=2 color=red face=verdana>Senha atual não confere!</font>";
	}
} else {
	$mensagem = "<font size=2 color=red face=verdana>As senhas digitadas são diferentes!</font>";
}

?>

<div id="meio">
	<h2>Alteração de senha</h2><br><br>
	<?php echo $mensagem;?><Br><Br>
	<a href=frmTrocarSenha.php>[Voltar]</a>

</div>

<?php
require_once ("rodape.php");
?>
