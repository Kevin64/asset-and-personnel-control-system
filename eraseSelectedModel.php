<?php
require_once("verifica.php");
require_once("topo.php");
require_once("connection.php");

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysqli_query($conexao, "delete from bios where id = '$deletar[$i]'") or die($translations["ERROR_DELETE_MODEL"] . mysqli_error($conexao));
	}
}

header("Location: queryModel.php?del=ok");
