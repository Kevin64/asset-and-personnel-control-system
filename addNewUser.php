<?php
require_once("verifica.php");
require_once("top.php");
require_once __DIR__ . "/connection.php";

$usuario = $_POST["txtUsuario"];
if ($_POST["txtSenha"] != "") {
	$senha = password_hash($_POST["txtSenha"], PASSWORD_BCRYPT);
} else {
	$senha = null;
}
$nivel = $_POST["txtNivel"];
$status = $_POST["txtStatus"];

$query = mysqli_query($conexao, "select * from usuarios where usuario = '$usuario'") or die("Erro ao cadastrar novo usuário! " . mysqli_error($conexao));;
$total = mysqli_num_rows($query);

if ($total > 0) {
?>
	<div id="meio">
		<h2>Usuário já existe, utilize outro nome!</h2><br><br>
		<a href=consultarUsuario.php>[Ver lista de usuários]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[Voltar ao início]</a>
	</div>
	<?php
} else {
	if ($senha != null) {
		mysqli_query($conexao, "insert into usuarios (usuario, senha, nivel, status) values ('$usuario', '$senha', '$nivel', '$status')") or die("Erro ao cadastrar novo usuário! " . mysqli_error($conexao));
	?>
		<div id="meio">
			<h2>Novo usuário cadastrado com sucesso!</h2><br><br>
			<a href=frmAddUsuario.php>[Cadastrar outro]</a> &nbsp;&nbsp;&nbsp; <a href=consultarUsuario.php>[Ver lista de usuários]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[Voltar ao início]</a>
		</div>
	<?php
	} else {
	?>
		<div id="meio">
			<h2>Senha não pode ser em branco!</h2><br><br>
			<a href=consultarUsuario.php>[Ver lista de usuários]</a> &nbsp;&nbsp;&nbsp; <a href=index.php>[Voltar ao início]</a>
		</div>
<?php
	}
}
require_once("foot.php");
?>