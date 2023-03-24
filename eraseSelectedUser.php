<?php

require_once("connection.php");

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysqli_query($conexao, "delete from usuarios where id = '$deletar[$i]'") or die($translations["ERROR_DELETE_USER"] . mysqli_error($conexao));
	}
}

header("Location: queryUser.php?del=ok");