<?php
require_once ("conexao.php");

$maisfalta = $_POST["maisfalta"];
$faltas = $_POST["faltas"];

if($_GET) {
	if(isset($_GET['maisfalta'])){
		maisfalta();
	} elseif(isset($_GET['menosfalta'])){
		menosfalta();
	}
}
function maisfalta() {
	$faltas++;
	$query = mysql_query("update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$maisfalta'") or die ("Erro ao atualizar os dados do docente! ".mysql_error());
}

function menosfalta() {
	$faltas--;
	$query = mysql_query("update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$maisfalta'") or die ("Erro ao atualizar os dados do docente! ".mysql_error());
}



//if (isset($maisfalta)) {
//	$faltas++;
//	$query = mysql_query("update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$maisfalta'") or die ("Erro ao atualizar os dados do docente! ".mysql_error());
//}

header ("Location: consultarDocente.php");
?>
