<?php
require_once("checkSession.php");
require_once("connection.php");

if (isset($_POST["txtBrand"]))
	$brand = $_POST["txtBrand"];

if (isset($_POST["txtModel"]))
	$model = $_POST["txtModel"];

if (isset($_POST["txtVersion"]))
	$fwVersion = $_POST["txtVersion"];

if (isset($_POST["txtType"]))
	$hwType = $_POST["txtType"];

if (isset($_POST["txtTPM"]))
	$tpmVersion = $_POST["txtTPM"];

if (isset($_POST["txtMediaOp"]))
	$mediaOperationMode = $_POST["txtMediaOp"];

$validateModel = mysqli_query($connection, "select * from model where model = '$model'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$totalModel = mysqli_num_rows($validateModel);

if ($totalAsset == 0) {
	//Inserir dados no banco
	mysqli_query($connection, "insert into model (brand, model, version, type, tpm, mediaOp) values ('$brand', '$model', '$fwVersion', '$hwType', '$tpmVersion', '$mediaOperationMode')") or die($translations["ERRO_ADD_MODEL"] . mysqli_error($connection));

	header("Location: successModel.php");
} else
	header("Location: modelAlreadyExists.php?model='$model'");
