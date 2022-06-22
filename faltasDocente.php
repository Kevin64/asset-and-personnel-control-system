<?php
require_once __DIR__ . '/../conexao.php';

$maisfalta = $_POST["maisfalta"];
$faltas = $_POST["faltas"];

if ($_GET) {
	if (isset($_GET['maisfalta'])) {
		maisfalta();
	} elseif (isset($_GET['menosfalta'])) {
		menosfalta();
	}
}
function maisfalta()
{
	$faltas++;
	$query = mysqli_query($conexao, "update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$maisfalta'") or die("Erro ao atualizar os dados do docente! " . mysqli_error($conexao));
}

function menosfalta()
{
	$faltas--;
	$query = mysqli_query($conexao, "update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$maisfalta'") or die("Erro ao atualizar os dados do docente! " . mysqli_error($conexao));
}

header("Location: consultarDocente.php");
