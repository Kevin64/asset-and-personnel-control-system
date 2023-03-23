<?php
require_once("verifica.php");
require_once("topo.php");
require_once __DIR__ . "/connection.php";

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysqli_query($conexao, "delete from bios where id = '$deletar[$i]'") or die("Erro ao deletar BIOS! " . mysqli_error($conexao));
	}
}

header("Location: queryModel.php?del=ok");
