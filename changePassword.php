<?php
require_once("verifica.php");
require_once("topo.php");
require_once("connection.php");

$mensagem = "";

$id = null;
$usuario = $_POST["txtUsuario"];
$senhaNova = password_hash($_POST["txtSenha1"], PASSWORD_BCRYPT);
$verificaSenhaAlt = password_verify($_POST["txtSenha2"], $senhaNova);

$query = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario'") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));

while ($row = mysqli_fetch_array($query)) {
	$id = $row["id"];
	$senha = $row["senha"];
}

if (mysqli_num_rows($query) == 0) {
	$mensagem = "<font color=red>" . $translations["USER_NOT_EXIST"] . "</font>";
} else {
	if ($_SESSION["nivel"] != $json_config_array["ADMIN_LEVEL"]) {
		$senhaAtual = password_verify($_POST["txtSenhaAtual"], $senha);
		if ($verificaSenhaAlt) {
			if ($senha == $senhaAtual) {
				$queryTrocaSenha = mysqli_query($conexao, "update usuarios set senha = '$senhaNova' where id = '$id'") or die($translations["ERROR_UPDATE_PASSWORD"] . mysqli_error($conexao));
				$mensagem = "<font color=blue>" . $translations["SUCCESS_UPDATE_PASSWORD"] . "</font>";
			} else {
				$mensagem = "<font color=red>" . $translations["OLD_PASSWORD_NOT_MATCH"] . "</font>";
			}
		} else {
			$mensagem = "<font color=red>" . $translations["TWO_PASSWORD_NOT_MATCH"] . "</font>";
		}
	} else {
		if ($verificaSenhaAlt) {
			$queryTrocaSenha = mysqli_query($conexao, "update usuarios set senha = '$senhaNova' where id = '$id'") or die($translations["ERROR_UPDATE_PASSWORD"] . mysqli_error($conexao));
			$mensagem = "<font color=blue>" . $translations["SUCCESS_UPDATE_PASSWORD"] . "</font>";
		} else {
			$mensagem = "<font color=red>" . $translations["TWO_PASSWORD_NOT_MATCH"] . "</font>";
		}
	}
}
?>

<div id="meio">
	<h2><?php echo $translations["CHANGE_PASSWORD"] ?></h2><br><br>
	<?php echo $mensagem; ?><Br><Br>
	<a href=frmTrocarSenha.php>[<?php echo $translations["BACK"] ?>]</a>

</div>

<?php
require_once("foot.php");
?>