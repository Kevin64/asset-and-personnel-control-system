<?php
require_once("checkSession.php");
require_once("connection.php");

$siape = $_POST["txtSiape"];
$tipoServidor = $_POST["txtTipoServidor"];
$nome = $_POST["txtNome"];
$email = $_POST["txtEmail"];
$ramal = $_POST["txtRamal"];
$celular = $_POST["txtCelular"];
$curso = $_POST["txtCurso"];
$sala = $_POST["txtSala"];

$validaDocente = mysqli_query($conexao, "select * from docente where siape = '$siape'") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));
$totalDocente = mysqli_num_rows($validaDocente);

if ($totalDocente == 0) {
	mysqli_query($conexao, "insert into docente (siape, tipoServidor, nome, email, ramal, celular, curso, sala) values ('$siape', '$tipoServidor', '$nome', '$email', '$ramal', '$celular', '$curso', '$sala')") or die($translations["ERROR_ADD_TEACHER"] . mysqli_error($conexao));

	header("Location: successTeacher.php");
} else
	header("Location: teacherAlreadyExists.php?siape='$siape'");
