<?php
require_once("verifica.php");
require_once("topo.php");
require_once("connection.php");

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query2 = mysqli_query($conexao, "delete from manutencoes where id in (select man from (select manutencoes.id as man from manutencoes inner join (select patrimonio from patrimonio where id = '$deletar[$i]') as p on p.patrimonio = manutencoes.patrimonioFK) as m)") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($conexao));
		$query = mysqli_query($conexao, "delete from patrimonio where id = '$deletar[$i]'") or die($translations["ERROR_DELETE_ASSET"] . mysqli_error($conexao));
	}
}

header("Location: queryAsset.php?del=ok");
