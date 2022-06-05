<?php
session_start();
require_once("verifica.php");
require_once __DIR__ . '/../conexao.php';

$siape = $_POST["txtSiape"];
$nome = $_POST["txtNome"];
$email = $_POST["txtEmail"];
$ramal = $_POST["txtRamal"];
$celular = $_POST["txtCelular"];
$curso = $_POST["txtCurso"];
$sala = $_POST["txtSala"];

$validaDocente = mysqli_query($conexao, "select * from docente where siape = '$siape'") or die("Erro ao procurar docente! " . mysqli_error($conexao));
$totalDocente = mysqli_num_rows($validaDocente);

if ($totalDocente == 0) {
	//Inserir dados no banco
	mysqli_query($conexao, "insert into docente (siape, nome, email, ramal, celular, curso, sala) values ('$siape', '$nome', '$email', '$ramal', '$celular', '$curso', '$sala')") or die("Erro ao tentar cadastrar docente! " . mysqli_error($conexao));

	header("Location: sucessoDocente.php");
} else
	header("Location: cadastroExistenteDocente.php?siape='$siape'");
