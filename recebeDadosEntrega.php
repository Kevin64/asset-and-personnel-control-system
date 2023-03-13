<?php
require_once __DIR__ . '/conexao.php';

$patrimonio = $_GET["patrimonio"];
$dataEntrega = $_GET["dataEntrega"];
$siape = $_GET["siapeRecebedor"];
$entregador = $_GET["entregador"];

$dataE = substr($dataEntrega, 0, 10);
$dataExplodida = explode("/", $dataE);
$dataEntrega = $dataExplodida[2] . "-" . $dataExplodida[1] . "-" . $dataExplodida[0];

$queryPegaPatrimonio = mysqli_query($conexao, "select * from patrimonio where patrimonio = '$patrimonio'") or die("Erro na query! " . mysqli_error($conexao));
$total = mysqli_num_rows($queryPegaPatrimonio);

if ($total >= 1) {
	$query = mysqli_query($conexao, "update patrimonio set dataEntrega = '$dataEntrega', siapeRecebedor = '$siape', entregador = '$entregador' where patrimonio = '$patrimonio'") or die("Erro na query de atualização! " . mysqli_error($conexao));
	$mensagem = "Operação concluída com êxito!";
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