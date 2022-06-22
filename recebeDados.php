<?php
require_once("conexao.php");

$patrimonio = $_GET["patrimonio"];
$numeroLacre = $_GET["lacre"];
$sala = $_GET["sala"];
$predio = $_GET["predio"];
$ad = $_GET["ad"];
$padrao = $_GET["padrao"];
$dataFormatacao = $_GET["formatacao"];
$formatacoesAnteriores = $_GET["formatacoesAnteriores"];
$marca = $_GET["marca"];
$modelo = $_GET["modelo"];
$numeroSerial = $_GET["numeroSerial"];
$processador = $_GET["processador"];
$memoria = $_GET["memoria"];
$hd = $_GET["hd"];
$sistemaOperacional = $_GET["sistemaOperacional"];
$nomeDoComputador = $_GET["nomeDoComputador"];
$mac = $_GET["mac"];
$ip = $_GET["ip"];
$bios = $_GET["bios"];
$emUso = $_GET["emUso"];
$etiqueta = $_GET["etiqueta"];
$tipo = $_GET["tipo"];
$tipoFW = $_GET["tipoFW"];
$tipoArmaz = $_GET["tipoArmaz"];
$gpu = $_GET["gpu"];
$modoArmaz = $_GET["modoArmaz"];
$secBoot = $_GET["secBoot"];

$dataF = substr($dataFormatacao, 0, 10);
$dataExplodida = explode("/", $dataF);
$dataFormatacao = $dataExplodida[2] . "-" . $dataExplodida[1] . "-" . $dataExplodida[0];

$queryPegaPatrimonio = mysqli_query($conexao, "select * from patrimonio where patrimonio = '$patrimonio'") or die("Erro na query! " . mysqli_error($conexao));
$total = mysqli_num_rows($queryPegaPatrimonio);

if ($total >= 1) {
	$query = mysqli_query($conexao, "update patrimonio set lacre = '$numeroLacre', sala = '$sala', predio = '$predio', ad = '$ad', padrao = '$padrao', dataFormatacao = '$dataFormatacao', marca = '$marca', modelo = '$modelo', numSerie = '$numeroSerial', processador = '$processador', memoria = '$memoria', hd = '$hd', sistemaOperacional = '$sistemaOperacional', hostname = '$nomeDoComputador', bios = '$bios', mac = '$mac', ip = '$ip', emUso = '$emUso', etiqueta = '$etiqueta', tipo = '$tipo', tipoFW = '$tipoFW', tipoArmaz = '$tipoArmaz', gpu = '$gpu', modoArmaz = '$modoArmaz', secBoot = '$secBoot' where patrimonio = '$patrimonio'") or die("Erro na query de atualização! " . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "insert into manutencoes (patrimonioFK, dataFormatacoesAnteriores) values('$patrimonio', '$dataFormatacao')") or die("Erro ao incluir os dados! " . mysqli_error($conexao));
	$mensagem = "Computador já existente, dados atualizados com sucesso!";
} else {
	$query = mysqli_query($conexao, "insert into patrimonio (patrimonio, lacre, sala, predio, ad, padrao, dataFormatacao, marca, modelo, numSerie, processador, memoria, hd, sistemaOperacional, hostname, bios, mac, ip, emUso, etiqueta, tipo, tipoFW, tipoArmaz, gpu, modoArmaz, secBoot) values('$patrimonio', '$numeroLacre', '$sala', '$predio', '$ad', '$padrao', '$dataFormatacao', '$marca', '$modelo', '$numeroSerial', '$processador', '$memoria', '$hd', '$sistemaOperacional', '$nomeDoComputador', '$bios', '$mac', '$ip', '$emUso', '$etiqueta', '$tipo', '$tipoFW', '$tipoArmaz', '$gpu', '$modoArmaz', '$secBoot')") or die("Erro ao incluir os dados! " . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "insert into manutencoes (patrimonioFK, dataFormatacoesAnteriores) values('$patrimonio', '$dataFormatacao')") or die("Erro ao incluir os dados! " . mysqli_error($conexao));
	$mensagem = "Computador cadastrado com sucesso!";
}

?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body bgcolor=green>
	<center>
		<font size=3 color=white><b><?php echo $mensagem; ?></b></font>
	</center>
</body>

</html>