<?php
require_once __DIR__ . '/../conexao.php';

$deletar = $_POST["chkDeletar"];

if (isset($deletar)) {
	for ($i = 0; $i < count($deletar); $i++) {
		$query = mysql_query ("delete from docente where id = '$deletar[$i]'") or die ("Erro ao deletar docente! ".mysql_error());
	}
}

header ("Location: consultarDocente.php?del=ok");
?>
