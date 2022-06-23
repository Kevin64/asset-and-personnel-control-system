<?php
require_once __DIR__ . '/../conexao.php';
require_once("topo.php");
require_once("verifica.php");

$mensagem = "";

$id = null;
$usuario = $_POST["txtUsuario"];
$senhaAtual = md5($_POST["txtSenhaAtual"]);
$senhaNova = md5($_POST["txtSenha1"]);
$senhaNova2 = md5($_POST["txtSenha2"]);

$query = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario'") or die("Erro ao procurar usuário! " . mysqli_error($conexao));

while ($row = mysqli_fetch_array($query)) {
	$id = $row['id'];
	$senha = $row['senha'];
}

if ($senhaNova == $senhaNova2) {
	if ($senha == $senhaAtual) {
		$queryTrocaSenha = mysqli_query($conexao, "update usuarios set senha = '$senhaNova' where id = '$id'") or die("Erro ao alterar senha! " . mysqli_error($conexao));
		$mensagem = "<font color=blue>Senha alterada com sucesso!</font>";
	} else {
		$mensagem = "<font color=red>Senha atual não confere!</font>";
	}
} else {
	$mensagem = "<font color=red>As senhas digitadas são diferentes!</font>";
}

?>

<div id="meio">
	<h2>Alteração de senha</h2><br><br>
	<?php echo $mensagem; ?><Br><Br>
	<a href=frmTrocarSenha.php>[Voltar]</a>

</div>

<?php
require_once("rodape.php");
?>