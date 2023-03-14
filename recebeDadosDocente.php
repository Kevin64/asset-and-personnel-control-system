<?php
require_once __DIR__ . "/conexao.php";

$siape = $_GET["siape"];
$nome = $_GET["nome"];
$email = strtoupper($_GET["email"]);
$ramal = strtoupper($_GET["ramal"]);
$celular = strtoupper($_GET["celular"]);
$curso = strtoupper($_GET["curso"]);
$sala = strtoupper($_GET["sala"]);
$faltas = strtoupper($_GET["faltas"]);
$data_ultima_falta = strtoupper($_GET["data_ultima_falta"]);

$queryPegaDocente = mysqli_query($conexao, "select * from docente where siape = '$siape'") or die("Erro na query! " . mysqli_error($conexao));
$total = mysqli_num_rows($queryPegaDocente);

if ($total >= 1) {
	$query = mysqli_query($conexao, "update docente set siape = '$siape', nome = '$nome', email = '$email', ramal = '$ramal', celular = '$celular', curso = '$curso', sala = '$sala', faltas = '$faltas', data_ultima_falta = '$data_ultima_falta'") or die("Erro na query de atualização! " . mysqli_error($conexao));
	$mensagem = "Dados atualizados com sucesso!";
} else {
	$query = mysqli_query($conexao, "insert into docente (siape, nome, email, ramal, celular, curso, sala) values('$siape', '$nome', '$email', '$ramal', '$celular', '$curso', '$sala', '$faltas', '$data_ultima_falta')") or die("Erro ao incluir os dados! " . mysqli_error($conexao));
	$mensagem = "Dados Cadastrados!";
}

?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title></title>
</head>

<body bgcolor=blue>
	<center>
		<font size=3 color=white><b><?php echo $mensagem; ?></b></font>
	</center>
</body>

</html>