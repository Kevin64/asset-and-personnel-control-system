<?php

require_once __DIR__ . "/conexao.php";

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysqli_query($conexao, "delete from usuarios where id = '$deletar[$i]'") or die("Erro ao deletar usuário! " . mysqli_error($conexao));
	}
}

header("Location: consultarUsuario.php?del=ok");