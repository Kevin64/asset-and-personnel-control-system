<?php
require_once __DIR__ . '/../conexao.php';

$mensagem = null;

if(isset($_GET["usuario"]))
	$usuario = $_GET["usuario"];
if(isset($_GET["senha"]))
	$senha = $_GET["senha"];
if(isset($_GET["nivel"]))
	$nivel = $_GET["nivel"];
if(isset($_GET["status"]))
	$status = $_GET["status"];

$loginFile = 'login.json';
$loginChecksum = 'login-checksum.txt';

$query = mysqli_query($conexao, "select * from usuarios") or die("Erro na query! " . mysqli_error($conexao));
$return_arr = array();

if (file_exists($loginFile) || file_exists($loginChecksum)) {
	unlink($loginFile);
	unlink($loginChecksum);
}

while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$row_array['id'] = $row['id'];
	$row_array['usuario'] = $row['usuario'];
	$row_array['senha'] = $row['senha'];
	$row_array['nivel'] = $row['nivel'];
	$row_array['status'] = $row['status'];
	array_push($return_arr, $row_array);

	$fp = fopen($loginFile, 'w');
	fwrite($fp, json_encode($return_arr));
	$checksum = sha1(json_encode($return_arr));
	$fp2 = fopen($loginChecksum, 'w');
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