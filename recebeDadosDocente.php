<?php
require_once ("conexao.php");

$siape = $_GET["siape"];
$nome = $_GET["nome"];
$email = strtoupper($_GET["email"]);
$ramal = strtoupper($_GET["ramal"]);
$celular = strtoupper($_GET["celular"]);
$curso = strtoupper($_GET["curso"]);
$sala = strtoupper($_GET["sala"]);
$faltas = strtoupper($_GET["faltas"]);
$data_ultima_falta = strtoupper($_GET["data_ultima_falta"]);

$queryPegaDocente = mysql_query("select * from docente where siape = '$siape'") or die ("Erro na query! ".mysql_error());
$total = mysql_num_rows($queryPegaDocente);

if ($total >= 1) {
	$query = mysql_query ("update docente set siape = '$siape', nome = '$nome', email = '$email', ramal = '$ramal', celular = '$celular', curso = '$curso', sala = '$sala', faltas = '$faltas', data_ultima_falta = '$data_ultima_falta'") or die ("Erro na query de atualização! ".mysql_error());
	$mensagem = "Dados atualizados com sucesso!";
} else {
$query = mysql_query("insert into docente (siape, nome, email, ramal, celular, curso, sala) values('$siape', '$nome', '$email', '$ramal', '$celular', '$curso', '$sala', '$faltas', '$data_ultima_falta')") or die ("Erro ao incluir os dados! ".mysql_error());
	$mensagem = "Dados Cadastrados!";
}

//echo "<center><font size=3 color=blue>Dados Cadastrados!</center></font><br>";
//echo "<font size=1>Patrimônio: ".$patrimonio."<br>Predio: ".$predio."<br>Sala: ".$sala."<br>Padrao: ".$padrao;

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title></title>
</head>
<body bgcolor=blue>
<center>
<font size=3 color=white><b><?php echo $mensagem;?></b></font>
</center>
</body>
</html>

