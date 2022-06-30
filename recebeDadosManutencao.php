<?php
require_once __DIR__ . '/../conexao.php';

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
$vt = $_GET["vt"];
$tpm = $_GET["tpm"];
$trocaPilha = $_GET["trocaPilha"];
$ticketNum = $_GET["ticketNum"];
$agent = $_GET["agent"];

$dataF = substr($dataFormatacao, 0, 10);
$dataExplodida = explode("/", $dataF);
$dataFormatacao = $dataExplodida[2] . "-" . $dataExplodida[1] . "-" . $dataExplodida[0];
$dataFormatacaoExpandida = $dataFormatacao;
$modoServico = "Manutenção";

$queryPegaPatrimonio = mysqli_query($conexao, "select * from patrimonio where patrimonio = '$patrimonio'") or die("Erro na query! " . mysqli_error($conexao));
$total = mysqli_num_rows($queryPegaPatrimonio);

if ($total >= 1) {
	$query = mysqli_query($conexao, "update patrimonio set lacre = '$numeroLacre', sala = '$sala', predio = '$predio', ad = '$ad', padrao = '$padrao', dataFormatacao = '$dataFormatacao', marca = '$marca', modelo = '$modelo', numSerie = '$numeroSerial', processador = '$processador', memoria = '$memoria', hd = '$hd', sistemaOperacional = '$sistemaOperacional', hostname = '$nomeDoComputador', bios = '$bios', mac = '$mac', ip = '$ip', emUso = '$emUso', etiqueta = '$etiqueta', tipo = '$tipo', tipoFW = '$tipoFW', tipoArmaz = '$tipoArmaz', gpu = '$gpu', modoArmaz = '$modoArmaz', secBoot = '$secBoot', vt = '$vt', tpm = '$tpm', trocaPilha = '$trocaPilha', ticketNum = '$ticketNum' where patrimonio = '$patrimonio'") or die("Erro na query de atualização! " . mysqli_error($conexao));
	$queryFormatAnt = mysqli_query($conexao, "insert into manutencoes (patrimonioFK, dataFormatacoesAnteriores, modoServico, trocaPilha, ticketNum, agent) values('$patrimonio', '$dataFormatacaoExpandida', '$modoServico', '$trocaPilha', '$ticketNum', '$agent')") or die("Erro ao incluir os dados! " . mysqli_error($conexao));
	$mensagem = "Computador já existente, dados atualizados com sucesso!";
}
?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body bgcolor=green>
	<center>
		<hr style="height:0pt; visibility:hidden;" />
		<font size=3 color=white><b><?php echo $mensagem; ?></b></font>
		</td>
	</center>
</body>

</html>