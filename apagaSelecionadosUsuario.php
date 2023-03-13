<?php
require_once("verifica.php");
require_once __DIR__ . '/conexao.php';
require_once("topo.php");

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysqli_query($conexao, "delete from usuarios where id = '$deletar[$i]'") or die("Erro ao deletar usuário! " . mysqli_error($conexao));
	}
}

header("Location: consultarUsuario.php?del=ok");

?>

<?php
require_once("rodape.php");
?>
