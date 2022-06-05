<?php
session_start();
require_once("verifica.php");
require_once __DIR__ . '/../conexao.php';

$patrimonio = $_POST["txtPatrimonio"];
$predio = $_POST["txtPredio"];
$sala = $_POST["txtSala"];
$descricao = $_POST["txtDescricao"];
$recebedor = $_POST["txtRecebedor"];
$siapeRecebedor = $_POST["txtSiapeRecebedor"];
$ramal = $_POST["txtRamal"];
$dataEntrega = $_POST["txtDataEntrega"];
$padrao = $_POST["txtPadrao"];
$observacao = $_POST["txtObservacao"];
$idUsuario = $_SESSION["id"];
$ultimaFormatacao = $_POST["txtUltimaFormatacao"];
//$formatacoesAnteriores = $_POST["txtFormatacoesAnteriores"];
$ad = $_POST["txtAd"];
$marca = $_POST["txtMarca"];
$modelo = $_POST["txtModelo"];
$numSerie = $_POST["txtNumSerie"];
$processador = $_POST["txtProcessador"];
$memoria = $_POST["txtMemoria"];
$hd = $_POST["txtHd"];
$sistemaOperacional = $_POST["txtSistemaOperacional"];
$hostName = $_POST["txtHostName"];
$mac = $_POST["txtMac"];
$ip = $_POST["txtIp"];
$bios = $_POST["txtBIOS"];
$emUso = $_POST["txtEmUso"];
$etiqueta = $_POST["txtEtiqueta"];
$tipo = $_POST["txtTipo"];
$tipoFW = $_POST["txtTipoFW"];
$lacre = $_POST["txtLacre"];
$tipoArmaz = $_POST["txtTipoArmaz"];
$gpu = $_POST["txtGPU"];
$modoArmaz = $_POST["txtModoArmaz"];
$secBoot = $_POST["txtSecBoot"];
$vt = $_POST["txtVT"];
$tpm = $_POST["txtTPM"];

$validaPatrimonio = mysqli_query($conexao, "select * from patrimonio where patrimonio = '$patrimonio'") or die("Erro ao procurar patrimônio! " . mysqli_error($conexao));
$totalPatrimonio = mysqli_num_rows($validaPatrimonio);

if ($totalPatrimonio == 0) {
	//Inserir dados no banco
	mysqli_query($conexao, "insert into patrimonio (patrimonio, predio, sala, descricao, nomeRecebedor, siapeRecebedor, ramal, dataEntrega, observacao, padrao, idUsuario, dataFormatacao, ad, marca, modelo, numSerie, processador, memoria, hd, sistemaOperacional, hostname, bios, mac, ip, emUso, lacre, etiqueta, tipo, tipoFW, tipoArmaz, gpu, modoArmaz, secBoot, vt, tpm) values ('$patrimonio', '$predio', '$sala', '$descricao', '$recebedor', '$siapeRecebedor', '$ramal', '$dataEntrega', '$observacao', '$padrao', '$idUsuario', '$ultimaFormatacao', '$ad', '$marca', '$modelo', '$numSerie', '$processador', '$memoria', '$hd', '$sistemaOperacional', '$hostName', '$bios', '$mac', '$ip', '$emUso', '$lacre', '$etiqueta', '$tipo', '$tipoFW', '$tipoArmaz', '$gpu', '$modoArmaz', '$secBoot', '$vt', '$tpm')") or die("Erro ao tentar cadastrar patrimônio! " . mysqli_error($conexao));
	mysqli_query($conexao, "insert into manutencoes (patrimonioFK, dataFormatacoesAnteriores) values ('$patrimonio', '$ultimaFormatacao')") or die("Erro ao tentar cadastrar patrimônio2! " . mysqli_error($conexao));

	header("Location: sucesso.php");
} else
	header("Location: cadastroExistente.php?patrimonio='$patrimonio'");
