<?php
require_once ("conexao.php");

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query2 = mysql_query("delete from manutencoes where id in (select man from (select manutencoes.id as man from manutencoes inner join (select patrimonio from patrimonio where id = '$deletar[$i]') as p on p.patrimonio = manutencoes.patrimonioFK) as m)") or die ("Erro ao deletar patrimonio! ".mysql_error());
		$query = mysql_query ("delete from patrimonio where id = '$deletar[$i]'") or die ("Erro ao deletar patrimonio! ".mysql_error());
	}
}

header ("Location: consultarPatrimonio.php?del=ok");
?>
