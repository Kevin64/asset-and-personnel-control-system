<?php
session_start();
require_once("verifica.php");
require_once __DIR__ . '/../conexao.php';

if (isset($_POST["txtMarca"]))
	$marca = $_POST["txtMarca"];

if (isset($_POST["txtModelo"]))
	$modelo = $_POST["txtModelo"];

if (isset($_POST["txtVersao"]))
	$versao = $_POST["txtVersao"];

if (isset($_POST["txtTipo"]))
	$tipo = $_POST["txtTipo"];

$validaBIOS = mysqli_query($conexao, "select * from bios where modelo = '$modelo'") or die("Erro ao procurar modelo! " . mysqli_error($conexao));
$totalBIOS = mysqli_num_rows($validaBIOS);

if ($totalPatrimonio == 0) {
	//Inserir dados no banco
	mysqli_query($conexao, "insert into bios (marca, modelo, versao, tipo) values ('$marca', '$modelo', '$versao', '$tipo')") or die("Erro ao tentar cadastrar BIOS! " . mysqli_error($conexao));

	header("Location: sucessoBIOS.php");
} else
	header("Location: cadastroExistenteBIOS.php?modelo='$modelo'");
