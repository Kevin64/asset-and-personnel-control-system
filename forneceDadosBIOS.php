<?php
require_once __DIR__ . '/../conexao.php';

$marca = $_GET["marca"];
$modelo = $_GET["modelo"];
$versao = $_GET["versao"];
$tipo = $_GET["tipo"];

$biosFile = 'bios.json';
$biosChecksum = 'bios-checksum.txt';

$query = mysql_query("select * from bios") or die ("Erro na query! ".mysql_error());
$return_arr = array();
while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
	$row_array['id'] = $row['id'];
	$row_array['marca'] = $row['marca'];
	$row_array['modelo'] = $row['modelo'];
	$row_array['versao'] = $row['versao'];
	$row_array['tipo'] = $row['tipo'];
	array_push($return_arr,$row_array);

	if(file_exists($biosFile) || file_exists($biosChecksum)) {
		unlink($biosFile);
		unlink($biosChecksum);
	}

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
<font size=3 color=white><b><?php echo $mensagem;?></b></font>
</center>
</body>
</html>

