<?php
require_once("checkSession.php");
require_once("connection.php");

if (isset($_POST["txtMarca"]))
	$marca = $_POST["txtMarca"];

if (isset($_POST["txtModelo"]))
	$modelo = $_POST["txtModelo"];

if (isset($_POST["txtVersao"]))
	$versao = $_POST["txtVersao"];

if (isset($_POST["txtTipo"]))
	$tipo = $_POST["txtTipo"];

if (isset($_POST["txtTPM"]))
	$tpm = $_POST["txtTPM"];

if (isset($_POST["txtMediaOp"]))
	$mediaOp = $_POST["txtMediaOp"];

$validaBIOS = mysqli_query($conexao, "select * from bios where modelo = '$modelo'") or die($translations["ERROR_QUERY"] . mysqli_error($conexao));
$totalBIOS = mysqli_num_rows($validaBIOS);

if ($totalPatrimonio == 0) {
	//Inserir dados no banco
	mysqli_query($conexao, "insert into bios (marca, modelo, versao, tipo, tpm, mediaOp) values ('$marca', '$modelo', '$versao', '$tipo', '$tpm', '$mediaOp')") or die($translations["ERRO_ADD_MODEL"] . mysqli_error($conexao));

	header("Location: successModel.php");
} else
	header("Location: modelAlreadyExists.php?modelo='$modelo'");
