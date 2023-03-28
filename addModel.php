<?php
require_once("checkSession.php");
require_once("connection.php");

if (isset($_POST["txtBrand"]))
	$brand = $_POST["txtBrand"];

if (isset($_POST["txtModel"]))
	$model = $_POST["txtModel"];

if (isset($_POST["txtFwVersion"]))
	$fwVersion = $_POST["txtFwVersion"];

if (isset($_POST["txtFwType"]))
	$fwType = $_POST["txtFwType"];

if (isset($_POST["txtTpmVersion"]))
	$tpmVersion = $_POST["txtTpmVersion"];

if (isset($_POST["txtMediaOperationMode"]))
	$mediaOperationMode = $_POST["txtMediaOperationMode"];

$validateModel = mysqli_query($connection, "select * from model where model = '$model'") or die($translations["ERROR_QUERY"] . mysqli_error($connection));
$totalModel = mysqli_num_rows($validateModel);

if ($totalAsset == 0) {
	//Inserir dados no banco
	mysqli_query($connection, "insert into model (brand, model, fwVersion, fwType, tpmVersion, mediaOperationMode) values ('$brand', '$model', '$fwVersion', '$fwType', '$tpmVersion', '$mediaOperationMode')") or die($translations["ERRO_ADD_MODEL"] . mysqli_error($connection));

	header("Location: successModel.php");
} else
	header("Location: modelAlreadyExists.php?model='$model'");
