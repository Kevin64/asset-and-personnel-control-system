<?php
require_once __DIR__ . '/../conexao.php';

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysql_query ("delete from bios where id = '$deletar[$i]'") or die ("Erro ao deletar BIOS! ".mysql_error());
	}
}

header ("Location: consultarBIOS.php?del=ok");
?>
