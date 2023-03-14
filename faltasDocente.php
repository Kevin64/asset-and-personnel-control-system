<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["someAction"])) {
	maisfalta();
}

function maisfalta()
{
	require_once __DIR__ . "/conexao.php";
	$maisfalta = $_POST["maisfalta"];
	$faltas = $_POST["faltas"];

	$faltas++;
	$query = mysqli_query($conexao, "update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$maisfalta'") or die("Erro ao atualizar os dados do docente! " . mysqli_error($conexao));
}

function menosfalta()
{
	require_once __DIR__ . "/conexao.php";
	$menosfalta = $_POST["menosfalta"];
	$faltas = $_POST["faltas"];

	$faltas--;
	$query = mysqli_query($conexao, "update docente set faltas = '$faltas', data_ultima_falta = CURDATE() where id = '$menosfalta'") or die("Erro ao atualizar os dados do docente! " . mysqli_error($conexao));
}

header("Location: consultarDocente.php");
