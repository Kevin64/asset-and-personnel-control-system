<?php
require_once __DIR__ . '/conexao.php';

$mensagem = null;

if(isset($_GET["patrimonio"]))
	$patrimonio = $_GET["patrimonio"];
if(isset($_GET["predio"]))
	$predio = $_GET["predio"];
if(isset($_GET["sala"]))
	$sala = $_GET["sala"];
if(isset($_GET["padrao"]))
	$padrao = $_GET["padrao"];
if(isset($_GET["ad"]))
	$ad = $_GET["ad"];
if(isset($_GET["emUso"]))
	$emUso = $_GET["emUso"];
if(isset($_GET["lacre"]))
	$lacre = $_GET["lacre"];
if(isset($_GET["etiqueta"]))
	$etiqueta = $_GET["etiqueta"];
if(isset($_GET["tipo"]))
	$tipo = $_GET["tipo"];
if(isset($_GET["descarte"]))
	$descarte = $_GET["descarte"];
if(isset($_GET["dataFormatacao"]))
	$dataFormatacao = $_GET["dataFormatacao"];

$pcFile = 'pc.json';
$pcChecksum = 'pc-checksum.txt';

$query = mysqli_query($conexao, "select * from patrimonio where patrimonio = '$patrimonio'") or die("Erro na query! " . mysqli_error($conexao));
$return_arr = array();

if (file_exists($pcFile) || file_exists($pcChecksum)) {
	unlink($pcFile);
	unlink($pcChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array['patrimonio'] = $row['patrimonio'];
	$row_array['predio'] = $row['predio'];
	$row_array['sala'] = $row['sala'];
	$row_array['padrao'] = $row['padrao'];
	$row_array['ad'] = $row['ad'];
	$row_array['emUso'] = $row['emUso'];
	$row_array['lacre'] = $row['lacre'];
	$row_array['etiqueta'] = $row['etiqueta'];
	$row_array['tipo'] = $row['tipo'];
	$row_array['descarte'] = $row['descarte'];
	$row_array['dataFormatacao'] = $row['dataFormatacao'];
	array_push($return_arr, $row_array);

	$fp = fopen($pcFile, 'w');
	$jsonCmd = json_encode($return_arr, JSON_UNESCAPED_UNICODE);
	fwrite($fp, $jsonCmd);
	$checksum = hash('sha256', $jsonCmd);
	$fp2 = fopen($pcChecksum, 'w');
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
}

if(!isset($row_array)) {
	$fp = fopen($pcFile, 'w');
	fwrite($fp, json_encode($return_arr));
	$checksum = hash('sha256', json_encode($return_arr));
	$fp2 = fopen($pcChecksum, 'w');
	fwrite($fp2, $checksum);
	fclose($fp);
	fclose($fp2);
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