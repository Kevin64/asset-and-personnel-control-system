<?php
require_once ("conexao.php");

$patrimonio = $_GET["patrimonio"];
$dataEntrega = $_GET["dataEntrega"];

$dataE = substr($dataEntrega, 0, 10);
$dataExplodida = explode("/", $dataE);
$dataEntrega = $dataExplodida[2]."-".$dataExplodida[1]."-".$dataExplodida[0];

$queryPegaPatrimonio = mysql_query("select * from patrimonio where patrimonio = '$patrimonio'") or die ("Erro na query! ".mysql_error());
$total = mysql_num_rows($queryPegaPatrimonio);

if ($total >= 1) {
	$query = mysql_query ("update patrimonio set dataEntrega = '$dataEntrega' where patrimonio = '$patrimonio'") or die ("Erro na query de atualização! ".mysql_error());
	$mensagem = "Operação concluída com êxito!";
}

//echo "<center><font size=3 color=blue>Dados Cadastrados!</center></font><br>";
//echo "<font size=1>Patrimônio: ".$patrimonio."<br>Predio: ".$predio."<br>Sala: ".$sala."<br>Padrao: ".$padrao;

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

