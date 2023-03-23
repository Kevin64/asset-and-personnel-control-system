<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/connection.php";

$mensagem = "";

$id = null;
$usuario = $_POST["txtUsuario"];
$senhaNova = password_hash($_POST["txtSenha1"], PASSWORD_BCRYPT);
$verificaSenhaAlt = password_verify($_POST["txtSenha2"], $senhaNova);

$query = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario'") or die("Erro ao procurar usuário! " . mysqli_error($conexao));

while ($row = mysqli_fetch_array($query)) {
	$id = $row["id"];
	$senha = $row["senha"];
}

if (mysqli_num_rows($query) == 0) {
	$mensagem = "<font color=red>Usuário não existe!</font>";
} else {
	if ($_SESSION["nivel"] != "Administrador") {
		$senhaAtual = password_verify($_POST["txtSenhaAtual"], $senha);
		if ($verificaSenhaAlt) {
			if ($senha == $senhaAtual) {
				$queryTrocaSenha = mysqli_query($conexao, "update usuarios set senha = '$senhaNova' where id = '$id'") or die("Erro ao alterar senha! " . mysqli_error($conexao));
				$mensagem = "<font color=blue>Senha alterada com sucesso!</font>";
			} else {
				$mensagem = "<font color=red>Senha atual não confere!</font>";
			}
		} else {
			$mensagem = "<font color=red>As senhas digitadas são diferentes!</font>";
		}
	} else {
		if ($verificaSenhaAlt) {
			$queryTrocaSenha = mysqli_query($conexao, "update usuarios set senha = '$senhaNova' where id = '$id'") or die("Erro ao alterar senha! " . mysqli_error($conexao));
			$mensagem = "<font color=blue>Senha alterada com sucesso!</font>";
		} else {
			$mensagem = "<font color=red>As senhas digitadas são diferentes!</font>";
		}
	}
}
?>

<div id="meio">
	<h2>Alteração de senha</h2><br><br>
	<?php echo $mensagem; ?><Br><Br>
	<a href=frmTrocarSenha.php>[Voltar]</a>

</div>

<?php
require_once("foot.php");
?>