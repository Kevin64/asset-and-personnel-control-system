<?php
require_once __DIR__ . '/../conexao.php';

$mensagem = null;

if(isset($_GET["marca"]))
	$marca = $_GET["marca"];
if(isset($_GET["modelo"]))
	$modelo = $_GET["modelo"];
if(isset($_GET["versao"]))
	$versao = $_GET["versao"];
if(isset($_GET["tipo"]))
	$tipo = $_GET["tipo"];

$biosFile = 'bios.json';
$biosChecksum = 'bios-checksum.txt';

$query = mysqli_query($conexao, "select * from bios") or die("Erro na query! " . mysqli_error($conexao));
$return_arr = array();

if (file_exists($biosFile) || file_exists($biosChecksum)) {
	unlink($biosFile);
	unlink($biosChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array['id'] = $row['id'];
	$row_array['marca'] = $row['marca'];
	$row_array['modelo'] = $row['modelo'];
	$row_array['versao'] = $row['versao'];
	$row_array['tipo'] = $row['tipo'];
	array_push($return_arr, $row_array);

	$fp = fopen($biosFile, 'w');
	fwrite($fp, json_encode($return_arr));
	$checksum = sha1(json_encode($return_arr));
	$fp2 = fopen($biosChecksum, 'w');
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